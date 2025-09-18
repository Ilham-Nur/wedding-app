<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    use HasFactory;

    protected $table = 'layouts';

    protected $fillable = [
        'nama_layout',
        'preview_url',
        'deskripsi',
    ];

    // Relasi ke Pernikahan
    public function pernikahans()
    {
        return $this->hasMany(Pernikahan::class, 'layout_id');
    }
}
