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
    // Ambil filter tanggal dari request
    $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
    $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

    // Query jadwal konten berdasarkan tanggal_postingan
    $query = JadwalKonten::with('kategori', 'user');

    // Jika user login dengan role 'user', batasi pencarian berdasarkan user_id
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

    // Rekap per bulan (tanggal_postingan)
    $byMonth = $jadwals->groupBy(function ($item) {
        return Carbon::parse($item->tanggal_postingan)->translatedFormat('F Y');
    })->map->count();

    // Siapkan data array untuk Excel
    $data = [];

    // Header kolom
    $data[] = [
        'No', 
        'Judul Konten', 
        'Kategori', 
        'User', 
        'Tanggal Postingan', 
        'Caption', 
        'Akun Ditandai', 
        'Hashtag', 
        'Status'
    ];

    // Isi data
    $no = 1;
    foreach ($jadwals as $jadwal) {
        $data[] = [
            $no++,
            $jadwal->judul_konten,
            $jadwal->kategori->nama_kategori ?? '-',
            $jadwal->user->name ?? '-',
            Carbon::parse($jadwal->tanggal_postingan)->format('d-m-Y H:i'),
            $jadwal->caption,
            $jadwal->akun_ditandai ?? '-',
            $jadwal->hastag ?? '-',
            ucfirst($jadwal->status)
        ];
    }

    // Tambahkan rekap per bulan
    $data[] = [];
    $data[] = ['Rekapitulasi Total Postingan per Bulan'];
    $data[] = ['Bulan', 'Total Postingan'];

    foreach ($byMonth as $bulan => $jumlah) {
        $data[] = [$bulan, $jumlah];
    }

    // Download file Excel
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
        return view('laporan.jadwal_konten'); 
    }
}
