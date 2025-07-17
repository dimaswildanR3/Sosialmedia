<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\JadwalKonten;
use Maatwebsite\Excel\Facades\Excel;

class LaporanJadwalKontenController extends Controller
{
    public function exportExcel(Request $request)
    {
        // Ambil data dengan relasi kategori
        $jadwals = JadwalKonten::with('kategori')->get();

        // Rekap per bulan
        $byMonth = $jadwals->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_publikasi)->format('Y-m');
        })->map->count();

        // Susun array data
        $data = [];

        // Header
        $data[] = ['Judul', 'Kategori', 'Tanggal Publikasi', 'Status', 'Platform'];

        // Data konten
        foreach ($jadwals as $jadwal) {
            $data[] = [
                $jadwal->judul_konten,
                $jadwal->kategori->nama_kategori ?? '-',
                $jadwal->tanggal_publikasi,
                ucfirst($jadwal->status),
                $jadwal->platform ?? '-', // tambahkan kolom platform
            ];
        }

        // Spacer dan rekap bulanan
        $data[] = [];
        $data[] = ['Rekapitulasi Total Postingan per Bulan'];
        $data[] = ['Bulan', 'Total Postingan'];

        foreach ($byMonth as $bulan => $jumlah) {
            $data[] = [$bulan, $jumlah];
        }

        // Ekspor ke Excel
        return Excel::download(
            new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
                protected $data;
                public function __construct(array $data) {
                    $this->data = $data;
                }
                public function array(): array {
                    return $this->data;
                }
            },
            'laporan_jadwal_konten.xlsx'
        );
    }

    public function showForm()
    {
        return view('laporan.jadwal_konten'); // Pastikan nama view sesuai
    }
}
