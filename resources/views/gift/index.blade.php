@extends('layout.app')
@section('title', 'Gift')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-semibold mb-0">Gift List</h5>
                <div>
                    <!-- Tombol Kembali -->
                    <a href="{{ route('wedding.detail', ['id' => $pernikahanId]) }}" class="btn btn-secondary me-2">
                        ← Kembali ke Detail
                    </a>
                    <!-- Button Tambah -->
                    <button class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#addGiftModal">
                        + Tambah
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="giftTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Bank</th>
                            <th>Atas Nama</th>
                            <th>No Rekening</th>
                            <th>Catatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data via DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Gift -->
    <div class="modal fade" id="addGiftModal" tabindex="-1" aria-labelledby="addGiftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGiftModalLabel">Tambah Gift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addGiftForm" action="{{ route('gift.store') }}" method="POST">
                    @csrf
                    <!-- Hidden field pernikahan_id -->
                    <input type="hidden" name="pernikahan_id" value="{{ $pernikahanId }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add_bank_nama" class="form-label">Nama Bank</label>
                            <select class="form-control" id="add_bank_nama" name="bank_nama" required>
                                <option value="">-- Pilih Bank --</option>
                                <option value="BNI">BNI</option>
                                <option value="BCA">BCA</option>
                                <option value="MANDIRI">MANDIRI</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="add_atas_nama" class="form-label">Atas Nama</label>
                            <input type="text" class="form-control" id="add_atas_nama" name="atas_nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_no_rekening" class="form-label">No Rekening</label>
                            <input type="text" class="form-control" id="add_no_rekening" name="no_rekening" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="add_catatan" name="catatan" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Gift -->
    <div class="modal fade" id="editGiftModal" tabindex="-1" aria-labelledby="editGiftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGiftModalLabel">Edit Gift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editGiftForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="edit_gift_id" name="gift_id">
                    <!-- Hidden field pernikahan_id -->
                    <input type="hidden" id="edit_pernikahan_id" name="pernikahan_id" value="{{ $pernikahanId }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_bank_nama" class="form-label">Nama Bank</label>
                            <select class="form-control" id="edit_bank_nama" name="bank_nama" required>
                                <option value="">-- Pilih Bank --</option>
                                <option value="BNI" {{ isset($bankNama) && $bankNama == 'BNI' ? 'selected' : '' }}>BNI
                                </option>
                                <option value="BCA" {{ isset($bankNama) && $bankNama == 'BCA' ? 'selected' : '' }}>BCA
                                </option>
                                <option value="MANDIRI" {{ isset($bankNama) && $bankNama == 'MANDIRI' ? 'selected' : '' }}>MANDIRI
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_atas_nama" class="form-label">Atas Nama</label>
                            <input type="text" class="form-control" id="edit_atas_nama" name="atas_nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_rekening" class="form-label">No Rekening</label>
                            <input type="text" class="form-control" id="edit_no_rekening" name="no_rekening"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="edit_catatan" name="catatan" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            let pernikahanId = '{{ $pernikahanId }}';
            let table = $('#giftTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/gift/data/' + pernikahanId,
                columns: [{
                        data: 'bank_nama',
                        name: 'bank_nama'
                    },
                    {
                        data: 'atas_nama',
                        name: 'atas_nama'
                    },
                    {
                        data: 'no_rekening',
                        name: 'no_rekening'
                    },
                    {
                        data: 'catatan',
                        name: 'catatan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Tambah data
            $('#addGiftForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.post(form.attr('action'), form.serialize())
                    .done(function(res) {
                        Swal.close();
                        $('#addGiftModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        form[0].reset();
                    })
                    .fail(function(xhr) {
                        Swal.close();
                        let errors = xhr.responseJSON?.errors;
                        let errorMsg = errors ? Object.values(errors).flat().join("\n") :
                            "Terjadi kesalahan.";
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errorMsg
                        });
                    });
            });

            // Edit data
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('/gift/' + id + '/edit', function(res) {
                    $('#edit_gift_id').val(res.id);
                    $('#edit_bank_nama').val(res.bank_nama);
                    $('#edit_atas_nama').val(res.atas_nama);
                    $('#edit_no_rekening').val(res.no_rekening);
                    $('#edit_catatan').val(res.catatan);
                    $('#edit_pernikahan_id').val(res.pernikahan_id ||
                        pernikahanId); // pastikan terisi

                    $('#editGiftForm').attr('action', '/gift/' + id + '/update');
                    $('#editGiftModal').modal('show');
                });
            });

            $('#editGiftForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: url,
                    type: 'POST', // tetap POST karena ada _method=PUT
                    data: form.serialize(),
                    success: function(res) {
                        Swal.close();
                        $('#editGiftModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.close();
                        let errors = xhr.responseJSON?.errors;
                        let errorMsg = errors ? Object.values(errors).flat().join("\n") :
                            "Terjadi kesalahan.";
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errorMsg
                        });
                    }
                });
            });

            // Delete data
            $(document).on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        $.ajax({
                            url: '/gift/' + id + '/delete',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.close();
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function() {
                                Swal.close();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan saat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
