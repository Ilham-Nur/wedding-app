<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('galeris')->insert([
            [
                'pernikahan_id' => 1,
                'file_path' => '/images/gallery/1.jpg',
                'judul' => 'Prewedding',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
