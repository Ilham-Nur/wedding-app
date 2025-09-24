<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TamuController extends Controller
{
    public function index($id)
    {
        $pernikahan = Pernikahan::findOrFail($id);

        return view('tamu.index', [
            'pernikahanId' => $pernikahan->id,
        ]);
    }

    public function getData($id)
    {
        $query = Tamu::with(['pernikahan']) // eager load relasi
            ->where('pernikahan_id', $id)
            ->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('status_hadir', function ($row) {
                switch ($row->status_hadir) {
                    case 'hadir':
                        return '<span class="badge bg-success">Hadir</span>';
                    case 'tidak_hadir':
                        return '<span class="badge bg-danger">Tidak Hadir</span>';
                    case 'mungkin':
                        return '<span class="badge bg-warning text-dark">Mungkin</span>';
                    default:
                        return '<span class="badge bg-secondary">Belum Konfirmasi</span>';
                }
            })
            ->addColumn('link', function ($row) {
                // $layoutName = $row->pernikahan->layout->nama_layout ?? 'default';
                $slug       = $row->pernikahan->slug ?? '';
                $code       = $row->undangan_code ?? '';
                $url        = url("undangan/{$slug}/{$code}");

                return '
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" value="'.$url.'" style="width: 200px;" readonly>
                        <button type="button" class="btn btn-sm btn-outline-primary copy-btn" data-link="'.$url.'">
                            Copy
                        </button>
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $phone = preg_replace('/^0/', '62', $row->no_telp);
                $slug  = $row->pernikahan->slug ?? '';
                $code  = $row->undangan_code ?? '';
                $url   = url("undangan/{$slug}/{$code}");

                $pria   = $row->pernikahan->nama_pria ?? '';
                $wanita = $row->pernikahan->nama_wanita ?? '';
                $tanggal = \Carbon\Carbon::parse($row->pernikahan->tanggal)->translatedFormat('l, d F Y');

                $message =
            "Assalamu’alaikum Warahmatullahi Wabarakatuh\n\n".
            "Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada acara pernikahan kami:\n\n".
            "{$pria} & {$wanita}\n\n".
            "Hari/Tanggal : {$tanggal}\n".
            "Waktu        : 09.00 - 18.00\n".
            "Tempat       : Gedung M.Space Convention Center\n\n".
            "Untuk detail acara, dapat dilihat pada undangan digital berikut:\n{$url}\n\n".
            "Mohon maaf perihal undangan hanya dibagikan melalui pesan ini.\n".
            "Atas kehadiran dan doa restunya, kami ucapkan terima kasih.\n\n".
            "Wassalamu’alaikum Warahmatullahi Wabarakatuh\n\n".
            "Hormat kami dan keluarga";

                // Encode setelah selesai
                $waLink = "https://wa.me/{$phone}?text=" . urlencode($message);

                return '
                    <button class="btn btn-sm btn-primary edit-btn" data-id="'.$row->id.'">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">
                        <i class="ti ti-trash"></i>
                    </button>
                    <a href="'.$waLink.'" target="_blank" class="btn btn-sm btn-success">
                        <i class="ti ti-brand-whatsapp"></i>
                    </a>
                ';
            })
            ->addColumn('ucapan', function($row){
                return $row->ucapan ? $row->ucapan : '-';
            })
            ->rawColumns(['status_hadir','link','action'])
            ->make(true);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'nama_tamu'     => 'required|string|max:255',
            'no_telp'       => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'email'         => 'nullable|email',
            'show_gift'     => 'boolean',
        ]);

        // cari jumlah tamu terakhir di pernikahan ini
        $lastNumber = Tamu::where('pernikahan_id', $id)->count() + 1;

        // format jadi 3 digit (001, 002, dst)
        $formattedNumber = str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        // generate kode undangan
        $undanganCode = "INV-{$id}-{$formattedNumber}";

        $tamu = Tamu::create([
            'pernikahan_id' => $id,
            'nama_tamu'     => $request->nama_tamu,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
            'email'         => $request->email,
            'undangan_code' => $undanganCode,
            'status_hadir'  => 'belum_konfirmasi', // default
            'jumlah_orang'  => 1, // default
            'ucapan'        => null, // kosong dulu
            'show_gift'     => $request->show_gift ?? 0,
        ]);

        return response()->json(['success' => true, 'data' => $tamu]);
    }



    public function show($id, $tamuId)
    {
        $tamu = Tamu::where('pernikahan_id', $id)->findOrFail($tamuId);
        return response()->json($tamu);
    }

    public function update(Request $request, $id, $tamuId)
    {
        $request->validate([
            'nama_tamu'     => 'required|string|max:255',
            'no_telp'       => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'email'         => 'nullable|email',
            'undangan_code' => 'nullable|string|max:100',
            'show_gift'     => 'boolean',
        ]);

        $tamu = Tamu::where('pernikahan_id', $id)->findOrFail($tamuId);

        $tamu->update($request->only([
            'nama_tamu',
            'no_telp',
            'alamat',
            'email',
            'undangan_code',
            'show_gift',
        ]));

        return response()->json(['success' => true, 'data' => $tamu]);
    }


    public function destroy($id, $tamuId)
    {
        $tamu = Tamu::where('pernikahan_id', $id)->findOrFail($tamuId);
        $tamu->delete();

        return response()->json(['success' => true]);
    }

    public function importArray(Request $request, $id)
    {
        $data = $request->input('data'); // array dari frontend

        if (!$data || !is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data kosong']);
        }

        $inserted = [];
        foreach ($data as $row) {
            if (empty($row[0])) continue; // skip kalau nama kosong

            // hitung jumlah tamu terakhir
            $lastNumber = Tamu::where('pernikahan_id', $id)->count() + 1;
            $formattedNumber = str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
            $undanganCode = "INV-{$id}-{$formattedNumber}";

            $tamu = Tamu::create([
                'pernikahan_id' => $id,
                'nama_tamu'     => $row[0] ?? '',
                'no_telp'       => $row[1] ?? null,
                'email'         => $row[2] ?? null,
                'alamat'        => $row[3] ?? null,
                'show_gift'     => $row[4] ?? 1,
                'undangan_code' => $undanganCode,
                'status_hadir'  => 'belum_konfirmasi',
                'jumlah_orang'  => 1,
            ]);

            $inserted[] = $tamu;
        }

        return response()->json(['success' => true, 'data' => $inserted]);
    }

}
