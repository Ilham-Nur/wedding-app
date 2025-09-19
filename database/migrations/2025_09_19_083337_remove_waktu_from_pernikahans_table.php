<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            // Hapus kolom waktu
            $table->dropColumn(['waktu_mulai', 'waktu_selesai']);

            // Tambah kolom baru
            $table->string('foto_suami')->nullable()->after('nama_pria');
            $table->string('foto_istri')->nullable()->after('nama_wanita');

            $table->string('nama_ayah_suami')->nullable()->after('foto_suami');
            $table->string('nama_ibu_suami')->nullable()->after('nama_ayah_suami');

            $table->string('nama_ayah_istri')->nullable()->after('foto_istri');
            $table->string('nama_ibu_istri')->nullable()->after('nama_ayah_istri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            // Tambahkan kembali kolom waktu
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();

            // Hapus kolom baru
            $table->dropColumn([
                'foto_suami',
                'foto_istri',
                'nama_ayah_suami',
                'nama_ibu_suami',
                'nama_ayah_istri',
                'nama_ibu_istri',
            ]);
        });
    }
};
