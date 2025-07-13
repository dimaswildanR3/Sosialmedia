<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JadwalKonten;
use Carbon\Carbon;

class UpdateScheduledToPublished extends Command
{
    protected $signature = 'jadwal:update-published';

    protected $description = 'Update jadwal konten dari scheduled ke published berdasarkan tanggal publikasi';

    public function handle()
    {
        $today = Carbon::today();
        // var_dump($today);
        // die;
        $updated = JadwalKonten::where('status', 'scheduled')
            ->whereDate('tanggal_publikasi', '<=', $today)
            ->update(['status' => 'published']);
  
            // var_dump($updated);
            // die;
        $this->info("Berhasil mengupdate $updated jadwal konten menjadi published.");
    
        return 0;
    }
}
