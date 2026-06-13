@extends('layout.app')
@section('title', 'Detail Wedding')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">
    <style>
        .couple-photo-preview {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0 0 1px #dfe5ef, 0 8px 20px rgba(42, 53, 71, .14);
        }

        .cropper-stage {
            width: 100%;
            min-height: 360px;
            max-height: 65vh;
            background: #17202a;
            overflow: hidden;
        }

        .cropper-stage img {
            display: block;
            max-width: 100%;
        }

        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }

        .cropper-view-box {
            outline: 2px solid rgba(255, 255, 255, .95);
            outline-color: rgba(255, 255, 255, .95);
        }
    </style>
@endsection

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
                <p><strong>Nama Lengkap Pria:</strong> {{ $wedding->nama_lengkap_pria ?: '-' }}</p>
                <p><strong>Nama Wanita:</strong> {{ $wedding->nama_wanita }}</p>
                <p><strong>Nama Lengkap Wanita:</strong> {{ $wedding->nama_lengkap_wanita ?: '-' }}</p>
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
                        <input type="file" id="foto_suami" name="foto_suami" class="form-control couple-photo-input"
                            accept="image/jpeg,image/png,image/webp" data-preview="previewSuami" data-label="Foto Suami">
                        <small class="text-muted d-block mt-1">Pilih foto, lalu atur bagian yang tampil di dalam lingkaran.</small>
                        @if ($wedding->foto_suami)
                            <img id="previewSuami" src="{{ asset('storage/' . $wedding->foto_suami) }}" alt="Foto Suami"
                                class="mt-2 couple-photo-preview">
                        @else
                            <img id="previewSuami" class="mt-2 d-none couple-photo-preview">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Foto Istri</label>
                        <input type="file" id="foto_istri" name="foto_istri" class="form-control couple-photo-input"
                            accept="image/jpeg,image/png,image/webp" data-preview="previewIstri" data-label="Foto Istri">
                        <small class="text-muted d-block mt-1">Pilih foto, lalu atur bagian yang tampil di dalam lingkaran.</small>
                        @if ($wedding->foto_istri)
                            <img id="previewIstri" src="{{ asset('storage/' . $wedding->foto_istri) }}" alt="Foto Istri"
                                class="mt-2 couple-photo-preview">
                        @else
                            <img id="previewIstri" class="mt-2 d-none couple-photo-preview">
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

    <div class="modal fade" id="coupleCropModal" tabindex="-1" aria-labelledby="coupleCropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coupleCropModalLabel">Atur Foto Mempelai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Geser foto dan gunakan zoom untuk menentukan bagian yang tampil.</p>
                    <div class="cropper-stage">
                        <img id="coupleCropImage" alt="Foto yang akan dipotong">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="applyCoupleCrop">Gunakan Foto</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error')),
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`,
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
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

        const coupleCropModalElement = document.getElementById('coupleCropModal');
        const coupleCropModal = new bootstrap.Modal(coupleCropModalElement);
        const coupleCropImage = document.getElementById('coupleCropImage');
        const applyCoupleCrop = document.getElementById('applyCoupleCrop');
        let coupleCropper = null;
        let activeCoupleInput = null;
        let activeObjectUrl = null;
        let cropWasApplied = false;

        document.querySelectorAll('.couple-photo-input').forEach(function(input) {
            input.addEventListener('change', function() {
                const file = input.files[0];

                if (!file) {
                    return;
                }

                if (!window.Cropper) {
                    input.value = '';
                    Swal.fire('Editor foto gagal dimuat', 'Periksa koneksi internet lalu coba kembali.', 'error');
                    return;
                }

                activeCoupleInput = input;
                cropWasApplied = false;
                activeObjectUrl = URL.createObjectURL(file);
                coupleCropImage.src = activeObjectUrl;
                document.getElementById('coupleCropModalLabel').textContent = 'Atur ' + input.dataset.label;
                coupleCropModal.show();
            });
        });

        coupleCropModalElement.addEventListener('shown.bs.modal', function() {
            if (coupleCropper) {
                coupleCropper.destroy();
            }

            coupleCropper = new Cropper(coupleCropImage, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: .82,
                background: false,
                responsive: true,
                restore: false,
                guides: false,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        });

        applyCoupleCrop.addEventListener('click', function() {
            if (!coupleCropper || !activeCoupleInput) {
                return;
            }

            applyCoupleCrop.disabled = true;
            applyCoupleCrop.textContent = 'Memproses...';

            const canvas = coupleCropper.getCroppedCanvas({
                width: 1200,
                height: 1200,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            canvas.toBlob(function(blob) {
                if (!blob) {
                    applyCoupleCrop.disabled = false;
                    applyCoupleCrop.textContent = 'Gunakan Foto';
                    Swal.fire('Gagal', 'Foto tidak dapat diproses.', 'error');
                    return;
                }

                const fileName = activeCoupleInput.name + '-' + Date.now() + '.webp';
                const croppedFile = new File([blob], fileName, {
                    type: 'image/webp'
                });
                const transfer = new DataTransfer();
                transfer.items.add(croppedFile);
                activeCoupleInput.files = transfer.files;

                const preview = document.getElementById(activeCoupleInput.dataset.preview);
                preview.src = URL.createObjectURL(blob);
                preview.classList.remove('d-none');
                cropWasApplied = true;
                coupleCropModal.hide();
            }, 'image/webp', .92);
        });

        coupleCropModalElement.addEventListener('hidden.bs.modal', function() {
            if (coupleCropper) {
                coupleCropper.destroy();
                coupleCropper = null;
            }

            if (activeObjectUrl) {
                URL.revokeObjectURL(activeObjectUrl);
                activeObjectUrl = null;
            }

            if (activeCoupleInput && !cropWasApplied) {
                activeCoupleInput.value = '';
            }

            activeCoupleInput = null;
            applyCoupleCrop.disabled = false;
            applyCoupleCrop.textContent = 'Gunakan Foto';
            coupleCropImage.removeAttribute('src');
        });

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
