<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            $table->text('whatsapp_template')->nullable()->after('turut_mengundang_wanita');
        });
    }

    public function down(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            $table->dropColumn('whatsapp_template');
        });
    }
};
