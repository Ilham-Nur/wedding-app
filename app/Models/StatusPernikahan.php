<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPernikahan extends Model
{
    use HasFactory;

    protected $table = 'status_pernikahans';

    protected $fillable = [
        'nama_status',
    ];

    // Relasi ke Pernikahan
    public function pernikahans()
    {
        return $this->hasMany(Pernikahan::class, 'status_id');
    }
}
