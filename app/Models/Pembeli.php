<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembelis';

    protected $fillable = [
        'user_id',
        'no_telp',
        'alamat',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Pernikahan
    public function pernikahans()
    {
        return $this->hasMany(Pernikahan::class, 'pembeli_id');
    }
}
