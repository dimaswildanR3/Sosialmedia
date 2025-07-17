<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Promosi', 'warna' => '#ff6b6b'],
            ['nama_kategori' => 'Edukasi', 'warna' => '#4dabf7'],
            ['nama_kategori' => 'Interaktif', 'warna' => '#f06595'],
            ['nama_kategori' => 'Inspiratif', 'warna' => '#51cf66'],
            ['nama_kategori' => 'Hiburan', 'warna' => '#fcc419'],
            ['nama_kategori' => 'Branding', 'warna' => '#845ef7'],
            ['nama_kategori' => 'Reminder', 'warna' => '#ff922b'],
        ];

        DB::table('kategoris')->insert($kategoris);
    }
}
