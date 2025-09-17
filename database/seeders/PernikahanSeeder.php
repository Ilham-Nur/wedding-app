<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PernikahanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pernikahans')->insert([
            [
                'pembeli_id' => 1,
                'nama_pria' => 'Andi',
                'nama_wanita' => 'Siti',
                'tanggal' => '2025-09-15',
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '13:00:00',
                'layout_id' => 1,
                'masa_aktif' => '2025-09-20',
                'status_id' => 1, // aktif
                'slug' => 'andi-siti-2025',
                'video_url' => 'https://youtube.com/sample',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
