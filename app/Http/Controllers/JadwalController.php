<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Gallery;
use App\Models\Bidan;
use App\Models\Jadwal;
use App\Models\OrangTua;
use App\Models\Penimbangan;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
        
    //     $jadwal = Jadwal::orderBy('tanggal_kegiatan','ASC')->get();

    //     foreach ($jadwal as $item) {
    //         if ($item->bidan_id && $item->bidan) {
    //             $item->nama_kegiatan = $item->bidan->nama_lengkap;
    //         }
    //     }
    //     $timbangan = Penimbangan::with('balita')->orderBy('tanggal_timbang','ASC')->paginate(100);
    //     $balita = Balita::all();
    //     $bidans = Bidan::all();
    //     $countBalita = count($balita);
    //     $chart = [];
    //     $tinggiBadan = [];
    //     $beratBadan = [];
    //     foreach($timbangan as $mp){
    //         $chart[]= $mp->balita->nama_balita;
    //         $beratBadan[]= $mp->bb;
    //         $tinggiBadan[]= $mp->tb;
    //     }

    //     $jenisKelaminLaki = Balita::where('jenis_kelamin','Laki-laki')->get();
    //     $laki[] = count($jenisKelaminLaki);
        
    //     $jenisKelaminPerem = Balita::where('jenis_kelamin','Perempuan')->get();
    //     $perem[] = count($jenisKelaminPerem);

    //     $gallery = Gallery::all();

    //     return view('welcome',compact('jadwal',
    //         'countBalita',
    //         'timbangan',
    //         'chart',
    //         'tinggiBadan',
    //         'beratBadan',
    //         'gallery',
    //         'balita',
    //         'bidans',
    //         'laki',
    //         'perem',
    //     ));
    // }

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
