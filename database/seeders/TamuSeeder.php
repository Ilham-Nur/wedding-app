<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TamuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tamus')->insert([
            [
                'pernikahan_id' => 1,
                'nama_tamu' => 'Budi',
                'no_telp' => '08123411111',
                'email' => 'budi@example.com',
                'undangan_code' => 'INV-001',
                'status_hadir' => 'belum_konfirmasi',
                'jumlah_orang' => 2,
                'ucapan' => 'Selamat menempuh hidup baru!',
                'show_gift' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pernikahan_id' => 1,
                'nama_tamu' => 'Rina',
                'no_telp' => '08123422222',
                'email' => 'rina@example.com',
                'undangan_code' => 'INV-002',
                'status_hadir' => 'hadir',
                'jumlah_orang' => 1,
                'ucapan' => null,
                'show_gift' => false, // ❌ tidak bisa lihat gift
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
