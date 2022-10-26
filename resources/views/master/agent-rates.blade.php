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
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Rate Agen">
        <x-form id="form-create" method="post">
            <x-form-select label="Agen" id="create-agent-id" name="agentId" class="mb-3" required/>
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
        let agentRate = null
        let table = null
        $(document).ready(function () {
            table = dataTableInit('table','Rate Agen',{url : '{{ route('master.agent-rates.index') }}'},[
                {data: 'agent.name', name: 'agent.name'},
                {data: 'insurance_type.name', name: 'insurance_type.name'},
                {data: 'min_value', name: 'min_value'},
                {data: 'rate_value', name: 'rate_value'},
                {data: 'polish_cost', name: 'polish_cost'},
                {data: 'stamp_cost', name: 'stamp_cost'},
            ])
            select2Init("#create-agent-id, #edit-agent-id",'{{ route('select2.agent') }}',0,$('#modal-create'))
            select2Init("#create-insurance-id, #edit-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-create'))
            select2Init("#create-insurance-type-id, #edit-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-create'))

            select2Init("#edit-agent-id",'{{ route('select2.agent') }}',0,$('#modal-edit'))
            select2Init("#edit-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-edit'))
            select2Init("#edit-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-edit'))
            // $("#create-agent-id, #create-insurance-id, #create-insurance-type-id").select2({dropdownParent: $('#modal-create')})
            // $("#edit-agent-id, #edit-insurance-id, #edit-insurance-type-id").select2({dropdownParent: $('#modal-edit')})
        })
        $(document).on('click', '#create-save', function () {
            loading()
            ajaxPost("{{ route('master.agent-rates.store') }}",fetchFormData(new FormData(document.getElementById('form-create'))),'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })
        $(document).on('click', '#edit-save', function () {
            loading()
            ajaxPost("{{ route('master.agent-rates.update','-id-') }}".replace('-id-',agentRate.id),fetchFormData(new FormData(document.getElementById('form-edit'))),'#modal-edit',function(){
                table.ajax.reload()
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.agent-rates.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    agentRate = response.data
                    $('#show-agent').html(agentRate.agent.name)
                    $('#show-insurance-type').html(agentRate.insurance_type.name)
                    $('#show-insurance').html(agentRate.insurance.name)
                    $('#show-min-value').html((ToRupiah.format(agentRate.min_value)).replace('\u00A0', '') + ",-")
                    $('#show-rate-value').html(ToUnit.format(agentRate.rate_value))
                    $('#show-polish-cost').html((ToRupiah.format(agentRate.polish_cost)).replace('\u00A0', '') + ",-")
                    $('#show-stamp-cost').html((ToRupiah.format(agentRate.stamp_cost)).replace('\u00A0', '') + ",-")
                    $('#show-desc').html(agentRate.desc)
                }
            })
        })
        $(document).on('click', '.btn-edit', function () {
            select2SetVal('edit-agent-id',agentRate.agent.id,agentRate.agent.name)
            select2SetVal('edit-insurance-id',agentRate.insurance.id,agentRate.insurance.name)
            select2SetVal('edit-insurance-type-id',agentRate.insurance_type.id,agentRate.insurance_type.name)
            $('#edit-min-value').val((ToRupiah.format(agentRate.min_value)).replace('Rp\u00A0', ''))
            $('#edit-rate-value').val(ToUnit.format(agentRate.rate_value))
            $('#edit-polish-cost').val((ToRupiah.format(agentRate.polish_cost)).replace('Rp\u00A0', ''))
            $('#edit-stamp-cost').val((ToRupiah.format(agentRate.stamp_cost)).replace('Rp\u00A0', ''))
            $('#edit-desc').val(agentRate.desc)
        })
        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Rate Agen?",
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxPost("{{ route('master.agent-rates.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method: 'delete'},null,function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
