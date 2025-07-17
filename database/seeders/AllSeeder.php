<?php

namespace Database\Seeders;

use App\Models\Balita;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        User::updateOrCreate([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
        ]);
         
        $this->call(KategoriSeeder::class);
    }
}
