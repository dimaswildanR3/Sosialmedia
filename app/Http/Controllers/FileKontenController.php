<?php
namespace App\Http\Controllers;

use App\Models\FileKonten;
use App\Models\JadwalKonten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileKontenController extends Controller
{
    public function index()
    {
        $files = FileKonten::with('jadwalKonten')->paginate(10);
        return view('file_kontens.index', compact('files'));
    }

    public function create()
    {
        $jadwals = JadwalKonten::all();
        return view('file_kontens.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_konten_id' => 'required|exists:jadwal_kontens,id',
            'nama_file' => 'required|string|max:255',
            'tipe_file' => 'required|string|max:255',
            'url_file' => 'required|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
        ]);

        $path = $request->file('url_file')->store('uploads/file_konten', 'public');

        FileKonten::create([
            'id_jadwal' => $validated['jadwal_konten_id'],
            'nama_file' => $validated['nama_file'],
            'tipe_file' => $validated['tipe_file'],
            'url_file' => $path,
        ]);

        return redirect()->route('file_kontens.index')->with('success', 'File konten berhasil disimpan');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $file = FileKonten::findOrFail($id);
        $jadwals = JadwalKonten::all();
        return view('file_kontens.edit', compact('file', 'jadwals'));
    }

    // Proses update data
    public function update(Request $request, $id)
    {
        $file = FileKonten::findOrFail($id);

        $validated = $request->validate([
            'jadwal_konten_id' => 'required|exists:jadwal_kontens,id',
            'nama_file' => 'required|string|max:255',
            'tipe_file' => 'required|string|max:255',
            'url_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
        ]);

        // Jika ada file baru diupload, hapus file lama dan simpan yang baru
        if ($request->hasFile('url_file')) {
            if ($file->url_file && Storage::disk('public')->exists($file->url_file)) {
                Storage::disk('public')->delete($file->url_file);
            }
            $path = $request->file('url_file')->store('uploads/file_konten', 'public');
        } else {
            $path = $file->url_file; // pakai file lama jika tidak upload baru
        }

        $file->update([
            'id_jadwal' => $validated['jadwal_konten_id'],
            'nama_file' => $validated['nama_file'],
            'tipe_file' => $validated['tipe_file'],
            'url_file' => $path,
        ]);

        return redirect()->route('file_kontens.index')->with('success', 'File konten berhasil diupdate');
    }

    // Hapus file dan data
    public function destroy($id)
    {
        $file = FileKonten::findOrFail($id);

        // Hapus file fisik jika ada
        if ($file->url_file && Storage::disk('public')->exists($file->url_file)) {
            Storage::disk('public')->delete($file->url_file);
        }

        $file->delete();

        return redirect()->route('file_kontens.index')->with('success', 'File konten berhasil dihapus');
    }
}
