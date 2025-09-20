<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $table = 'tamus';

    protected $fillable = [
        'pernikahan_id',
        'nama_tamu',
        'no_telp',
        'alamat',
        'email',
        'undangan_code',
        'status_hadir',
        'jumlah_orang',
        'ucapan',
        'show_gift',
    ];

    // Relasi ke pernikahan
    public function pernikahan()
    {
        return $this->belongsTo(Pernikahan::class, 'pernikahan_id');
    }
}
