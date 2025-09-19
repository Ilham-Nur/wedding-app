<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // Sesuaikan dengan kolom di migrasimu
    protected $fillable = [
        'pernikahan_id',
        'file_path',
        'judul',
        'urutan',
    ];

    // Relasi ke model Pernikahan
    public function pernikahan()
    {
        return $this->belongsTo(Pernikahan::class);
    }
}
