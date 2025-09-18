<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use App\Models\Pernikahan;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WeddingController extends Controller
{
    public function index()
    {
        $pernikahans = Pernikahan::all();
        $customers = Pembeli::with('user')->get();
        $layouts     = Layout::all();

        return view('wedding.index', compact('pernikahans', 'customers', 'layouts'));
    }


    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Pernikahan::with(['pembeli', 'layout', 'status'])->select('pernikahans.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pembeli', function ($row) {
                    return $row->pembeli->user->name ?? '-';
                })
                ->addColumn('layout', function ($row) {
                    return $row->layout->nama_layout ?? '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status->nama_status ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.url('wedding/detail/'.$row->id).'" class="btn btn-sm btn-info">
                            <i class="ti ti-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-primary btn-edit" data-id="'.$row->id.'">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="'.$row->id.'">
                           <i class="ti ti-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $validated = $request->validate([
            'pembeli_id'   => 'required|exists:pembelis,id',
            'nama_pria'    => 'required|string|max:255',
            'nama_wanita'  => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'waktu_mulai'  => 'nullable|date_format:H:i',
            'waktu_selesai'=> 'nullable|date_format:H:i',
            'layout_id'    => 'required|exists:layouts,id',
            'masa_aktif'   => 'required|date'
        ]);

        $validated['status_id'] = 1;
        $validated['slug'] = Str::slug($request->nama_pria . '-' . $request->nama_wanita . '-' . $request->tanggal);
        $pernikahan = Pernikahan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data pernikahan berhasil ditambahkan.',
        ]);
    }

    public function update(Request $request, Pernikahan $pernikahan)
    {
        $validated = $request->validate([
            'pembeli_id'   => 'required|exists:pembelis,id',
            'nama_pria'    => 'required|string|max:255',
            'nama_wanita'  => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'waktu_mulai'  => 'nullable|date_format:H:i',
            'waktu_selesai'=> 'nullable|date_format:H:i',
            'layout_id'    => 'required|exists:layouts,id',
            'masa_aktif'   => 'required|date',
        ]);

        $validated['status_id'] = 1;

        $pernikahan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data pernikahan berhasil diperbarui.',
            'data'    => $pernikahan
        ]);
    }

    public function show(Pernikahan $pernikahan)
    {
        return response()->json($pernikahan);
    }



   public function destroy(Pernikahan $pernikahan)
    {
        $pernikahan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pernikahan berhasil dihapus.'
        ]);
    }


    public function detail($id)
    {
        $wedding = Pernikahan::with(['pembeli.user', 'layout', 'status'])->findOrFail($id);

        return view('wedding.detail', compact('wedding'));
    }
}
