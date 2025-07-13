<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKonten extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul_konten',
        'tanggal_publikasi',
        'status',
        'waktu_di_buat',
        'platform',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function fileKontens()
    {
        return $this->hasMany(FileKonten::class, 'id_jadwal');
    }

    public function analisisJadwals()
    {
        return $this->hasMany(AnalisisJadwal::class);
    }
}
