@extends('layout.app')
@section('title', 'Detail Wedding')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-semibold mb-0">Detail Wedding</h5>

                {{-- Tombol Arah ke Gallery & Gift --}}
                <div class="mb-3">
                    <a href="{{ route('wedding.gallery', $wedding->id) }}" class="btn btn-outline-info">📷 Gallery</a>
                    <a href="{{ route('wedding.gift', $wedding->id) }}" class="btn btn-outline-success">🎁 Gift</a>
                    <a href="{{ route('wedding.tamu', $wedding->id) }}" class="btn btn-outline-primary">👥 Tamu</a>
                </div>
            </div>

            {{-- Informasi Utama --}}
            <div class="mb-3">
                <p><strong>Nama Pria:</strong> {{ $wedding->nama_pria }}</p>
                <p><strong>Nama Wanita:</strong> {{ $wedding->nama_wanita }}</p>
                <p><strong>Tanggal:</strong> {{ $wedding->tanggal }}</p>
                <p>
                    <strong>Status:</strong>
                    <span
                        class="badge
                    @if ($wedding->status?->nama_status == 'aktif') bg-success
                    @elseif($wedding->status?->nama_status == 'nonaktif') bg-warning
                    @else bg-secondary @endif">
                        {{ $wedding->status->nama_status ?? 'Belum ada status' }}
                    </span>
                </p>
            </div>

            {{-- Input Waktu Mulai & Selesai --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="datetime-local" class="form-control" value="{{ $wedding->waktu_mulai ?? '' }}"
                        {{ $wedding->waktu_mulai ? 'readonly' : '' }}>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="datetime-local" class="form-control" value="{{ $wedding->waktu_selesai ?? '' }}"
                        {{ $wedding->waktu_selesai ? 'readonly' : '' }}>
                </div>
            </div>

            {{-- URL Video --}}
            <div class="mb-3">
                <label class="form-label">URL Video</label>
                @if ($wedding->url_video)
                    <div class="input-group">
                        <input type="url" class="form-control" value="{{ $wedding->url_video }}" readonly>
                        <a href="{{ $wedding->url_video }}" target="_blank" class="btn btn-sm btn-primary">Lihat Video</a>
                    </div>
                @else
                    <input type="url" class="form-control" placeholder="Tambahkan URL Video">
                @endif
            </div>



        </div>
    </div>
@endsection
