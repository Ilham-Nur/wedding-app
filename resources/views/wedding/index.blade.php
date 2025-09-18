@extends('layout.app')
@section('title', 'Wedding')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-semibold mb-0">Wedding List</h5>
                <!-- Button Tambah -->
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addWeddingModal">
                    + Tambah
                </button>
            </div>

            <div class="table-responsive">
                <table id="weddingTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Pria</th>
                            <th>Nama Wanita</th>
                            <th>Tanggal</th>
                            <th>Pembeli</th>
                            <th>Layout</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td>15-09-2025</td>
                            <td>Pak Joko</td>
                            <td>Andi</td>
                            <td>Siti</td>
                            <td>Layout 1</td>
                            <td>20-09-2025</td>
                            <td>
                                <button class="btn btn-sm btn-info">Detail</button>
                                <button class="btn btn-sm btn-primary">Edit</button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>18-09-2025</td>
                            <td>Ibu Rina</td>
                            <td>Budi</td>
                            <td>Ani</td>
                            <td>Layout 2</td>
                            <td>25-09-2025</td>
                            <td>
                                <button class="btn btn-sm btn-info">Detail</button>
                                <button class="btn btn-sm btn-primary">Edit</button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Wedding -->
    <div class="modal fade" id="addWeddingModal" tabindex="-1" aria-labelledby="addWeddingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWeddingModalLabel">Tambah Wedding</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="weddingForm" method="POST">
                    @csrf
                    <input type="hidden" id="wedding_id" name="wedding_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="pembeli_id" class="form-label">Nama Customer</label>
                            <select class="form-select" id="pembeli_id" name="pembeli_id" required>
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customers as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_pria" class="form-label">Nama Suami</label>
                            <input type="text" class="form-control" id="nama_pria" name="nama_pria"
                                placeholder="Masukkan nama Suami" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_wanita" class="form-label">Nama Istri</label>
                            <input type="text" class="form-control" id="nama_wanita" name="nama_wanita"
                                placeholder="Masukkan nama Istri" required>
                        </div>
                        <div class="mb-3">
                            <label for="layout" class="form-label">Layout</label>
                            <select class="form-select" id="layout_id" name="layout_id">
                                @foreach ($layouts as $layout)
                                    <option value="{{ $layout->id }}">{{ $layout->nama_layout }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="masa_aktif" class="form-label">Expired</label>
                            <input type="date" class="form-control" id="masa_aktif" name="masa_aktif" required>
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



@endsection


@section('script')
    <script>
        $(function() {
            let table = $('#weddingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('wedding.data') }}',
                columns: [{
                        data: 'nama_pria',
                        name: 'nama_pria'
                    },
                    {
                        data: 'nama_wanita',
                        name: 'nama_wanita'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'pembeli',
                        name: 'pembeli'
                    },
                    {
                        data: 'layout',
                        name: 'layout'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
            // Tambah data
            $(document).on('click', '.btn-add', function() {
                $('#weddingForm')[0].reset();
                $('#wedding_id').val('');
                $('#addWeddingModalLabel').text('Tambah Wedding');
                $('#weddingForm').attr('action', '{{ route('wedding.store') }}');
                $('#weddingForm').find('input[name="_method"]').remove();
                $('#addWeddingModal').modal('show');
            });

            // Edit data
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('/wedding/' + id, function(res) {
                    $('#wedding_id').val(res.id);
                    $('#tanggal').val(res.tanggal);
                    $('#pembeli_id').val(res.pembeli_id);
                    $('#nama_pria').val(res.nama_pria);
                    $('#nama_wanita').val(res.nama_wanita);
                    $('#layout_id').val(res.layout_id);
                    $('#masa_aktif').val(res.masa_aktif);

                    $('#addWeddingModalLabel').text('Edit Wedding');
                    $('#weddingForm').attr('action', '/wedding/' + id);
                    if (!$('#weddingForm input[name="_method"]').length) {
                        $('#weddingForm').append(
                        '<input type="hidden" name="_method" value="PUT">');
                    }
                    $('#addWeddingModal').modal('show');
                });
            });

            // Submit form via AJAX
            $('#weddingForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let method = form.find('input[name="_method"]').val() || form.attr('method');

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: method,
                    data: form.serialize(),
                    success: function(res) {
                        Swal.close();
                        $('#addWeddingModal').modal('hide');
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
                        let errorMsg = "Terjadi kesalahan.";
                        if (errors) {
                            errorMsg = Object.values(errors).flat().join("\n");
                        }
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
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/wedding/' + id,
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
