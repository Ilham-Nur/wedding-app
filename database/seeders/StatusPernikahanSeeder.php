<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPernikahanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('status_pernikahans')->insert([
            ['nama_status' => 'aktif'],
            ['nama_status' => 'nonaktif'],
            ['nama_status' => 'expired'],
            ['nama_status' => 'selesai'],
        ]);
    }
}
