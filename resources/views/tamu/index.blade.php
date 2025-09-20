@extends('layout.app')
@section('title', 'Tamu')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-semibold mb-0">Tamu List</h5>
                <div>
                    <!-- Tombol Kembali -->
                    <a href="{{ route('wedding.detail', ['id' => $pernikahanId]) }}" class="btn btn-secondary me-2">
                        ← Kembali ke Detail
                    </a>
                    <!-- Button Tambah -->
                    <button class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#tamuModal">
                        + Tambah
                    </button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="ti ti-file-import"></i> Import Excel
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tamuTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No. Telp</th>
                            <th>Email</th>
                            <th>Status Hadir</th>
                            <th>Jumlah Orang</th>
                            <th>Ucapan</th>
                            <th>Show Gift</th>
                            <th>Link Undangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data via DataTables --}}
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="tamuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="tamuForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah/Edit Tamu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="tamu_id">

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" id="nama_tamu" name="nama_tamu" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telp</label>
                            <input type="text" id="no_telp" name="no_telp" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Show Gift</label>
                            <select id="show_gift" name="show_gift" class="form-select">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Tamu dari Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih File Excel</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls"
                                required>
                            <small class="text-muted">Format file: .xlsx atau .xls</small>
                        </div>

                        <!-- Preview Table -->
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-sm" id="previewTable">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>No. Telp</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Show gift</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Isi hasil preview -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-upload"></i> Upload
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // Preview Excel
            $("#file").on("change", function(e) {
                let file = e.target.files[0];
                if (!file) return;

                let reader = new FileReader();
                reader.onload = function(e) {
                    let data = new Uint8Array(e.target.result);
                    let workbook = XLSX.read(data, {
                        type: "array"
                    });

                    // Ambil sheet pertama
                    let sheetName = workbook.SheetNames[0];
                    let worksheet = workbook.Sheets[sheetName];
                    let rows = XLSX.utils.sheet_to_json(worksheet, {
                        header: 1
                    });

                    let tbody = $("#previewTable tbody");
                    tbody.empty();

                    $.each(rows.slice(1), function(i, row) { // skip header
                        if (row.length > 0) {
                            let tr = "<tr>";
                            tr += `<td>${row[0] ?? ""}</td>`;
                            tr += `<td>${row[1] ?? ""}</td>`;
                            tr += `<td>${row[2] ?? ""}</td>`;
                            tr += `<td>${row[3] ?? ""}</td>`;
                            tr += `<td>${row[4] ?? ""}</td>`;
                            tr += "</tr>";
                            tbody.append(tr);
                        }
                    });
                };
                reader.readAsArrayBuffer(file);
            });


            $("#importForm").on("submit", function(e) {
                e.preventDefault();

                let data = [];
                $("#previewTable tbody tr").each(function() {
                    let row = [];
                    $(this).find("td").each(function() {
                        row.push($(this).text().trim());
                    });
                    data.push(row);
                });

                $.ajax({
                    url: "{{ route('wedding.tamu.importArray', $pernikahanId) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: data
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire("Berhasil!", "Data tamu berhasil diimport", "success");
                            $("#importModal").modal("hide");
                            $("#tamuTable").DataTable().ajax.reload();
                        } else {
                            Swal.fire("Gagal!", res.message || "Terjadi kesalahan saat import",
                                "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Terjadi kesalahan server", "error");
                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            let pernikahanId = "{{ $pernikahanId }}";
            let table = $('#tamuTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('wedding.tamu.getdata', $pernikahanId) }}",
                columns: [{
                        data: 'nama_tamu',
                        name: 'nama_tamu'
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status_hadir',
                        name: 'status_hadir'
                    },
                    {
                        data: 'jumlah_orang',
                        name: 'jumlah_orang'
                    },
                    {
                        data: 'ucapan',
                        name: 'ucapan'
                    },
                    {
                        data: 'show_gift',
                        name: 'show_gift',
                        render: function(data) {
                            return data == 1 ?
                                '<span class="badge bg-success">Ya</span>' :
                                '<span class="badge bg-danger">Tidak</span>';
                        }
                    },
                    {
                        data: 'link',
                        name: 'link',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Tambah Tamu
            $('.btn-add').click(function() {
                $('#tamuForm')[0].reset();
                $('#tamu_id').val('');
                $('#tamuModal').modal('show');
            });

            // Simpan / Update
            $('#tamuForm').submit(function(e) {
                e.preventDefault();
                let id = $('#tamu_id').val();
                let url = id ? `/wedding/${pernikahanId}/tamu/${id}` : `/wedding/${pernikahanId}/tamu`;
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#tamuModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire('Berhasil', 'Data berhasil disimpan', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Gagal menyimpan data', 'error');
                    }
                });
            });

            // Edit
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $.get(`/wedding/${pernikahanId}/tamu/${id}`, function(res) {
                    $('#tamu_id').val(res.id);
                    $('#nama_tamu').val(res.nama_tamu);
                    $('#no_telp').val(res.no_telp);
                    $('#email').val(res.email);
                    // $('#status_hadir').val(res.status_hadir);
                    // $('#jumlah_orang').val(res.jumlah_orang);
                    // $('#ucapan').val(res.ucapan);
                    $('#show_gift').val(res.show_gift);
                    $('#tamuModal').modal('show');
                });
            });

            // Hapus
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data tamu akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/wedding/${pernikahanId}/tamu/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {
                                table.ajax.reload();
                                Swal.fire('Terhapus!', 'Data tamu berhasil dihapus.',
                                    'success');
                            },
                            error: function() {
                                Swal.fire('Error', 'Gagal menghapus data', 'error');
                            }
                        });
                    }
                });
            });


            $(document).on('click', '.copy-btn', function() {
                let link = $(this).data('link');

                if (navigator.clipboard && window.isSecureContext) {
                    // HTTPS / Clipboard API tersedia
                    navigator.clipboard.writeText(link).then(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Link berhasil disalin!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }).catch(function(err) {
                        console.error('Gagal copy: ', err);
                    });
                } else {
                    // Fallback untuk HTTP
                    const textArea = document.createElement("textarea");
                    textArea.value = link;
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand("copy");
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Link berhasil disalin!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } catch (err) {
                        console.error("Gagal copy fallback: ", err);
                    }
                    document.body.removeChild(textArea);
                }
            });

        });
    </script>
@endsection
