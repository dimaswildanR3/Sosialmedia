<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisJadwal extends Model
{
    protected $fillable = [
        'jadwal_konten_id',
        'user_id',
        'isi_laporan',
        'tanggal_laporan',
        'status_laporan',
    ];

    public function jadwalKonten()
    {
        return $this->belongsTo(JadwalKonten::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
