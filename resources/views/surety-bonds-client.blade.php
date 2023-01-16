@extends('layouts.client', ['title' => 'Request Surety Bond'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Request Surety Bond">
        <div class="border rounded p-2" style="background-color: #EEE">
            <x-form id="form-create" method="post">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Surety Bond</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Data" smallHeader>
                                <x-form-select label="Cabang" id="create-branch-id" name="branchId" class="mb-3" required/>
                                <x-form-input label="No. Bond" id="create-bond-number" name="bondNumber" class="mb-3" />
                                <x-form-input label="No. Polis" id="create-polish-number" name="polishNumber" class="mb-3" />
                                <x-form-select label="Nama Agen" id="create-agent-id" name="agentId" class="mb-3" required/>
                                <x-form-select label="Nama Asuransi" id="create-insurance-id" name="insuranceId" class="mb-3" required/>
                                <x-form-select label="Jenis Jaminan" id="create-insurance-type-id" name="insuranceTypeId" required/>
                            </x-card>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Principal" smallHeader>
                                <x-form-select label="Nama" id="create-principal-id" name="principalId" class="mb-3" required/>
                                <div class="mb-3">
                                    <x-form-label>Alamat</x-form-label>
                                    <div id="create-principal-address">-</div>
                                </div>
                                <div class="mb-3">
                                    <x-form-label>Nama PIC</x-form-label>
                                    <div id="create-pic-name">-</div>
                                </div>
                                <div>
                                    <x-form-label>Jabatan PIC</x-form-label>
                                    <div id="create-pic-position">-</div>
                                </div>
                            </x-card>
                        </div>
                        <div class="w-100 mb-4">
                            <x-card header="Obligee" smallHeader>
                                <x-form-select label="Nama" id="create-obligee-id" name="obligeeId" class="mb-3" required/>
                                <div>
                                    <x-form-label>Alamat</x-form-label>
                                    <div id="create-obligee-address">-</div>
                                </div>
                            </x-card>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Jaminan" smallHeader>
                                <x-form-input label="Nilai Kontrak" id="create-contract-value" name="contractValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                                <x-form-input label="Nilai Jaminan" id="create-insurance-value" name="insuranceValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <x-form-input label="Jangka Awal" id="create-start-date" name="startDate" type="date" class="mb-3" />
                                    </div>
                                    <div class="col-sm-6">
                                        <x-form-input label="Jangka Akhir" id="create-end-date" name="endDate" type="date" class="mb-3" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-form-label>Batas Toleransi Jatuh Tempo</x-form-label>
                                    <div class="d-flex flex-xl-row flex-column gap-2">
                                        <x-form-check id="create-due-day-tolerance-0" input-class='create-due-day-tolerance' name='dueDayTolerance' value="0" type="radio" inline checked>0 Hari</x-form-check>
                                        <x-form-check id="create-due-day-tolerance-1" input-class='create-due-day-tolerance' name='dueDayTolerance' value="1" type="radio" inline>1 Hari</x-form-check>
                                        <x-form-check id="create-due-day-tolerance-2" input-class='create-due-day-tolerance' name='dueDayTolerance' value="2" type="radio" inline>2 Hari</x-form-check>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-form-label required>Jumlah Hari</x-form-label>
                                    <input type="hidden" id="create-day-count-input" name="dayCount" value="0">
                                    <div><span id="create-day-count">0</span> Hari</div>
                                </div>
                                <x-form-input label="Nama Proyek" id="create-project-name" name="projectName" class="mb-3" required />
                                <x-form-input label="Dokumen Pendukung" id="create-document-title" name="documentTitle" class="mb-3" />
                                <x-form-input label="No. Dokumen Pendukung" id="create-document-number" name="documentNumber" class="mb-3" />
                                <x-form-input label="Tanggal Dokumen Pendukung" id="create-document-expired-at" name="documentExpiredAt" type="date" />
                            </x-card>
                        </div>
                    </div>
                </div>
            </x-form>
        </div>
        @slot('footer')
            <div class="text-end">
                <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
            </div>
        @endslot
    </x-card>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            select2Init("#create-branch-id",'{{ route('select2.branchClient') }}',0)
            select2Init("#create-agent-id",'{{ route('select2.agent') }}',0)
            select2Init("#create-obligee-id",'{{ route('select2.obligee') }}',0)
            select2Init("#create-principal-id",'{{ route('select2.principal') }}',0)
            select2Init("#create-insurance-id",'{{ route('select2.insurance') }}',0)
            select2Init("#create-insurance-type-id",'{{ route('select2.insuranceType') }}',0)
        })

        $(document).on('input', '#create-service-charge, #create-admin-charge', function () {
            const creadit = $(this).attr('id').split('-')[0] //create or edit
            const serviceCharge = parseInt($('#'+creadit+'-service-charge').val() ? $('#'+creadit+'-service-charge').val().replaceAll('.','') : 0)
            const adminCharge = parseInt($('#'+creadit+'-admin-charge').val() ? $('#'+creadit+'-admin-charge').val().replaceAll('.','') : 0)
            const totalCharge =  serviceCharge + adminCharge

            if (isNaN(totalCharge)) totalCharge = 0
            $('#'+creadit+'-premi-charge').html(ToRupiah.format(totalCharge).replaceAll('\u00A0', '')+",-")
        })
        $(document).on('click', '#create-save', function () {
            loading()
            ajaxPost("{{ route('client') }}",fetchFormData(new FormData(document.getElementById('form-create'))),function(){
                clearForm('#form-create')
                $('#create-principal-address').html('-')
                $('#create-pic-name').html('-')
                $('#create-pic-position').html('-')
                $('#create-obligee-address').html('-')
                $('#create-premi-charge').html('Rp0,-')
                Swal.fire({
                    icon: "success",
                    title: "Request surety bond berhasil dilakukan!",
                })
            })
        })
        $(document).on('change', '#create-obligee-id', function () {
            if($(this).val() != ''){
                const creadit = $(this).attr('id').split('-')[0] //create or edit
                ajaxGet('{{ route('client.obligee','-id-') }}'.replace('-id-',$(this).val()),null,function(response){
                    $('#'+creadit+'-obligee-address').html(response.data.address)
                })
            }
        })
        $(document).on('change', '#create-principal-id', function () {
            if($(this).val() != ''){
                const creadit = $(this).attr('id').split('-')[0] //create or edit
                ajaxGet('{{ route('client.principal','-id-') }}'.replace('-id-',$(this).val()),null,function(response){
                    const data = response.data
                    $('#'+creadit+'-principal-address').html(data.address)
                    $('#'+creadit+'-pic-name').html(data.pic_name)
                    $('#'+creadit+'-pic-position').html(data.pic_position)
                })
            }
        })
        $(document).on('input', '#create-start-date, #create-end-date, .create-due-day-tolerance', function () {
            const split = $(this).attr('id').split('-')
            let dayCount = (split[1]  == 'due') ? parseInt(calculateDayFromDates('start',split[0])) : calculateDayFromDates(split[1],split[0])
            $('#'+split[0]+'-day-count-input').val(dayCount)
            $('#'+split[0]+'-day-count').html(dayCount)
        })
    </script>
@endpush
