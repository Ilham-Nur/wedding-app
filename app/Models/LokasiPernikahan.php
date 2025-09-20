<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPernikahan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'lokasi_pernikahans';

    // Field yang bisa diisi massal
    protected $fillable = [
        'pernikahan_id',
        'nama_acara',
        'alamat',
        'maps_link',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
    ];

    // Relasi ke tabel pernikahans
    public function pernikahan()
    {
        return $this->belongsTo(Pernikahan::class);
    }
}