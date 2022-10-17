@extends('layouts.main', ['title' => 'Master Data'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Data">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Data</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th width="240px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>
                    <x-button class="btn-sync" size="sm" icon="bx bx-refresh" face="warning">Sinkron</x-button>
                    <x-button class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Data">
        <x-form id="form-create" method="post">
            <x-form-input id="create-name" name="name" label="Nama" class="mb-3" required />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Data">
        <div class="border-bottom pb-2 mb-2">
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Data">
        <x-form id="form-edit" method="put">
            <x-form-input id="edit-name" name="name" label="Nama" class="mb-3" required />
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
                title: "Yakin ingin menghapus data?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
