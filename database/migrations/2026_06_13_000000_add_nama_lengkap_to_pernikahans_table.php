<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            $table->string('nama_lengkap_pria')->nullable()->after('nama_pria');
            $table->string('nama_lengkap_wanita')->nullable()->after('nama_wanita');
        });

        DB::table('pernikahans')->update([
            'nama_lengkap_pria' => DB::raw('nama_pria'),
            'nama_lengkap_wanita' => DB::raw('nama_wanita'),
        ]);
    }

    public function down(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap_pria', 'nama_lengkap_wanita']);
        });
    }
};
