<?php

namespace App\Http\Controllers;

use App\Models\LokasiPernikahan;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LokasiPernikahanController extends Controller
{
    // Menampilkan halaman index
    public function index($pernikahanId)
    {
        $pernikahan = Pernikahan::findOrFail($pernikahanId);
        return view('lokasi.index', ['pernikahanId' => $pernikahan->id]);
    }

    // Data untuk DataTables AJAX
    public function data($pernikahanId)
    {
        $lokasis = LokasiPernikahan::where('pernikahan_id', $pernikahanId);

        return DataTables::of($lokasis)
            ->addColumn('action', function ($row) {
                $editBtn = '<button class="btn btn-sm btn-primary btn-edit" data-id="' . $row->id . '"><i class="ti ti-edit"></i></button>';
                $deleteBtn = '<button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '"><i class="ti ti-trash"></i></button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->make(true);
    }

    // Menampilkan detail untuk edit
    public function edit($id)
    {
        $lokasi = LokasiPernikahan::findOrFail($id);
        return response()->json($lokasi);
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pernikahan_id' => 'required|exists:pernikahans,id',
            'nama_acara' => 'required|string|max:255',
            'alamat' => 'required|string',
            'maps_link' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $lokasi = LokasiPernikahan::create($validated);

        return response()->json(['message' => 'Lokasi berhasil disimpan.', 'data' => $lokasi]);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $lokasi = LokasiPernikahan::findOrFail($id);

        $validated = $request->validate([
            'pernikahan_id' => 'required|exists:pernikahans,id',
            'nama_acara' => 'required|string|max:255',
            'alamat' => 'required|string',
            'maps_link' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $lokasi->update($validated);

        return response()->json(['message' => 'Lokasi berhasil diperbarui.', 'data' => $lokasi]);
    }

    // Hapus data
    public function destroy($id)
    {
        $lokasi = LokasiPernikahan::findOrFail($id);
        $lokasi->delete();

        return response()->json(['message' => 'Lokasi berhasil dihapus.']);
    }
}