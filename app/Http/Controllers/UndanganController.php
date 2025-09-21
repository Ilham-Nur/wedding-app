<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\Tamu;
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

     public function updateWish(Request $request, $id)
    {
        $tamu = Tamu::find($id);

        if(!$tamu){
            return response()->json(['success' => false, 'message' => 'Tamu tidak ditemukan'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'status_hadir' => 'required|in:belum_konfirmasi,hadir,tidak_hadir,mungkin',
            'jumlah_orang' => 'required|integer|min:1',
            'ucapan'       => 'nullable|string|max:1000',
        ]);

        // Update data
        $tamu->status_hadir = $validated['status_hadir'];
        $tamu->jumlah_orang = $validated['jumlah_orang'];
        $tamu->ucapan = $validated['ucapan'];
        $tamu->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }
}
