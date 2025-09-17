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
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Customer</th>
                            <th>Nama Suami</th>
                            <th>Nama Istri</th>
                            <th>Layout</th>
                            <th>Expired</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
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
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addWeddingModal" tabindex="-1" aria-labelledby="addWeddingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWeddingModalLabel">Tambah Wedding</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Nama Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="">-- Pilih Customer --</option>
                                {{-- @foreach ($customers as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->nama }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="suami" class="form-label">Nama Suami</label>
                            <input type="text" class="form-control" id="suami" name="suami"
                                placeholder="Masukkan nama suami" required>
                        </div>
                        <div class="mb-3">
                            <label for="istri" class="form-label">Nama Istri</label>
                            <input type="text" class="form-control" id="istri" name="istri"
                                placeholder="Masukkan nama istri" required>
                        </div>
                        <div class="mb-3">
                            <label for="layout" class="form-label">Layout</label>
                            <select class="form-select" id="layout" name="layout">
                                <option value="Layout 1">Layout 1</option>
                                <option value="Layout 2">Layout 2</option>
                                <option value="Layout 3">Layout 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="expired" class="form-label">Expired</label>
                            <input type="date" class="form-control" id="expired" name="expired" required>
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
