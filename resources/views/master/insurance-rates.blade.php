@extends('layouts.main', ['title' => 'Rate Asuransi'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Rate Asuransi">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Rate Asuransi</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama Asuransi</th>
                    <th>Jenis Jaminan</th>
                    <th>Nilai Minimal</th>
                    <th>Nilai Rate</th>
                    <th>Biaya Polis</th>
                    <th>Material</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Rate Asuransi">
        <x-form id="form-create" method="post">
            <x-form-select label="Nama Asuransi" id="create-insurance-id" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id" name="insuranceTypeId" class="mb-3" required/>
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

    <x-modal id="modal-show" title="Detail Rate Asuransi">
        <div class="mb-5 text-center">
            <div id="show-insurance" class="h4 mb-2 fw-bold">Nama Asuransi Di Sini</div>
            <div id="show-insurance-type">Ini Jenis Jaminannya</div>
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

    <x-modal id="modal-edit" title="Ubah Rate Asuransi">
        <x-form id="form-edit" method="put">
            <x-form-select label="Nama Asuransi" id="edit-insurance-id" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="edit-insurance-type-id" name="insuranceTypeId" class="mb-3" required/>
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
        let table = null
        let insuranceRate = null
        $(document).ready(function () {
            table = dataTableInit('table','Insurance Rate',{url : '{{ route('master.insurance-rates.index') }}'},[
                {data: 'insurance.name', name: 'insurance.name'},
                {data: 'insurance_type.name', name: 'insurance_type.name'},
                {data: 'min_value', name: 'min_value'},
                {data: 'rate_value', name: 'rate_value'},
                {data: 'polish_cost', name: 'polish_cost'},
                {data: 'stamp_cost', name: 'stamp_cost'},
            ])
            select2Init("#create-insurance-id, #edit-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-create'))
            select2Init("#create-insurance-type-id, #edit-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-create'))

            select2Init("#edit-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-edit'))
            select2Init("#edit-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-edit'))
        })
        $(document).on('click', '#create-save', function () {
            loading()
            ajaxPost("{{ route('master.insurance-rates.store') }}",fetchFormData(new FormData(document.getElementById('form-create'))),'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })
        $(document).on('click', '#edit-save', function () {
            loading()
            ajaxPost("{{ route('master.insurance-rates.update','-id-') }}".replace('-id-',insuranceRate.id),fetchFormData(new FormData(document.getElementById('form-edit'))),'#modal-edit',function(){
                table.ajax.reload()
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.insurance-rates.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    insuranceRate = response.data
                    $('#show-insurance').html(insuranceRate.insurance.name)
                    $('#show-insurance-type').html(insuranceRate.insurance_type.name)
                    $('#show-min-value').html(insuranceRate.min_value)
                    $('#show-rate-value').html(insuranceRate.rate_value)
                    $('#show-polish-cost').html(insuranceRate.polish_cost)
                    $('#show-stamp-cost').html(insuranceRate.stamp_cost)
                    $('#show-desc').html(insuranceRate.desc)
                }
            })
        })
        $(document).on('click', '.btn-edit', function () {
            select2SetVal('edit-insurance-id',insuranceRate.insurance.id,insuranceRate.insurance.name)
            select2SetVal('edit-insurance-type-id',insuranceRate.insurance_type.id,insuranceRate.insurance_type.name)
            $('#edit-min-value').val(insuranceRate.min_value)
            $('#edit-rate-value').val(insuranceRate.rate_value)
            $('#edit-polish-cost').val(insuranceRate.polish_cost)
            $('#edit-stamp-cost').val(insuranceRate.stamp_cost)
            $('#edit-desc').val(insuranceRate.desc)
        })
        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Rate Asuransi?",
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxPost("{{ route('master.insurance-rates.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method: 'delete'},null,function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
