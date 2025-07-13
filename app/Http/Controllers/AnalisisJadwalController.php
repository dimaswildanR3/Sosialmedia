<?php
namespace App\Http\Controllers;

use App\Models\AnalisisJadwal;
use App\Models\JadwalKonten;
use App\Models\User;
use Illuminate\Http\Request;

class AnalisisJadwalController extends Controller
{
    public function index()
    {
        $analisis = AnalisisJadwal::with(['jadwalKonten', 'user'])->paginate(10);
        return view('analisis_jadwals.index', compact('analisis'));
    }

    public function create()
    {
        $jadwals = JadwalKonten::all();
        $users = User::all();  // ambil semua user untuk dropdown
        return view('analisis_jadwals.create', compact('jadwals', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_konten_id' => 'required|exists:jadwal_kontens,id',
            'user_id' => 'required|exists:users,id',
            'isi_laporan' => 'required|string',
            'tanggal_laporan' => 'nullable|date',
            'status_laporan' => 'required|in:pending,approved,rejected',
        ]);

        AnalisisJadwal::create($validated);

        return redirect()->route('analisis_jadwals.index')->with('success', 'Laporan analisis berhasil disimpan');
    }
    public function edit($id)
{
    $analisis = AnalisisJadwal::findOrFail($id);
    $jadwals = JadwalKonten::all();
    $users = User::all();

    return view('analisis_jadwals.edit', compact('analisis', 'jadwals', 'users'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'jadwal_konten_id' => 'required|exists:jadwal_kontens,id',
        'user_id' => 'required|exists:users,id',
        'isi_laporan' => 'required|string',
        'tanggal_laporan' => 'nullable|date',
        // Status tidak diupdate lewat form edit ini (sesuai permintaan), kalau mau bisa dihapus
    ]);

    $analisis = AnalisisJadwal::findOrFail($id);
    $analisis->update($validated);

    return redirect()->route('analisis_jadwals.index')->with('success', 'Laporan analisis berhasil diupdate');
}

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status_laporan' => 'required|in:pending,approved,rejected',
    ]);

    $analisis = AnalisisJadwal::findOrFail($id);
    $analisis->status_laporan = $request->status_laporan;
    $analisis->save();

    return redirect()->route('analisis_jadwals.index')->with('success', 'Status laporan berhasil diubah');
}

}
