@extends('layouts.main', ['title' => 'Obligee'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Obligee">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Obligee</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Status Sinkronisasi</th>
                    <th width="260px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td><x-badge face="label-success">Sinkron</x-badge></td>
                <td>
                    <x-button class="btn-sync" size="sm"  icon="bx bx-refresh" face="warning">Sinkronkan</x-button>
                    <x-button class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Obligee">
        <x-form id="form-create" method="post">
            <x-form-input label="Nama" id="create-name" name="name" class="mb-3" required />
            <x-form-select label="Provinsi" id="create-province-id" :options="[]" name="provinceId" class="mb-3" required/>
            <x-form-select label="Kota" id="create-city-id" :options="[]" name="cityId" class="mb-3" />
            <x-form-textarea label="Alamat" id="create-address" name="address" />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Obligee">
        <div class="mb-5 text-center">
            <div id="show-name" class="h4 mb-2 fw-bold">Nama Obligee Di Sini</div>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Provinsi</b>: <br>
            <span id="show-province">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Kota</b>: <br>
            <span id="show-city">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat</b>: <br>
            <span id="show-address">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Status Sinkronisasi</b>: <br>
            <span id="show-status"><x-badge face="label-success">Sinkron</x-badge></span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>ID Jamsyar</b>: <br>
            <span id="show-jamsyar-id">-</span>
        </div>
        <div>
            <b>Kode Jamsyar</b>: <br>
            <span id="show-jamsyar-code">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Obligee">
        <x-form id="form-edit" method="put">
            <x-form-input label="Nama" id="edit-name" name="name" class="mb-3" required />
            <x-form-select label="Provinsi" id="edit-province-id" :options="[]" name="provinceId" class="mb-3" required/>
            <x-form-select label="Kota" id="edit-city-id" :options="[]" name="cityId" class="mb-3" />
            <x-form-textarea label="Alamat" id="edit-address" name="address" />
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $("#table").DataTable()
            $("#create-province-id, #create-city-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-province-id, #edit-city-id").select2({dropdownParent: $('#modal-edit')})
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Obligee?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
