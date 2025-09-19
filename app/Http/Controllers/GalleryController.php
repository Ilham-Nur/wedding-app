<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GalleryController extends Controller
{
    public function index($id)
    {
    
        $wedding = Pernikahan::with([
            'galeris' => function ($query) {
                $query->orderBy('urutan', 'asc');
            }
        ])->findOrFail($id);

        return view('wedding.gallery', compact('wedding'));
    }

     public function show(Pernikahan $pernikahan)
    {
        // Load relasi 'galeris' agar ikut tampil di dalam JSON
        $pernikahan->load('galeris');

        return response()->json($pernikahan);
    }
    public function store(Request $request)
    {
        $request->validate([
            'pernikahan_id' => 'required|exists:pernikahans,id',
            'judul' => 'nullable|string|max:150',
            'urutan' => 'nullable|integer',
            'file_path.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $file) {
                // Simpan file ke storage/app/public/uploads/gallery
                $path = $file->store('uploads/gallery', 'public');

                // Buat record baru di database
                Galeri::create([
                    'pernikahan_id' => $request->pernikahan_id,
                    'file_path' => $path,
                    'judul' => $request->judul,
                    'urutan' => $request->urutan ?? 0,
                ]);
            }
        }

        return back()->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function destroy(Galeri $galeri)
    {
        Storage::disk('public')->delete($galeri->file_path);
        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus dari galeri.');
    }

}
