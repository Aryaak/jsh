@extends('layouts.main', ['title' => 'Rate Agen'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Rate Agen Surety Bond" class="mb-4">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create-sb" size="sm" icon="bx bx-plus">Tambah Rate Agen Surety Bond</x-button>
        @endslot

        <x-table id="table-sb">
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
                    <x-button type="icon" class="btn-show-sb" data-bs-toggle="modal" data-bs-target="#modal-show-sb" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete-sb" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>

    <x-card header="Daftar Rate Agen Bank Garansi">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create-bg" size="sm" icon="bx bx-plus">Tambah Rate Agen Bank Garansi</x-button>
        @endslot

        <x-table id="table-bg">
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
                    <x-button type="icon" class="btn-show-bg" data-bs-toggle="modal" data-bs-target="#modal-show-bg" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete-bg" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    {{-- Surety Bond --}}

    <x-modal id="modal-create-sb" title="Tambah Rate Agen Surety Bond">
        <x-form id="form-create-sb" method="post">
            <x-form-select label="Agen" id="create-agent-id-sb" :options="[]" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="create-insurance-id-sb" :options="[]" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id-sb" :options="[]" name="insuranceTypeId" class="mb-3" required/>
            <x-form-input label="Nilai Minimal" id="create-min-value-sb" name="minValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Nilai Rate" id="create-rate-value-sb" name="rateValue" class="mb-3" classInput="to-unit" data-decimals="2" required />
            <x-form-input label="Biaya Polis" id="create-polish-cost-sb" name="polishCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Material" id="create-stamp-cost-sb" name="stampCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="create-desc-sb" name="desc" />
        </x-form>

        @slot('footer')
            <x-button id="create-save-sb" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show-sb" title="Detail Rate Agen Surety Bond">
        <div class="mb-5 text-center">
            <div id="show-agent-sb" class="h4 mb-2 fw-bold">Nama Agen Di Sini</div>
            <div id="show-insurance-type-sb">Ini Jenis Jaminannya</div>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nama Asuransi</b>: <br>
            <span id="show-insurance-sb">Tes</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nilai Minimal</b>: <br>
            <span id="show-min-value-sb">Rp10.000,-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nilai Rate</b>: <br>
            <span id="show-rate-value-sb">0,240</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Biaya Polis</b>: <br>
            <span id="show-polish-cost-sb">Rp10.000,-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Material</b>: <br>
            <span id="show-stamp-cost-sb">Rp6.000,-</span>
        </div>
        <div>
            <b>Keterangan</b>: <br>
            <span id="show-desc-sb">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit-sb" data-bs-target="#modal-edit-sb" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit-sb" title="Ubah Rate Agen Surety Bond">
        <x-form id="form-edit-sb" method="put">
            <x-form-select label="Agen" id="edit-agent-id-sb" :options="[]" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="edit-insurance-id-sb" :options="[]" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="edit-insurance-type-id-sb" :options="[]" name="insuranceTypeId" class="mb-3" required/>
            <x-form-input label="Nilai Minimal" id="edit-min-value-sb" name="minValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Nilai Rate" id="edit-rate-value-sb" name="rateValue" class="mb-3" classInput="to-unit" data-decimals="2" required />
            <x-form-input label="Biaya Polis" id="edit-polish-cost-sb" name="polishCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Material" id="edit-stamp-cost-sb" name="stampCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="edit-desc-sb" name="desc" />
        </x-form>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show-sb" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="edit-save-sb" face="success" icon="bx bxs-save">Simpan</x-button>
            </div>
        @endslot
    </x-modal>

    {{-- Bank Garansi --}}

    <x-modal id="modal-create-bg" title="Tambah Rate Agen Bank Garansi">
        <x-form id="form-create-bg" method="post">
            <x-form-select label="Agen" id="create-agent-id-bg" :options="[]" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="create-insurance-id-bg" :options="[]" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id-bg" :options="[]" name="insuranceTypeId" class="mb-3" required/>
            <x-form-input label="Nilai Minimal" id="create-min-value-bg" name="minValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Nilai Rate" id="create-rate-value-bg" name="rateValue" class="mb-3" classInput="to-unit" data-decimals="2" required />
            <x-form-input label="Biaya Polis" id="create-polish-cost-bg" name="polishCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Material" id="create-stamp-cost-bg" name="stampCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="create-desc-bg" name="desc" />
        </x-form>

        @slot('footer')
            <x-button id="create-save-bg" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show-bg" title="Detail Rate Agen Bank Garansi">
        <div class="mb-5 text-center">
            <div id="show-agent-bg" class="h4 mb-2 fw-bold">Nama Agen Di Sini</div>
            <div id="show-insurance-type-bg">Ini Jenis Jaminannya</div>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nama Asuransi</b>: <br>
            <span id="show-insurance-bg">Tes</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nilai Minimal</b>: <br>
            <span id="show-min-value-bg">Rp10.000,-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nilai Rate</b>: <br>
            <span id="show-rate-value-bg">0,240</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Biaya Polis</b>: <br>
            <span id="show-polish-cost-bg">Rp10.000,-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Material</b>: <br>
            <span id="show-stamp-cost-bg">Rp6.000,-</span>
        </div>
        <div>
            <b>Keterangan</b>: <br>
            <span id="show-desc-bg">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit-bg" data-bs-target="#modal-edit-bg" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit-bg" title="Ubah Rate Agen Bank Garansi">
        <x-form id="form-edit-bg" method="put">
            <x-form-select label="Agen" id="edit-agent-id-bg" :options="[]" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="edit-insurance-id-bg" :options="[]" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="edit-insurance-type-id-bg" :options="[]" name="insuranceTypeId" class="mb-3" required/>
            <x-form-input label="Nilai Minimal" id="edit-min-value-bg" name="minValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Nilai Rate" id="edit-rate-value-bg" name="rateValue" class="mb-3" classInput="to-unit" data-decimals="2" required />
            <x-form-input label="Biaya Polis" id="edit-polish-cost-bg" name="polishCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-input label="Material" id="edit-stamp-cost-bg" name="stampCost" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="edit-desc-bg" name="desc" />
        </x-form>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show-bg" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="edit-save-bg" face="success" icon="bx bxs-save">Simpan</x-button>
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
            $("#create-agent-id-sb, #create-insurance-id-sb, #create-insurance-type-id-sb").select2({dropdownParent: $('#modal-create-sb')})
            $("#edit-agent-id-sb, #edit-insurance-id-sb, #edit-insurance-type-id-sb").select2({dropdownParent: $('#modal-edit-sb')})
            $("#create-agent-id-bg, #create-insurance-id-bg, #create-insurance-type-id-bg").select2({dropdownParent: $('#modal-create-bg')})
            $("#edit-agent-id-bg, #edit-insurance-id-bg, #edit-insurance-type-id-bg").select2({dropdownParent: $('#modal-edit-bg')})
        })

        $(document).on('click', '.btn-delete-sb', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Rate Agen?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })

        $(document).on('click', '.btn-delete-bg', function () {
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
