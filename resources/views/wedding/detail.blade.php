@extends('layout.app')
@section('title', 'Detail Wedding')

@section('content')
    <a href="{{ route('wedding.index') }}" class="btn btn-secondary mb-2">
        ← Kembali
    </a>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-semibold mb-0">Detail Wedding</h5>

                {{-- Tombol Arah ke Gallery & Gift --}}
                <div class="mb-3">
                    <a href="{{ route('gallery.index', $wedding->id) }}" class="btn btn-outline-info">📷 Gallery</a>
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
                        @if ($wedding->foto_istri)
                            <img id="previewIstri" src="{{ asset('storage/' . $wedding->foto_istri) }}" alt="Foto Istri"
                                class="mt-2" width="50" height="50" style="object-fit: cover;">
                        @else
                            <img id="previewIstri" class="mt-2 d-none" width="50" height="50"
                                style="object-fit: cover;">
                        @endif
                    </div>
                </div>

                {{-- Foto Utama --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Foto Utama</label>
                        <input type="file" name="foto_utama" class="form-control" accept="image/*"
                            onchange="previewImage(event, 'previewUtama')">
                        @if ($wedding->foto_utama)
                            <img id="previewUtama" src="{{ asset('storage/' . $wedding->foto_utama) }}" alt="Foto Utama"
                                class="mt-2" width="80" height="80" style="object-fit: cover;">
                        @else
                            <img id="previewUtama" class="mt-2 d-none" width="80" height="80"
                                style="object-fit: cover;">
                        @endif
                    </div>
                </div>

                {{-- File Musik --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">File Musik</label>
                        <input type="file" name="file_musik" class="form-control" accept="audio/*">
                        @if ($wedding->file_musik)
                            <audio controls class="mt-2" style="width: 100%;">
                                <source src="{{ asset('storage/' . $wedding->file_musik) }}" type="audio/mpeg">
                                Browser Anda tidak mendukung audio.
                            </audio>
                        @endif
                    </div>
                </div>

                {{-- Orang Tua --}}
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

                {{-- Turut Mengundang Pihak Laki-laki --}}
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Turut Mengundang Pihak Laki-laki</label>
                        <div id="editor-pria" style="height:200px; background:#fff;">
                            {!! old('turut_mengundang_pria', $wedding->turut_mengundang_pria ?? '') !!}
                        </div>
                        <input type="hidden" name="turut_mengundang_pria" id="input-pria">
                    </div>
                </div>

                {{-- Turut Mengundang Pihak Perempuan --}}
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Turut Mengundang Pihak Perempuan</label>
                        <div id="editor-wanita" style="height:200px; background:#fff;">
                            {!! old('turut_mengundang_wanita', $wedding->turut_mengundang_wanita ?? '') !!}
                        </div>
                        <input type="hidden" name="turut_mengundang_wanita" id="input-wanita">
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

        var quillPria = new Quill('#editor-pria', {
            theme: 'snow'
        });
        var quillWanita = new Quill('#editor-wanita', {
            theme: 'snow'
        });

        $(document).ready(function() {
            $('.btn-submit').click(function(e) {
                e.preventDefault();

                // simpan isi Quill ke hidden input
                $('#input-pria').val(quillPria.root.innerHTML);
                $('#input-wanita').val(quillWanita.root.innerHTML);

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
                        $(this).closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection
