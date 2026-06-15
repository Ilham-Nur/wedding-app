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
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#whatsappTemplateModal">
                        <i class="ti ti-brand-whatsapp"></i> Template WhatsApp
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tamuTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
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

    <!-- Modal Template WhatsApp -->
    <div class="modal fade" id="whatsappTemplateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <form id="whatsappTemplateForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title">Desain Template Pesan WhatsApp</h5>
                            <div class="small text-muted">Template ini digunakan oleh seluruh tombol kirim WhatsApp pada daftar tamu.</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-lg-7">
                                <label for="whatsapp_template" class="form-label fw-semibold">Isi Pesan</label>
                                <textarea id="whatsapp_template" name="whatsapp_template" class="form-control font-monospace"
                                    rows="19" maxlength="10000" required>{{ $whatsappTemplate }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Format WhatsApp: <code>*tebal*</code>, <code>_miring_</code>, dan <code>~coret~</code>.</small>
                                    <small class="text-muted"><span id="whatsappTemplateCount">0</span>/10000</small>
                                </div>

                                <div class="mt-3">
                                    <div class="form-label fw-semibold mb-2">Sisipkan Data Otomatis</div>
                                    <div class="d-flex flex-wrap gap-2" id="whatsappPlaceholderButtons">
                                        @foreach(array_keys($whatsappPreviewValues) as $placeholder)
                                            <button type="button" class="btn btn-sm btn-outline-success whatsapp-placeholder"
                                                data-placeholder="{{ $placeholder }}">
                                                {{ $placeholder }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="form-label fw-semibold mb-0">Preview Pesan</span>
                                    <span class="badge bg-success">Data contoh</span>
                                </div>
                                <div id="whatsappTemplatePreview" class="border rounded-3 p-3 bg-light"
                                    style="min-height: 420px; white-space: pre-wrap; overflow-wrap: anywhere;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" id="resetWhatsappTemplate">
                            Reset ke Template Bawaan
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy"></i> Simpan Template
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
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
                        <div class="alert alert-info d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <strong>Gunakan template yang tersedia.</strong>
                                <div class="small">Nomor telepon akan dipertahankan sebagai teks dan kolom Show Gift menerima 1 atau 0.</div>
                            </div>
                            <a href="{{ asset('templates/template-import-tamu.xlsx') }}" class="btn btn-sm btn-outline-primary flex-shrink-0" download>
                                <i class="ti ti-download"></i> Download Template
                            </a>
                        </div>
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
                        header: 1,
                        raw: false,
                        defval: ""
                    });

                    let tbody = $("#previewTable tbody");
                    tbody.empty();

                    const expectedHeaders = ["nama", "no. telp", "email", "alamat", "show gift"];
                    const actualHeaders = (rows[0] || []).slice(0, 5).map(value => String(value).trim().toLowerCase());

                    if (expectedHeaders.some((header, index) => actualHeaders[index] !== header)) {
                        $("#file").val("");
                        Swal.fire("Format tidak sesuai", "Gunakan file template import tamu yang tersedia.", "warning");
                        return;
                    }

                    $.each(rows.slice(1), function(i, row) { // skip header
                        if (String(row[0] ?? "").trim() !== "") {
                            const tr = $("<tr>");
                            for (let column = 0; column < 5; column++) {
                                $("<td>").text(row[column] ?? "").appendTo(tr);
                            }
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
                            $("#importForm")[0].reset();
                            $("#previewTable tbody").empty();
                            $("#tamuTable").DataTable().ajax.reload();
                        } else {
                            Swal.fire("Gagal!", res.message || "Terjadi kesalahan saat import",
                                "error");
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
                        const message = errors
                            ? Object.values(errors).flat().join("<br>")
                            : xhr.responseJSON?.message || "Terjadi kesalahan server";
                        Swal.fire({
                            icon: "error",
                            title: "Import gagal",
                            html: message
                        });
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
                        data: 'DT_RowIndex', // otomatis dari addIndexColumn
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
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

            const whatsappPreviewValues = @json($whatsappPreviewValues);
            const defaultWhatsappTemplate = @json($defaultWhatsappTemplate);
            const whatsappTemplateInput = document.getElementById('whatsapp_template');
            const whatsappTemplatePreview = document.getElementById('whatsappTemplatePreview');
            const whatsappTemplateCount = document.getElementById('whatsappTemplateCount');

            function renderWhatsappTemplatePreview() {
                let preview = whatsappTemplateInput.value;

                Object.entries(whatsappPreviewValues).forEach(([placeholder, value]) => {
                    preview = preview.split(placeholder).join(value ?? '');
                });

                whatsappTemplatePreview.textContent = preview;
                whatsappTemplateCount.textContent = whatsappTemplateInput.value.length;
            }

            whatsappTemplateInput.addEventListener('input', renderWhatsappTemplatePreview);
            renderWhatsappTemplatePreview();

            $(document).on('click', '.whatsapp-placeholder', function() {
                const placeholder = $(this).data('placeholder');
                const start = whatsappTemplateInput.selectionStart;
                const end = whatsappTemplateInput.selectionEnd;
                const current = whatsappTemplateInput.value;

                whatsappTemplateInput.value = current.slice(0, start) + placeholder + current.slice(end);
                whatsappTemplateInput.focus();
                whatsappTemplateInput.setSelectionRange(start + placeholder.length, start + placeholder.length);
                renderWhatsappTemplatePreview();
            });

            $('#resetWhatsappTemplate').click(function() {
                whatsappTemplateInput.value = defaultWhatsappTemplate;
                renderWhatsappTemplatePreview();
            });

            $('#whatsappTemplateForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('wedding.tamu.whatsappTemplate.update', $pernikahanId) }}",
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        whatsapp_template: whatsappTemplateInput.value
                    },
                    success: function(res) {
                        $('#whatsappTemplateModal').modal('hide');
                        table.ajax.reload(null, false);
                        Swal.fire('Berhasil', res.message || 'Template WhatsApp berhasil disimpan.', 'success');
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
                        const message = errors
                            ? Object.values(errors).flat().join('<br>')
                            : xhr.responseJSON?.message || 'Gagal menyimpan template WhatsApp';

                        Swal.fire({
                            icon: 'error',
                            title: 'Template gagal disimpan',
                            html: message
                        });
                    }
                });
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
