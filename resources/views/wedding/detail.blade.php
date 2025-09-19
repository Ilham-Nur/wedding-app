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
                    <a href="{{ route('wedding.lokasi', $wedding->id) }}" class="btn btn-outline-danger">📍 Lokasi</a>
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

            {{-- Form Tambahan --}}
            <form action="{{ route('wedding.updateExtra', $wedding->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Foto Suami</label>
                        <input type="file" name="foto_suami" class="form-control" accept="image/*"
                            onchange="previewImage(event, 'previewSuami')">
                        {{-- Tampilkan preview jika sudah ada di DB --}}
                        @if ($wedding->foto_suami)
                            <img id="previewSuami" src="{{ asset('storage/' . $wedding->foto_suami) }}" alt="Foto Suami"
                                class="mt-2" width="50" height="50" style="object-fit: cover;">
                        @else
                            <img id="previewSuami" class="mt-2 d-none" width="50" height="50"
                                style="object-fit: cover;">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Foto Istri</label>
                        <input type="file" name="foto_istri" class="form-control" accept="image/*"
                            onchange="previewImage(event, 'previewIstri')">
                        {{-- Tampilkan preview jika sudah ada di DB --}}
                        @if ($wedding->foto_istri)
                            <img id="previewIstri" src="{{ asset('storage/' . $wedding->foto_istri) }}" alt="Foto Istri"
                                class="mt-2" width="50" height="50" style="object-fit: cover;">
                        @else
                            <img id="previewIstri" class="mt-2 d-none" width="50" height="50"
                                style="object-fit: cover;">
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Ayah Suami</label>
                        <input type="text" name="nama_ayah_suami" class="form-control"
                            value="{{ old('nama_ayah_suami', $wedding->nama_ayah_suami) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Ibu Suami</label>
                        <input type="text" name="nama_ibu_suami" class="form-control"
                            value="{{ old('nama_ibu_suami', $wedding->nama_ibu_suami) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Ayah Istri</label>
                        <input type="text" name="nama_ayah_istri" class="form-control"
                            value="{{ old('nama_ayah_istri', $wedding->nama_ayah_istri) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Ibu Istri</label>
                        <input type="text" name="nama_ibu_istri" class="form-control"
                            value="{{ old('nama_ibu_istri', $wedding->nama_ibu_istri) }}">
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-success btn-submit">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById(previewId);
                img.src = reader.result;
                img.classList.remove('d-none');
            }
            if (input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function() {
            $('.btn-submit').click(function(e) {
                e.preventDefault(); // cegah submit default
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data yang diubah akan tersimpan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form secara manual
                        $(this).closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection
