<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayoutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layouts')->insert([
            [
                'nama_layout' => 'Layout 1',
                'preview_url' => '/images/layout1.png',
                'deskripsi' => 'Tema elegan',
            ],
            [
                'nama_layout' => 'Layout 2',
                'preview_url' => '/images/layout2.png',
                'deskripsi' => 'Tema simple',
            ],
        ]);
    }
}
