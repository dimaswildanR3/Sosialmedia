<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileKonten extends Model
{
    protected $table = 'file_konten';

    protected $fillable = [
        'id_jadwal',
        'nama_file',
        'url_file',
        'tipe_file',
    ];

    public function jadwalKonten()
    {
        return $this->belongsTo(JadwalKonten::class, 'id_jadwal');
    }
}
