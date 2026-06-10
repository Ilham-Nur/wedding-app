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
                'folder_path' => 'layout1',
                'preview_url' => '/images/layout1.png',
                'deskripsi' => 'Tema klasik',
            ],
            [
                'nama_layout' => 'Layout 4',
                'folder_path' => 'layout4',
                'preview_url' => '/images/layout4.png',
                'deskripsi' => 'Tema elegan',
            ],
            [
                'nama_layout' => 'Layout 5',
                'folder_path' => 'layout5',
                'preview_url' => '/images/layout5.png',
                'deskripsi' => 'Tema simple',
            ],
            [
                'nama_layout' => 'Layout 6',
                'folder_path' => 'layout6',
                'preview_url' => '/images/layout6.png',
                'deskripsi' => 'Tema modern',
            ],
            [
                'nama_layout' => 'Layout 7',
                'folder_path' => 'layout7',
                'preview_url' => '/images/layout7.png',
                'deskripsi' => 'Tema premium',
            ],
        ]);
    }
}
