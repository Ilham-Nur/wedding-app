<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layouts', function (Blueprint $table) {
            // Menambahkan kolom baru untuk menyimpan nama folder, contoh: 'invitation1'
            $table->string('folder_path')->after('nama_layout'); 
        });
    }

    public function down(): void
    {
        Schema::table('layouts', function (Blueprint $table) {
            $table->dropColumn('folder_path');
        });
    }
};