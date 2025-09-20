<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $fillable = [
        'pernikahan_id',
        'bank_nama',
        'atas_nama',
        'no_rekening',
        'catatan',
    ];

    public function pernikahan()
    {
        return $this->belongsTo(Pernikahan::class);
    }
}