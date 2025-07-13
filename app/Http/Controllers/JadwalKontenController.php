<?php

namespace App\Http\Controllers;

use App\Models\JadwalKonten;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalKontenController extends Controller
{
    public function index()
    {
        $jadwals = JadwalKonten::with(['user', 'kategori'])->paginate(10);
        return view('jadwal_kontens.index', compact('jadwals'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $users = User::all();

        return view('jadwal_kontens.create', compact('kategoris', 'users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_konten' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date|after_or_equal:today',
            'platform' => 'nullable|string',
            // status dihilangkan dari validasi karena ditentukan otomatis
        ]);
    
        // Set nilai default untuk status dan waktu
        $validated['status'] = 'scheduled';
        $validated['waktu_di_buat'] = now();
    
        // Simpan ke database
        JadwalKonten::create($validated);
    
        return redirect()->route('jadwal_kontens.index')->with('success', 'Jadwal konten berhasil dibuat');
    }
    
    

    public function edit($id)
    {
        $jadwal = JadwalKonten::findOrFail($id);
        $kategoris = Kategori::all();
        $users = User::all();

        return view('jadwal_kontens.edit', compact('jadwal', 'kategoris', 'users'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKonten::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_konten' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date',
            'platform' => 'nullable',
            // 'status' => 'required|in:scheduled,published,failed',
            // 'waktu_di_buat' => 'required|date',
        ]);

        $jadwal->update($validated);

        return redirect()->route('jadwal_kontens.index')->with('success', 'Jadwal konten berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKonten::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal_kontens.index')->with('success', 'Jadwal konten berhasil dihapus');
    }

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

public function welcome()
{
    // Ambil semua konten dengan status 'published' saja, termasuk relasi user, kategori, dan fileKontens
    $jadwals = JadwalKonten::with(['user', 'kategori', 'fileKontens'])
                ->where('status', 'published')
                ->orderBy('tanggal_publikasi', 'desc')
                ->get();

    return view('welcome', compact('jadwals'));
}




}
