<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use App\Models\Pembeli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pernikahan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                        <a href="' . url('wedding/detail/' . $row->id) . '" class="btn btn-sm btn-info">
                            <i class="ti ti-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-primary btn-edit" data-id="' . $row->id . '">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
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
            'nama_lengkap_pria' => 'required|string|max:255',
            'nama_wanita'  => 'required|string|max:255',
            'nama_lengkap_wanita' => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'waktu_mulai'  => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
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
            'nama_lengkap_pria' => 'required|string|max:255',
            'nama_wanita'  => 'required|string|max:255',
            'nama_lengkap_wanita' => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'waktu_mulai'  => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
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



    public function updateExtra(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $wedding = Pernikahan::findOrFail($id);

            // VALIDASI
            $validated = $request->validate([
                'video_url'              => 'nullable|url',
                'foto_suami'             => 'nullable|image|mimes:jpg,jpeg,png',
                'foto_istri'             => 'nullable|image|mimes:jpg,jpeg,png',
                'foto_utama'             => 'nullable|image|mimes:jpg,jpeg,png',
                'file_musik'             => 'nullable|file|mimes:mp3,wav,ogg', // <- TANPA "|" terakhir
                'nama_ayah_suami'        => 'nullable|string|max:255',
                'nama_ibu_suami'         => 'nullable|string|max:255',
                'nama_ayah_istri'        => 'nullable|string|max:255',
                'nama_ibu_istri'         => 'nullable|string|max:255',
                'turut_mengundang_pria'  => 'nullable|string',
                'turut_mengundang_wanita' => 'nullable|string',
            ]);

            // DATA DASAR
            $data = [
                'video_url'              => $validated['video_url'] ?? $wedding->video_url,
                'nama_ayah_suami'        => $validated['nama_ayah_suami'] ?? $wedding->nama_ayah_suami,
                'nama_ibu_suami'         => $validated['nama_ibu_suami'] ?? $wedding->nama_ibu_suami,
                'nama_ayah_istri'        => $validated['nama_ayah_istri'] ?? $wedding->nama_ayah_istri,
                'nama_ibu_istri'         => $validated['nama_ibu_istri'] ?? $wedding->nama_ibu_istri,
                'turut_mengundang_pria'  => $validated['turut_mengundang_pria'] ?? $wedding->turut_mengundang_pria,
                'turut_mengundang_wanita' => $validated['turut_mengundang_wanita'] ?? $wedding->turut_mengundang_wanita,
            ];

            // FOTO SUAMI
            if ($request->hasFile('foto_suami')) {
                $data['foto_suami'] = $request->file('foto_suami')
                    ->store('uploads/wedding', 'public');
            } else {
                $data['foto_suami'] = $wedding->foto_suami;
            }

            // FOTO ISTRI
            if ($request->hasFile('foto_istri')) {
                $data['foto_istri'] = $request->file('foto_istri')
                    ->store('uploads/wedding', 'public');
            } else {
                $data['foto_istri'] = $wedding->foto_istri;
            }

            // FOTO UTAMA
            if ($request->hasFile('foto_utama')) {
                $data['foto_utama'] = $request->file('foto_utama')
                    ->store('uploads/wedding', 'public');
            } else {
                $data['foto_utama'] = $wedding->foto_utama;
            }

            // 🎵 FILE MUSIK – BAGIAN KRITIS
            if ($request->hasFile('file_musik')) {

                // Kalau mau debug sekali, boleh buka komentar ini:
                // dd([
                //     'hasFile' => $request->hasFile('file_musik'),
                //     'file'    => $request->file('file_musik'),
                // ]);

                $data['file_musik'] = $request->file('file_musik')
                    ->store('uploads/wedding/music', 'public');
            } else {
                $data['file_musik'] = $wedding->file_musik;
            }

            // UPDATE SEKALI
            $wedding->update($data);

            DB::commit();

            return redirect()
                ->route('wedding.detail', $id)
                ->with('success', 'Data tambahan berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal update wedding extra: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
