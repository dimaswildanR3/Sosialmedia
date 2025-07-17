<?php

namespace App\Http\Controllers;

use App\Models\JadwalKonten;
use App\Models\Kategori;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalKontenController extends Controller
{
    /**
     * Tampilkan semua jadwal konten.
     */
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Admin lihat semua data
        $jadwals = JadwalKonten::with(['user', 'kategori'])
            ->orderBy('tanggal_postingan', 'desc')
            ->paginate(10);
    } else if ($user->role === 'user') {
        // User biasa hanya lihat data sendiri
        $jadwals = JadwalKonten::with(['user', 'kategori'])
            ->where('user_id', $user->id)
            ->orderBy('tanggal_postingan', 'desc')
            ->paginate(10);
    } else {
        // Jika role lain (opsional), bisa kasih handling khusus atau redirect
        abort(403, 'Unauthorized');
    }

    return view('jadwal_kontens.index', compact('jadwals'));
}

    /**
     * Form tambah jadwal konten.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('jadwal_kontens.create', compact('kategoris'));
    }

    /**
     * Simpan jadwal konten baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'        => 'required|exists:kategoris,id',
            'judul_konten' => 'required|string|max:255',
            'tanggal_postingan'  => 'required|date|after_or_equal:today',
            'caption'            => 'required|string',
            'akun_ditandai'      => 'nullable|string',
            'hastag'             => 'nullable|string',
        ]);

        $validated['user_id']      = auth()->id(); // Otomatis user login
        $validated['status']       = 'scheduled';
        $validated['waktu_dibuat'] = now();

        $jadwal = JadwalKonten::create($validated);

        // Buat notifikasi untuk user
        Notification::create([
            'user_id' => auth()->id(),
            'message' => 'Konten telah dijadwalkan untuk tanggal ' . $jadwal->tanggal_postingan,
        ]);

        return redirect()->route('jadwal_kontens.index')->with('success', 'Jadwal konten berhasil dibuat');
    }

    /**
     * Form edit jadwal konten.
     */
    public function edit($id)
    {
        $jadwal = JadwalKonten::findOrFail($id);
        $kategoris = Kategori::all();

        return view('jadwal_kontens.edit', compact('jadwal', 'kategoris'));
    }

    /**
     * Update data jadwal konten.
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalKonten::findOrFail($id);

        $validated = $request->validate([
            'kategori_id'        => 'required|exists:kategoris,id',
            'judul_konten' => 'required|string|max:255',
            'tanggal_postingan'  => 'required|date',
            'caption'            => 'required|string',
            'akun_ditandai'      => 'nullable|string',
            'hastag'             => 'nullable|string',
        ]);

        $jadwal->update($validated);

        return redirect()->route('jadwal_kontens.index')->with('success', 'Jadwal konten berhasil diperbarui');
    }

    /**
     * Hapus jadwal konten.
     */
    public function destroy($id)
    {
        JadwalKonten::findOrFail($id)->delete();

        return redirect()->route('jadwal_kontens.index')->with('success', 'Jadwal konten berhasil dihapus');
    }

    /**
     * Update status (scheduled/published/failed)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:scheduled,published,failed'
        ]);

        $jadwal = JadwalKonten::findOrFail($id);
        $jadwal->status = $request->status;
        $jadwal->save();

        return redirect()->route('jadwal_kontens.index')->with('success', 'Status berhasil diperbarui');
    }

    /**
     * Tampilkan kalender jadwal konten.
     */
    public function kalender(Request $request)
    {
        $bulan = $request->get('bulan') ?? date('m');
        $tahun = $request->get('tahun') ?? date('Y');
    
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
    
        $query = JadwalKonten::with('kategori')
            ->whereBetween('tanggal_postingan', [$startOfMonth, $endOfMonth]);
    
        $user = Auth::user();
        if ($user->role !== 'admin') {
            // Kalau bukan admin, batasi data hanya untuk user yg login
            $query->where('user_id', $user->id);
        }
    
        $jadwals = $query->get()
            ->groupBy(fn ($item) => Carbon::parse($item->tanggal_postingan)->format('Y-m-d'));
    
        return view('jadwal_kontens.kalender', compact('jadwals', 'startOfMonth', 'bulan', 'tahun'));
    }
}
