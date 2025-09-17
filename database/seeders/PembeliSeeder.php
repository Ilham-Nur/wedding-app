<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembeliSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pembelis')->insert([
            [
                'user_id' => 2, // customer1
                'no_telp' => '08123456789',
                'alamat' => 'Jl. Mawar No. 10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
