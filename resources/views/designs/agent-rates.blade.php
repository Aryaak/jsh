@extends('layouts.main', ['title' => 'Rate Agen'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Rate Agen">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Rate Agen</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Agen</th>
                    <th>Jenis Jaminan</th>
                    <th>Nilai Minimal</th>
                    <th>Nilai Rate</th>
                    <th>Biaya Polis</th>
                    <th>Material</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Rp10.000,-</td>
                <td>0.123</td>
                <td>Rp10.000,-</td>
                <td>Rp6.000,-</td>
                <td>
                    <x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Rate Agen">
        <x-form id="form-create" method="post">
            <x-form-select label="Agen" id="create-agent-id" :options="[]" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="create-insurance-id" :options="[]" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id" :options="[]" name="insuranceTypeId" class="mb-3" required/>
            <x-form-input label="Nilai Minimal" id="create-min-value" name="minValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Nilai Rate" id="create-rate-value" name="rateValue" class="mb-3" classInput="to-unit" data-decimals="3" required />
            <x-form-input label="Biaya Polis" id="create-polish-cost" name="polishCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Material" id="create-stamp-cost" name="stampCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="create-desc" name="desc" />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Rate Agen">
        <div class="mb-5 text-center">
            <div id="show-agent" class="h4 mb-2 fw-bold">Nama Agen Di Sini</div>
            <div id="show-insurance-type">Ini Jenis Jaminannya</div>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nama Asuransi</b>: <br>
            <span id="show-insurance">Tes</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nilai Minimal</b>: <br>
            <span id="show-min-value">Rp10.000,-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nilai Rate</b>: <br>
            <span id="show-rate-value">0,240</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Biaya Polis</b>: <br>
            <span id="show-polish-cost">Rp10.000,-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Material</b>: <br>
            <span id="show-stamp-cost">Rp6.000,-</span>
        </div>
        <div>
            <b>Keterangan</b>: <br>
            <span id="show-desc">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Rate Agen">
        <x-form id="form-edit" method="put">
            <x-form-select label="Agen" id="edit-agent-id" :options="[]" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="edit-insurance-id" :options="[]" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="edit-insurance-type-id" :options="[]" name="insuranceTypeId" class="mb-3" required/>
            <x-form-input label="Nilai Minimal" id="edit-min-value" name="minValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Nilai Rate" id="edit-rate-value" name="rateValue" class="mb-3" classInput="to-unit" data-decimals="3" required />
            <x-form-input label="Biaya Polis" id="edit-polish-cost" name="polishCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Material" id="edit-stamp-cost" name="stampCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="edit-desc" name="desc" />
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
            $("#create-agent-id, #create-insurance-id, #create-insurance-type-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-agent-id, #edit-insurance-id, #edit-insurance-type-id").select2({dropdownParent: $('#modal-edit')})
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Rate Agen?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
