<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori','warna'];

    public function jadwalKontens()
    {
        return $this->hasMany(JadwalKonten::class);
    }
}
