@extends('layouts.main', ['title' => 'Asuransi'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Asuransi">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Asuransi</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th>Alias</th>
                    <th>Alamat</th>
                    <th>Nama PIC</th>
                    <th>Jabatan PIC</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>
                    <x-button type="icon" class="btn-edit" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Asuransi">
        <x-form id="form-create" method="post">
            <x-form-input id="create-name" name="name" label="Nama" class="mb-3" required />
            <x-form-input id="create-alias" name="alias" label="Alias" class="mb-3" required />
            <x-form-textarea id="create-address" name="address" label="Alamat" class="mb-3" />
            <x-form-input id="create-pic-name" name="pic-name" label="Nama PIC" class="mb-3" />
            <x-form-input id="create-pic-position" name="pic-position" label="Jabatan PIC" />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Asuransi">
        <div class="border-bottom pb-2 mb-2">
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alias</b>: <br>
            <span id="show-alias">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat</b>: <br>
            <span id="show-address">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nama PIC</b>: <br>
            <span id="show-pic-name">-</span>
        </div>
        <div>
            <b>Alamat PIC</b>: <br>
            <span id="show-pic-address">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-show" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Asuransi">
        <x-form id="form-edit" method="put">
            <x-form-input id="edit-name" name="name" label="Nama" class="mb-3" required />
            <x-form-input id="edit-alias" name="alias" label="Alias" class="mb-3" required />
            <x-form-textarea id="edit-address" name="address" label="Alamat" class="mb-3" />
            <x-form-input id="edit-pic-name" name="pic-name" label="Nama PIC" class="mb-3" />
            <x-form-input id="edit-pic-position" name="pic-position" label="Jabatan PIC" />
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
                title: "Yakin ingin menghapus Asuransi?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
