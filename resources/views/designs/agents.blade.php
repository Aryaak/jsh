@extends('layouts.main', ['title' => 'Agen'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Agen">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Agen</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Cabang</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>
                    <x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Agen">
        <x-form id="form-create" method="post">
            <x-form-select label="Cabang" id="create-branch-id" :options="[]" name="branchId" class="mb-3" required/>
            <x-form-input label="Nama" id="create-name" name="name" class="mb-3" required />
            <x-form-input label="No. HP" id="create-phone" name="phone" class="mb-3" required />
            <x-form-input label="Alamat Email" id="create-email" name="email" class="mb-3" type="email" />
            <x-form-textarea label="Alamat" id="create-address" name="address" class="mb-3" />
            <x-form-select label="Nama Bank" id="create-bank-id" :options="[]" name="bankId" class="mb-3"/>
            <x-form-input label="No. Rekening" id="create-bank-number" name="bankNumber" class="mb-3" />
            <x-form-input label="Atas Nama Rekening" id="create-bank-owner-name" name="bankOwnerName" class="mb-3" />
            <x-form-input label="Username Jamsyar" id="create-jamsyar-username" name="jamsyarUsername" class="mb-3" />
            <x-form-input label="Kata Sandi Jamsyar" id="create-jamsyar-password" name="jamsyarPassword" type="password" class="mb-3" />
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <x-form-label for="create-is-verified">Sudah Diverifikasi?</x-form-label>
                    <x-form-check id="create-is-verified" type="switch" name="isVerified"></x-form-check>
                </div>
                <div class="col-sm-6">
                    <x-form-label for="create-is-active">Status Aktif</x-form-label>
                    <x-form-check id="create-is-active" type="switch" name="isActive"></x-form-check>
                </div>
            </div>
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Agen">
        <div class="mb-5 text-center">
            <small>Cabang:</small>
            <div id="show-branch" class="h4 mb-2 fw-bold">Nama Cabangnya</div>
        </div>

        <div class="border-bottom pb-2 mb-2">
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>No. HP</b>: <br>
            <span id="show-phone">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat Email</b>: <br>
            <span id="show-email">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat</b>: <br>
            <span id="show-address">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nama Bank</b>: <br>
            <span id="show-bank">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>No. Rekening</b>: <br>
            <span id="show-bank-number">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Atas Nama Rekening</b>: <br>
            <span id="show-bank-owner">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Username Jamsyar</b>: <br>
            <span id="show-jamsyar-username">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Kata Sandi Rekening</b>: <br>
            <span id="show-jamsyar-password">-</span>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <b>Sudah Diverifikasi</b>: <br>
                <span id="show-is-verified"><x-badge face="label-success" rounded>Sudah</x-badge></span>
            </div>
            <div class="col-sm-6">
                <b>Status Aktif</b>: <br>
                <span id="show-is-active"><x-badge face="label-danger" rounded>Tidak Aktif</x-badge></span>
            </div>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Agen">
        <x-form id="form-edit" method="put">
            <x-form-select label="Cabang" id="edit-branch-id" :options="[]" name="branchId" class="mb-3" required/>
            <x-form-input label="Nama" id="edit-name" name="name" class="mb-3" required />
            <x-form-input label="No. HP" id="edit-phone" name="phone" class="mb-3" required />
            <x-form-input label="Alamat Email" id="edit-email" name="email" class="mb-3" type="email" />
            <x-form-textarea label="Alamat" id="edit-address" name="address" class="mb-3" />
            <x-form-select label="Nama Bank" id="edit-bank-id" :options="[]" name="bankId" class="mb-3"/>
            <x-form-input label="No. Rekening" id="edit-bank-number" name="bankNumber" class="mb-3" />
            <x-form-input label="Atas Nama Rekening" id="edit-bank-owner-name" name="bankOwnerName" class="mb-3" />
            <x-form-input label="Username Jamsyar" id="edit-jamsyar-username" name="jamsyarUsername" class="mb-3" />
            <x-form-input label="Kata Sandi Jamsyar" id="edit-jamsyar-password" name="jamsyarPassword" class="mb-3" type="password" />
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <x-form-label for="edit-is-verified">Sudah Diverifikasi?</x-form-label>
                    <x-form-check id="edit-is-verified" type="switch" name="isVerified"></x-form-check>
                </div>
                <div class="col-sm-6">
                    <x-form-label for="edit-is-active">Status Aktif</x-form-label>
                    <x-form-check id="edit-is-active" type="switch" name="isActive"></x-form-check>
                </div>
            </div>
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
            $("#create-branch-id, #create-bank-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-branch-id, #edit-bank-id").select2({dropdownParent: $('#modal-edit')})
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Agen?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
