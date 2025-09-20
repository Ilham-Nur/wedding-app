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
        'layout_id',
        'masa_aktif',
        'status_id',
        'slug',
        'video_url',
        'foto_suami',
        'foto_istri',
        'nama_ayah_suami',
        'nama_ibu_suami',
        'nama_ayah_istri',
        'nama_ibu_istri'
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
      public function galeris()
    {
        return $this->hasMany(Galeri::class, 'pernikahan_id');
    }

    public function tamus()
    {
        return $this->hasMany(Tamu::class, 'pernikahan_id');
    }

    public function lokasis()
    {
        return $this->hasMany(LokasiPernikahan::class, 'pernikahan_id');
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class, 'pernikahan_id');
    }
}
