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
                    <th>Bank</th>
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
    {{-- Surety Bond --}}

    <x-modal id="modal-create-sb" title="Tambah Rate Agen Surety Bond">
        <x-form id="form-create-sb" method="post">
            <x-form-select label="Agen" id="create-agent-id-sb" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="create-insurance-id-sb" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id-sb" name="insuranceTypeId" class="mb-3" required/>
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
            <x-form-select label="Agen" id="create-agent-id-bg" name="agentId" class="mb-3" required/>
            <x-form-select label="Nama Asuransi" id="create-insurance-id-bg" name="insuranceId" class="mb-3" required/>
            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id-bg" name="insuranceTypeId" class="mb-3" required/>
            <x-form-select label="Bank" id="create-bank-id-bg" name="bankId" class="mb-3" required/>
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
            <b>Nama Bank</b>: <br>
            <span id="show-bank-bg">Tes</span>
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
            <x-form-select label="Bank" id="edit-bank-id-bg" name="bankId" class="mb-3" required/>
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
        let agentRateSB = null
        let agentRateBG = null
        let tableSB = null
        let tableBG = null
        $(document).ready(function () {
            tableSB = dataTableInit('table-sb','Rate Agen',{
                    url : '{{ route('master.agent-rates.index') }}',
                    data : { is_bg : 0 }
                },[
                {data: 'agent.name', name: 'agent.name'},
                {data: 'insurance_type.name', name: 'insurance_type.name'},
                {data: 'min_value', name: 'min_value'},
                {data: 'rate_value', name: 'rate_value'},
                {data: 'polish_cost', name: 'polish_cost'},
                {data: 'stamp_cost', name: 'stamp_cost'},
            ])
            tableBG = dataTableInit('table-bg','Rate Agen',{
                    url : '{{ route('master.agent-rates.index') }}',
                    data : { is_bg : 1 }
                },[
                {data: 'agent.name', name: 'agent.name'},
                {data: 'insurance_type.name', name: 'insurance_type.name'},
                {data: 'bank.name', name: 'bank.name'},
                {data: 'min_value', name: 'min_value'},
                {data: 'rate_value', name: 'rate_value'},
                {data: 'polish_cost', name: 'polish_cost'},
                {data: 'stamp_cost', name: 'stamp_cost'},
            ])
            select2Init("#create-agent-id-sb, #edit-agent-id-sb",'{{ route('select2.agent') }}',0,$('#modal-create-sb'))
            select2Init("#create-insurance-id-sb, #edit-insurance-id-sb",'{{ route('select2.insurance') }}',0,$('#modal-create-sb'))
            select2Init("#create-insurance-type-id-sb, #edit-insurance-type-id-sb",'{{ route('select2.insuranceType') }}',0,$('#modal-create-sb'))

            select2Init("#edit-agent-id-sb",'{{ route('select2.agent') }}',0,$('#modal-edit-sb'))
            select2Init("#edit-insurance-id-sb",'{{ route('select2.insurance') }}',0,$('#modal-edit-sb'))
            select2Init("#edit-insurance-type-id-sb",'{{ route('select2.insuranceType') }}',0,$('#modal-edit-sb'))

            select2Init("#create-agent-id-bg, #edit-agent-id-bg",'{{ route('select2.agent') }}',0,$('#modal-create-bg'))
            select2Init("#create-insurance-id-bg, #edit-insurance-id-bg",'{{ route('select2.insurance') }}',0,$('#modal-create-bg'))
            select2Init("#create-insurance-type-id-bg, #edit-insurance-type-id-bg",'{{ route('select2.insuranceType') }}',0,$('#modal-create-bg'))
            select2Init("#create-bank-id-bg",'{{ route('select2.bank') }}',0,$('#modal-create-bg'))

            select2Init("#edit-bank-id-bg",'{{ route('select2.bank') }}',0,$('#modal-edit-bg'))
            select2Init("#edit-agent-id-bg",'{{ route('select2.agent') }}',0,$('#modal-edit-bg'))
            select2Init("#edit-insurance-id-bg",'{{ route('select2.insurance') }}',0,$('#modal-edit-bg'))
            select2Init("#edit-insurance-type-id-bg",'{{ route('select2.insuranceType') }}',0,$('#modal-edit-bg'))
        })
        $(document).on('click', '#create-save-sb', function () {
            loading()
            ajaxPost("{{ route('master.agent-rates.store') }}",fetchFormData(new FormData(document.getElementById('form-create-sb'))),'#modal-create-sb',function(){
                tableSB.ajax.reload()
                clearForm('#form-create-sb')
            })
        })
        $(document).on('click', '#edit-save-sb', function () {
            loading()
            ajaxPost("{{ route('master.agent-rates.update','-id-') }}".replace('-id-',agentRateSB.id),fetchFormData(new FormData(document.getElementById('form-edit-sb'))),'#modal-edit-sb',function(){
                tableSB.ajax.reload()
            })
        })
        $(document).on('click', '.btn-show-sb', function () {
            ajaxGet("{{ route('master.agent-rates.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    agentRateSB = response.data
                    $('#show-agent-sb').html(agentRateSB.agent.name)
                    $('#show-insurance-type-sb').html(agentRateSB.insurance_type.name)
                    $('#show-insurance-sb').html(agentRateSB.insurance.name)
                    $('#show-min-value-sb').html((ToRupiah.format(agentRateSB.min_value)).replace('\u00A0', '') + ",-")
                    $('#show-rate-value-sb').html(ToUnit.format(agentRateSB.rate_value))
                    $('#show-polish-cost-sb').html((ToRupiah.format(agentRateSB.polish_cost)).replace('\u00A0', '') + ",-")
                    $('#show-stamp-cost-sb').html((ToRupiah.format(agentRateSB.stamp_cost)).replace('\u00A0', '') + ",-")
                    $('#show-desc-sb').html(agentRateSB.desc)
                }
            })
        })
        $(document).on('click', '.btn-edit-sb', function () {
            select2SetVal('edit-agent-id-sb',agentRateSB.agent.id,agentRateSB.agent.name)
            select2SetVal('edit-insurance-id-sb',agentRateSB.insurance.id,agentRateSB.insurance.name)
            select2SetVal('edit-insurance-type-id-sb',agentRateSB.insurance_type.id,agentRateSB.insurance_type.name)
            $('#edit-min-value-sb').val((ToRupiah.format(agentRateSB.min_value)).replace('Rp\u00A0', ''))
            $('#edit-rate-value-sb').val(ToUnit.format(agentRateSB.rate_value))
            $('#edit-polish-cost-sb').val((ToRupiah.format(agentRateSB.polish_cost)).replace('Rp\u00A0', ''))
            $('#edit-stamp-cost-sb').val((ToRupiah.format(agentRateSB.stamp_cost)).replace('Rp\u00A0', ''))
            $('#edit-desc-sb').val(agentRateSB.desc)
        })
        $(document).on('click', '.btn-delete-sb', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Rate Agen?",
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxPost("{{ route('master.agent-rates.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method: 'delete'},null,function(){
                        tableSB.ajax.reload()
                    })
                }
            })
        })

        $(document).on('click', '#create-save-bg', function () {
            loading()
            ajaxPost("{{ route('master.agent-rates.store') }}",fetchFormData(new FormData(document.getElementById('form-create-bg'))),'#modal-create-bg',function(){
                tableBG.ajax.reload()
                clearForm('#form-create-bg')
            })
        })
        $(document).on('click', '#edit-save-bg', function () {
            loading()
            ajaxPost("{{ route('master.agent-rates.update','-id-') }}".replace('-id-',agentRateBG.id),fetchFormData(new FormData(document.getElementById('form-edit-bg'))),'#modal-edit-bg',function(){
                tableBG.ajax.reload()
            })
        })
        $(document).on('click', '.btn-show-bg', function () {
            ajaxGet("{{ route('master.agent-rates.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    agentRateBG = response.data
                    $('#show-agent-bg').html(agentRateBG.agent.name)
                    $('#show-insurance-type-bg').html(agentRateBG.insurance_type.name)
                    $('#show-insurance-bg').html(agentRateBG.insurance.name)
                    $('#show-bank-bg').html(agentRateBG.bank.name)
                    $('#show-min-value-bg').html((ToRupiah.format(agentRateBG.min_value)).replace('\u00A0', '') + ",-")
                    $('#show-rate-value-bg').html(ToUnit.format(agentRateBG.rate_value))
                    $('#show-polish-cost-bg').html((ToRupiah.format(agentRateBG.polish_cost)).replace('\u00A0', '') + ",-")
                    $('#show-stamp-cost-bg').html((ToRupiah.format(agentRateBG.stamp_cost)).replace('\u00A0', '') + ",-")
                    $('#show-desc-bg').html(agentRateBG.desc)
                }
            })
        })
        $(document).on('click', '.btn-edit-bg', function () {
            select2SetVal('edit-agent-id-bg',agentRateBG.agent.id,agentRateBG.agent.name)
            select2SetVal('edit-insurance-id-bg',agentRateBG.insurance.id,agentRateBG.insurance.name)
            select2SetVal('edit-insurance-type-id-bg',agentRateBG.insurance_type.id,agentRateBG.insurance_type.name)
            select2SetVal('edit-bank-id-bg',agentRateBG.bank.id,agentRateBG.bank.name)
            $('#edit-min-value-bg').val((ToRupiah.format(agentRateBG.min_value)).replace('Rp\u00A0', ''))
            $('#edit-rate-value-bg').val(ToUnit.format(agentRateBG.rate_value))
            $('#edit-polish-cost-bg').val((ToRupiah.format(agentRateBG.polish_cost)).replace('Rp\u00A0', ''))
            $('#edit-stamp-cost-bg').val((ToRupiah.format(agentRateBG.stamp_cost)).replace('Rp\u00A0', ''))
            $('#edit-desc-bg').val(agentRateBG.desc)
        })
        $(document).on('click', '.btn-delete-bg', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Rate Agen?",
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxPost("{{ route('master.agent-rates.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method: 'delete'},null,function(){
                        tableBG.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
