@extends('layout.app')
@section('title', 'Lokasi Pernikahan')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Lokasi Pernikahan List</h5>
            <div>
            <!-- Tombol Kembali -->
            <a href="{{ route('wedding.detail', ['id' => $pernikahanId]) }}" class="btn btn-secondary me-2">
                ← Kembali ke Detail
            </a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLokasiModal">
                + Tambah
            </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="lokasiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Acara</th>
                        <th>Alamat</th>
                        <th>Link Maps</th>
                        <th>Tanggal</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data akan di-load melalui DataTables AJAX --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Lokasi -->
<div class="modal fade" id="addLokasiModal" tabindex="-1" aria-labelledby="addLokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addLokasiForm" method="POST" action="{{ route('lokasi.store') }}">
                @csrf
                <!-- Hidden pernikahan_id -->
                <input type="hidden" name="pernikahan_id" value="{{ $pernikahanId }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_acara_add" class="form-label">Nama Acara</label>
                        <input type="text" class="form-control" id="nama_acara_add" name="nama_acara" placeholder="Contoh: Akad, Resepsi" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_add" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat_add" name="alamat" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="maps_link_add" class="form-label">Link Maps</label>
                        <input type="text" class="form-control" id="maps_link_add" name="maps_link" placeholder="Opsional">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_add" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_add" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai_add" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai_add" name="waktu_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_selesai_add" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai_add" name="waktu_selesai" required>
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

<!-- Modal Edit Lokasi -->
<div class="modal fade" id="editLokasiModal" tabindex="-1" aria-labelledby="editLokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editLokasiForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="lokasi_id_edit" name="lokasi_id">
                <input type="hidden" id="pernikahan_id_edit" name="pernikahan_id" value="{{ $pernikahanId }}"> <!-- Hidden pernikahan_id -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_acara_edit" class="form-label">Nama Acara</label>
                        <input type="text" class="form-control" id="nama_acara_edit" name="nama_acara" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_edit" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat_edit" name="alamat" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="maps_link_edit" class="form-label">Link Maps</label>
                        <input type="text" class="form-control" id="maps_link_edit" name="maps_link">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_edit" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_edit" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai_edit" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai_edit" name="waktu_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_selesai_edit" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai_edit" name="waktu_selesai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
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
    let table = $('#lokasiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/lokasi/data/' + pernikahanId,
        columns: [
            { data: 'nama_acara', name: 'nama_acara' },
            { data: 'alamat', name: 'alamat' },
            { data: 'maps_link', name: 'maps_link' },
            { data: 'tanggal', name: 'tanggal' },
            { data: 'waktu_mulai', name: 'waktu_mulai' },
            { data: 'waktu_selesai', name: 'waktu_selesai' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Reset form Add saat modal dibuka
    $('#addLokasiModal').on('show.bs.modal', function () {
        $(this).find('form')[0].reset();
    });

    // Submit Add Form
    $('#addLokasiForm').off('submit').on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        Swal.fire({ title: 'Menyimpan...', didOpen: () => Swal.showLoading(), allowOutsideClick: false });
        $.post(form.attr('action'), form.serialize(), function(res){
            Swal.close();
            $('#addLokasiModal').modal('hide');
            form[0].reset();
            table.ajax.reload();
            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer:2000, showConfirmButton:false });
        }).fail(function(xhr){
            Swal.close();
            let errors = xhr.responseJSON?.errors;
            Swal.fire({ icon: 'error', title: 'Gagal', text: errors ? Object.values(errors).flat().join("\n") : 'Terjadi kesalahan.' });
        });
    });

    // Open Edit Modal
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $.get('{{ url("/lokasi") }}/' + id + '/edit', function(res){
            $('#lokasi_id_edit').val(res.id);
            $('#pernikahan_id_edit').val(res.pernikahan_id); // <-- set hidden pernikahan_id
            $('#nama_acara_edit').val(res.nama_acara);
            $('#alamat_edit').val(res.alamat);
            $('#maps_link_edit').val(res.maps_link);
            $('#tanggal_edit').val(res.tanggal);
            $('#waktu_mulai_edit').val(res.waktu_mulai);
            $('#waktu_selesai_edit').val(res.waktu_selesai);

            $('#editLokasiForm').attr('action', '{{ url("/lokasi") }}/' + id + '/update');
            $('#editLokasiModal').modal('show');
        });
    });

    // Submit Edit Form
    $('#editLokasiForm').off('submit').on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        Swal.fire({ title: 'Menyimpan...', didOpen: () => Swal.showLoading(), allowOutsideClick: false });
        $.ajax({
            url: form.attr('action'),
            type: 'PUT',
            data: form.serialize(),
            success: function(res){
                Swal.close();
                $('#editLokasiModal').modal('hide');
                table.ajax.reload();
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function(xhr){
                Swal.close();
                let errors = xhr.responseJSON?.errors;
                Swal.fire({ icon: 'error', title: 'Gagal', text: errors ? Object.values(errors).flat().join("\n") : 'Terjadi kesalahan.' });
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
            if(result.isConfirmed){
                Swal.fire({ title: 'Menghapus...', didOpen: () => Swal.showLoading(), allowOutsideClick:false });
                $.ajax({
                    url: '/lokasi/' + id + '/delete',
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res){
                        Swal.close();
                        table.ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer:2000, showConfirmButton:false });
                    },
                    error: function(){
                        Swal.close();
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menghapus data.' });
                    }
                });
            }
        });
    });
});
</script>
@endsection