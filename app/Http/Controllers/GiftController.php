<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GiftController extends Controller
{
    /**
     * Tampilkan halaman daftar Gift (rekening).
     */
    public function index($pernikahanId)
    {
        $pernikahan = Pernikahan::findOrFail($pernikahanId);
        return view('gift.index', (['pernikahanId' => $pernikahan->id]));
    }

    /**
     * DataTables JSON untuk daftar Gift.
     */
    public function data($pernikahanId)
    {
        $query = Rekening::where('pernikahan_id', $pernikahanId)->with('pernikahan');

        return DataTables::of($query)
            ->addColumn('pernikahan', function ($row) {
                return $row->pernikahan
                    ? $row->pernikahan->nama_pria . ' & ' . $row->pernikahan->nama_wanita
                    : '-';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-primary btn-edit" data-id="' . $row->id . '"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '"><i class="ti ti-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Simpan Gift baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_nama'     => 'required|string|max:100',
            'atas_nama'     => 'required|string|max:150',
            'no_rekening'   => 'required|string|max:50',
            'catatan'       => 'nullable|string',
            'pernikahan_id' => 'nullable|exists:pernikahans,id',
        ]);

        $gift = Rekening::create($validated);

        return response()->json(['message' => 'Gift berhasil ditambahkan', 'data' => $gift]);
    }

    /**
     * Ambil detail Gift untuk edit.
     */
    public function show($id)
    {
        $gift = Rekening::findOrFail($id);
        return response()->json($gift);
    }

    /**
     * Update Gift.
     */
    public function edit($id)
{
    $gift = Rekening::findOrFail($id);
    return response()->json($gift);
}

    public function update(Request $request, $id)
    {
        $gift = Rekening::findOrFail($id);

        $validated = $request->validate([
            'bank_nama'     => 'required|string|max:100',
            'atas_nama'     => 'required|string|max:150',
            'no_rekening'   => 'required|string|max:50',
            'catatan'       => 'nullable|string',
            'pernikahan_id' => 'nullable|exists:pernikahans,id',
        ]);

        $gift->update($validated);

        return response()->json(['message' => 'Gift berhasil diperbarui', 'data' => $gift]);
    }

    /**
     * Hapus Gift.
     */
    public function destroy($id)
    {
        $gift = Rekening::findOrFail($id);
        $gift->delete();

        return response()->json(['message' => 'Gift berhasil dihapus']);
    }
}