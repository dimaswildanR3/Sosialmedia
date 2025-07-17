<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\JadwalKonten;

public function exportExcel(Request $request)
{
    // Ambil parameter filter tanggal
    $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
    $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

    // Query dengan relasi kategori & user
    $query = JadwalKonten::with(['kategori', 'user']);

    // Filter data jika role user
    if (auth()->user()->role === 'user') {
        $query->where('user_id', auth()->id());
    }

    if ($startDate && $endDate) {
        $query->whereBetween('tanggal_postingan', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->whereDate('tanggal_postingan', '>=', $startDate);
    } elseif ($endDate) {
        $query->whereDate('tanggal_postingan', '<=', $endDate);
    }

    $jadwals = $query->orderBy('tanggal_postingan', 'asc')->get();

    // Rekap per bulan berdasarkan tanggal_postingan
    $byMonth = $jadwals->groupBy(function ($item) {
        return Carbon::parse($item->tanggal_postingan)->translatedFormat('F Y'); // ex: Januari 2025
    })->map->count();

    // Susun array data untuk Excel
    $data = [];

    // Header data utama
    $data[] = ['Judul Konten', 'Kategori', 'User', 'Tanggal Postingan', 'Caption', 'Akun Ditandai', 'Hashtag', 'Status'];

    // Data utama konten
    foreach ($jadwals as $jadwal) {
        $data[] = [
            $jadwal->judul_konten,
            $jadwal->kategori->nama_kategori ?? '-',
            $jadwal->user->name ?? '-',
            Carbon::parse($jadwal->tanggal_postingan)->format('d-m-Y H:i'),
           trim(strip_tags($jadwal->caption))
            $jadwal->akun_ditandai ?? '-',
            $jadwal->hastag ?? '-',
            ucfirst($jadwal->status),
        ];
    }

    // Spacer
    $data[] = [];
    $data[] = ['Rekapitulasi Total Postingan per Bulan'];
    $data[] = ['Bulan', 'Total Postingan'];

    foreach ($byMonth as $bulan => $jumlah) {
        $data[] = [$bulan, $jumlah];
    }

    // Export ke Excel
    return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
        protected $data;
        public function __construct(array $data) {
            $this->data = $data;
        }
        public function array(): array {
            return $this->data;
        }
    }, 'laporan_jadwal_konten.xlsx');
}

