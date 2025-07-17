<?php

namespace App\Http\Controllers;

// use App\Models\Postingan;
use App\Models\FileKonten;
use App\Models\JadwalKonten;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $jumlahMasuk = Keuangan::sum('pemasukan');
        // $jumlahKeluar = Keuangan::sum('pengeluaran');
        // $saldo = $jumlahMasuk - $jumlahKeluar;
        $balita = JadwalKonten::all();
        $jumlahBalita = count($balita);
        return view('dashboard', [
            'jumlahPostingan' => JadwalKonten::count(),
            'jumlahKategori' => Kategori::count(),
            'jumlahUser' => User::count(),
            'jumlahFileKonten' => FileKonten::count(),
            'jumlahJadwalAktif' => JadwalKonten::where('status', 'aktif')->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
