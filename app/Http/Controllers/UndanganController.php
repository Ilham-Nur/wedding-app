<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use Illuminate\Http\Request;

class UndanganController extends Controller
{
    public function show($slug, $code = null)
    {
        $wedding = Pernikahan::with('layout', 'galeris', 'tamus', 'lokasis', 'gifts')
                    ->where('slug', $slug)
                    ->firstOrFail();

        // opsional: cek code tamu
        if ($code) {
            $tamu = $wedding->tamus()->where('undangan_code', $code)->first();
            if (! $tamu) {
                abort(404, 'Tamu tidak ditemukan');
            }
        }

        $viewPath = 'template.' . $wedding->layout->folder_path;
        return view($viewPath, compact('wedding', 'tamu'));
    }
}
