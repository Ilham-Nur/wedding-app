<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pernikahan extends Model
{
    use HasFactory;

    protected $table = 'pernikahans'; // nama tabel

    protected $fillable = [
        'pembeli_id',
        'nama_pria',
        'nama_wanita',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'layout_id',
        'masa_aktif',
        'status_id',
        'slug',
        'video_url'
    ];

    // Relasi contoh
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusPernikahan::class, 'status_id');
    }
}
