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
       Schema::create('rekenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pernikahan_id')->nullable()->constrained('pernikahans')->onDelete('cascade');
            $table->string('bank_nama', 100);
            $table->string('atas_nama', 150);
            $table->string('no_rekening', 50);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekenings');
    }
};
