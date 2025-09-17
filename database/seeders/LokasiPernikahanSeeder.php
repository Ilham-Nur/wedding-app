<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiPernikahanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lokasi_pernikahans')->insert([
            [
                'pernikahan_id' => 1,
                'nama_acara' => 'Akad Nikah',
                'alamat' => 'Masjid Agung',
                'maps_link' => 'https://goo.gl/maps/xxxx',
                'tanggal' => '2025-09-15',
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '11:00:00',
            ],
        ]);
    }
}

