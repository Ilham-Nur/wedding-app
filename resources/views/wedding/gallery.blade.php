@extends('layout.app')
@section('title', 'Gallery Wedding')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-semibold mb-0">Detail Wedding</h5>
            </div>
            <div>
                <a href="{{ route('wedding.detail', $wedding->id) }}" class="btn btn-outline-primary m-1">← Kembali</a>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-semibold mb-0">Manajemen Galeri Foto</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahFotoModal">
                    + Tambah Foto
                </button>
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Preview</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Urutan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wedding->galeris as $foto)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $foto->file_path) }}" alt="{{ $foto->judul }}" width="100"
                                        style="object-fit: cover;">
                                </td>
                                <td>{{ $foto->judul ?? '-' }}</td>
                                <td>{{ $foto->urutan }}</td>
                                <td>
                                    <form class="form-delete" action="{{ route('gallery.destroy', $foto->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada foto di galeri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahFotoModal" tabindex="-1" aria-labelledby="tambahFotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahFotoModalLabel">Tambah Foto Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pernikahan_id" value="{{ $wedding->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_path" class="form-label">Pilih Foto (Bisa lebih dari satu)</label>
                            <input class="form-control" type="file" name="file_path[]" id="file_path" multiple required>
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul (Opsional)</label>
                            <input type="text" class="form-control" name="judul" id="judul"
                                placeholder="Contoh: Momen Prewedding">
                        </div>
                        <div class="mb-3">
                            <label for="urutan" class="form-label">Nomor Urut (Opsional)</label>
                            <input type="number" class="form-control" name="urutan" id="urutan" placeholder="0" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Tampilkan notifikasi SUKSES jika ada pesan dari controller
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        $(document).ready(function () {

            $('.form-delete').submit(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Foto ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });


            $('#formTambahFoto').submit(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Simpan Foto?',
                    text: "Foto yang dipilih akan ditambahkan ke galeri.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
