<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use Illuminate\Http\Request;

class UndanganController extends Controller
{
    public function show($slug)
    {
        // 1. Cari data pernikahan beserta data layout-nya
        $wedding = Pernikahan::with('layout', 'galeris', 'tamus' , 'lokasis', 'gifts')->where('slug', $slug)->firstOrFail();

        // 2. Ambil nama file dari kolom 'folder_path'
        //    Contoh: 'layout1'
        $namaFileLayout = $wedding->layout->folder_path;

        // 3. Bangun path ke file view yang benar.
        //    Ini akan menghasilkan string: 'template.layout1'
        $viewPath = 'template.' . $namaFileLayout;

        // 4. Panggil view yang sesuai
        return view($viewPath, compact('wedding'));
    }
}