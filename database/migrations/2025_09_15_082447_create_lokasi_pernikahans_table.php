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
        Schema::create('lokasi_pernikahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pernikahan_id')->constrained('pernikahans')->onDelete('cascade');
            $table->string('nama_acara'); // akad, resepsi, dll
            $table->text('alamat');
            $table->text('maps_link')->nullable();
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_pernikahans');
    }
};
