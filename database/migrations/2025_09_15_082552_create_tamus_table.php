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
        Schema::create('tamus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pernikahan_id')->constrained('pernikahans')->onDelete('cascade');
            $table->string('nama_tamu', 150);
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('undangan_code', 50)->unique();
            $table->enum('status_hadir', ['belum_konfirmasi','hadir','tidak_hadir','mungkin'])->default('belum_konfirmasi');
            $table->integer('jumlah_orang')->default(1);
            $table->text('ucapan')->nullable();
            $table->boolean('show_gift')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamus');
    }
};
