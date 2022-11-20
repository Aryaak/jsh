@extends('layouts.main', ['title' => 'Pengeluaran'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Pengeluaran">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Pengeluaran</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th>No.</th>
                    <th>Tanggal Transaksi</th>
                    <th>Judul</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Rp0,-</td>
                <td>
                    <x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Pengeluaran">
        <x-form id="form-create" method="post">
            <x-form-input id="create-date" name="date" label="Tanggal Transaksi" type="date" class="mb-3" required />
            <x-form-input id="create-title" name="title" label="Judul" class="mb-3" required />
            <x-form-input id="create-desc" name="desc" label="Keterangan" class="mb-3" required />
            <x-form-input id="create-nominal" name="nominal" label="Nominal" prefix="Rp" suffix=",-" class-input="to-rupiah" required />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Pengeluaran">
        <div class="border-bottom pb-2 mb-2">
            <b>Tanggal Transaksi</b>: <br>
            <span id="show-date">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Judul</b>: <br>
            <span id="show-title">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Keterangan</b>: <br>
            <span id="show-desc">-</span>
        </div>
        <div>
            <b>Nominal</b>: <br>
            <span id="show-nominal">Rp0,-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Pengeluaran">
        <x-form id="form-edit" method="put">
            <x-form-input id="edit-date" name="date" label="Tanggal Transaksi" type="date" class="mb-3" required />
            <x-form-input id="edit-title" name="title" label="Judul" class="mb-3" required />
            <x-form-input id="edit-desc" name="desc" label="Keterangan" class="mb-3" required />
            <x-form-input id="edit-nominal" name="nominal" label="Nominal" prefix="Rp" suffix=",-" class-input="to-rupiah" required />
        </x-form>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="edit-save" face="success" icon="bx bxs-save">Simpan</x-button>
            </div>
        @endslot
    </x-modal>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $("#table").DataTable()
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus pengeluaran?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                }
            })
        })
    </script>
@endpush
