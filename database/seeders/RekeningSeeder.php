<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rekenings')->insert([
            [
                'pernikahan_id' => 1,
                'bank_nama' => 'BCA',
                'atas_nama' => 'Andi Setiawan',
                'no_rekening' => '1234567890',
                'catatan' => 'Terima kasih atas kado digital Anda 🙏',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
