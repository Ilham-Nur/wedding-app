<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\Tamu;
use Carbon\Carbon;
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
        $query = Tamu::with(['pernikahan.lokasis'])
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
                $slug = $row->pernikahan->slug ?? '';
                $code = $row->undangan_code ?? '';
                $url = url("undangan/{$slug}/{$code}");

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
                $phone = $this->normalizeWhatsAppNumber($row->no_telp);
                $waButton = $phone
                    ? '<a href="'.$this->buildWhatsAppLink($row, $phone).'" target="_blank" rel="noopener" class="btn btn-sm btn-success" title="Kirim undangan WhatsApp ke '.e($row->nama_tamu).'">
                            <i class="ti ti-brand-whatsapp"></i>
                       </a>'
                    : '<button type="button" class="btn btn-sm btn-secondary" disabled title="Nomor WhatsApp belum tersedia atau tidak valid">
                            <i class="ti ti-brand-whatsapp"></i>
                       </button>';

                return '
                    <button class="btn btn-sm btn-primary edit-btn" data-id="'.$row->id.'">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">
                        <i class="ti ti-trash"></i>
                    </button>
                    '.$waButton;
            })

            ->addColumn('ucapan', function ($row) {
                return $row->ucapan ? $row->ucapan : '-';
            })
            ->rawColumns(['status_hadir', 'link', 'action'])
            ->make(true);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
            'show_gift' => 'boolean',
        ]);

        // Ambil record terakhir untuk pernikahan ini
        $lastTamu = Tamu::where('pernikahan_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = 0;

        // Kalau ada data terakhir, ambil angka dari undangan_code
        if ($lastTamu && preg_match('/INV-'.$id.'-(\d+)/', $lastTamu->undangan_code, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        // Increment nomor
        $lastNumber++;
        $formattedNumber = str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        // Generate kode undangan
        $undanganCode = "INV-{$id}-{$formattedNumber}";

        $tamu = Tamu::create([
            'pernikahan_id' => $id,
            'nama_tamu' => $request->nama_tamu,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'undangan_code' => $undanganCode,
            'status_hadir' => 'belum_konfirmasi', // default
            'jumlah_orang' => 1, // default
            'ucapan' => null, // kosong dulu
            'show_gift' => $request->show_gift ?? 0,
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
            'nama_tamu' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
            'undangan_code' => 'nullable|string|max:100',
            'show_gift' => 'boolean',
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

        if (! $data || ! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data kosong']);
        }

        $request->validate([
            'data' => 'required|array|max:1000',
            'data.*' => 'array|max:5',
            'data.*.0' => 'nullable|string|max:255',
            'data.*.1' => 'nullable|string|max:30',
            'data.*.2' => 'nullable|email|max:255',
            'data.*.3' => 'nullable|string|max:1000',
            'data.*.4' => 'nullable',
        ]);

        $inserted = [];

        // Ambil record terakhir berdasarkan id untuk pernikahan ini
        $lastTamu = Tamu::where('pernikahan_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = 0;

        // Kalau ada data terakhir, ambil angka di undangan_code
        if ($lastTamu && preg_match('/INV-'.$id.'-(\d+)/', $lastTamu->undangan_code, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        foreach ($data as $row) {
            $name = trim((string) ($row[0] ?? ''));

            if ($name === '') {
                continue;
            }

            // Increment nomor untuk setiap tamu baru
            $lastNumber++;
            $formattedNumber = str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
            $undanganCode = "INV-{$id}-{$formattedNumber}";

            $tamu = Tamu::create([
                'pernikahan_id' => $id,
                'nama_tamu' => $name,
                'no_telp' => $this->nullableTrim($row[1] ?? null),
                'email' => $this->nullableTrim($row[2] ?? null),
                'alamat' => $this->nullableTrim($row[3] ?? null),
                'show_gift' => $this->parseShowGift($row[4] ?? 1),
                'undangan_code' => $undanganCode,
                'status_hadir' => 'belum_konfirmasi',
                'jumlah_orang' => 1,
            ]);

            $inserted[] = $tamu;
        }

        return response()->json(['success' => true, 'data' => $inserted]);
    }

    private function buildWhatsAppLink(Tamu $tamu, string $phone): string
    {
        $wedding = $tamu->pernikahan;
        $url = url("undangan/{$wedding->slug}/{$tamu->undangan_code}");
        $couple = trim(($wedding->nama_pria ?? '').' & '.($wedding->nama_wanita ?? ''), ' &');
        $eventDetails = $wedding->lokasis->map(function ($location) {
            $date = Carbon::parse($location->tanggal)->translatedFormat('l, d F Y');
            $start = $location->waktu_mulai ? Carbon::parse($location->waktu_mulai)->format('H:i') : null;
            $end = $location->waktu_selesai ? Carbon::parse($location->waktu_selesai)->format('H:i') : null;
            $time = $start ? $start.($end ? " - {$end}" : '').' WIB' : 'Waktu menyusul';
            $maps = $location->maps_link ? "\nPeta         : {$location->maps_link}" : '';

            return "{$location->nama_acara}\n"
                ."Hari/Tanggal : {$date}\n"
                ."Waktu        : {$time}\n"
                ."Tempat       : {$location->alamat}{$maps}";
        })->implode("\n\n");

        if ($eventDetails === '') {
            $eventDetails = 'Detail acara akan diinformasikan kemudian.';
        }

        $message = "Assalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
            ."Yth. Bapak/Ibu/Saudara/i\n{$tamu->nama_tamu}\n\n"
            ."Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir dan memberikan doa restu pada acara pernikahan:\n\n"
            ."*{$couple}*\n\n"
            ."Detail acara:\n{$eventDetails}\n\n"
            ."Undangan digital khusus untuk Anda dapat dibuka melalui tautan berikut:\n{$url}\n\n"
            ."Mohon maaf karena undangan ini kami sampaikan melalui pesan WhatsApp.\n"
            ."Atas kehadiran dan doa restunya, kami mengucapkan terima kasih.\n\n"
            ."Wassalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
            .'Hormat kami dan keluarga';

        return 'https://wa.me/'.$phone.'?text='.rawurlencode($message);
    }

    private function normalizeWhatsAppNumber(?string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62'.$digits;
        }

        return preg_match('/^62\d{8,13}$/', $digits) ? $digits : null;
    }

    private function parseShowGift(mixed $value): bool
    {
        $normalized = strtolower(trim((string) $value));

        if (in_array($normalized, ['0', 'tidak', 'no', 'false'], true)) {
            return false;
        }

        return true;
    }

    private function nullableTrim(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
