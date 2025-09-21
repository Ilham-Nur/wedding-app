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
            $table->longText('turut_mengundang_pria')->nullable()->after('nama_ibu_istri');
            $table->longText('turut_mengundang_wanita')->nullable()->after('turut_mengundang_pria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('pernikahans', function (Blueprint $table) {
            $table->dropColumn(['turut_mengundang_pria', 'turut_mengundang_wanita']);
        });
    }
};
