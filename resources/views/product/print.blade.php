@extends('layouts.main', ['title' => 'Draf Surety Bond'])

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Cetak Surety Bond">
        <x-form method="post" target="_blank" submit="Cetak" submitIcon="bx bxs-printer" action="{{ route('pdf.print') }}">
            <x-form-select label="Pilih Template" name="template" id="template" class="mb-3" class-input="select2" />
            <input type="hidden" name="name" id="name" value="">
            <x-form-textarea label="Pratinjau" name="preview" id="preview" tinymce/>
        </x-form>
    </x-card>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/{{ config('app.tiny_mce_key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
    <script>
        tinymce.init({
            selector: '#preview',
            language: 'id',
            plugins: 'image table lists fullscreen code',
            menubar: 'file edit insert view table format table tools help',
            toolbar: 'undo redo | styles | bold italic underline | numlist bullist | image | alignleft aligncenter alignright alignjustify | code fullscreen',
            images_upload_handler: tinyMCEImageUploadHandler("{{ route('uploader.tinymce') }}", "{{ csrf_token() }}"),
        });
        $(document).ready(function (){
            @if ($now == 'bank')
                var id = {{ $id }}
                select2Init("#template",'{{ route('select2.bankTemplate','-id-') }}'.replace('-id-',id),0,'')
            @else
                select2Init("#template",'{{ route('select2.suretyTemplate') }}',0,'')
            @endif
        })

        $(document).on('change', '#template', function () {
            ajaxGet('{{ route('master.templates.show','-id-') }}'.replace('-id-',$(this).val()),null,function(response){
                var template = (response.data.text)
                document.getElementById("name").value = response.data.title;
                @if ($now == 'bank')
                    template = template.replace('[[NoKwitansi]]','{{ $bankGaransi->receipt_number }}')
                    template = template.replace('[[NoBond]]','{{ $bankGaransi->bond_number }}')
                    template = template.replace('[[NoPolis]]','{{ $bankGaransi->polish_number }}')
                    template = template.replace('[[NamaAgen]]','{{ $bankGaransi->agent->name }}')
                    template = template.replace('[[NamaAsuransi]]','{{ $bankGaransi->insurance->name }}')
                    template = template.replace('[[JenisJaminan]]','{{ $bankGaransi->insurance_type->name }}')
                    template = template.replace('[[NamaPrincipal]]','{{ $bankGaransi->principal->name }}')
                    template = template.replace('[[AlamatPrincipal]]','{{ $bankGaransi->principal->address }}')
                    template = template.replace('[[NamaPICPrincipal]]','{{ $bankGaransi->principal->pic_name }}')
                    template = template.replace('[[JabatanPICPrincipal]]','{{ $bankGaransi->principal->pic_position }}')
                    template = template.replace('[[NilaiKontrak]]','{{ $bankGaransi->contract_value }}')
                    template = template.replace('[[NilaiJaminan]]','{{ $bankGaransi->insurance_value }}')
                    template = template.replace('[[JangkaAwal]]','{{ $bankGaransi->start_date }}')
                    template = template.replace('[[JangkaAkhir]]','{{ $bankGaransi->end_date }}')
                    template = template.replace('[[BatasToleransiJatuhTempo]]','{{ $bankGaransi->due_day_tolerance }}')
                    template = template.replace('[[JumlahHari]]','{{ $bankGaransi->day_count }}')
                    template = template.replace('[[NamaProyek]]','{{ $bankGaransi->project_name }}')
                    template = template.replace('[[DokumenPendukung]]','{{ $bankGaransi->document_title }}')
                    template = template.replace('[[NoDokumenPendukung]]','{{ $bankGaransi->document_number }}')
                    template = template.replace('[[TanggalBerakhirDokumenPendukung]]','{{ $bankGaransi->document_expired_at }}')
                    template = template.replace('[[NamaObligee]]','{{ $bankGaransi->obligee->name }}')
                    template = template.replace('[[AlamatObligee]]','{{ $bankGaransi->obligee->address }}')
                    template = template.replace('[[ServiceCharge]]','{{ $bankGaransi->service_charge }}')
                    template = template.replace('[[BiayaAdmin]]','{{ $bankGaransi->admin_charge }}')
                    template = template.replace('[[PremiBayar]]','{{ $bankGaransi->total_charge }}')
                    template = template.replace('[[TotalNilai]]','{{ $bankGaransi->score }}')
                    template = template.replace('[[StatusProses]]','{{ $bankGaransi->process_status->status->name }}')
                    template = template.replace('[[StatusJaminan]]','{{ $bankGaransi->insurance_status->status->name }}')
                    template = template.replace('[[StatusPembayaran]]','{{ $bankGaransi->finance_status->status->name }}')
                @else
                    template = template.replace('[[NoKwitansi]]','{{ $suretyBond->receipt_number }}')
                    template = template.replace('[[NoBond]]','{{ $suretyBond->bond_number }}')
                    template = template.replace('[[NoPolis]]','{{ $suretyBond->polish_number }}')
                    template = template.replace('[[NamaAgen]]','{{ $suretyBond->agent->name }}')
                    template = template.replace('[[NamaAsuransi]]','{{ $suretyBond->insurance->name }}')
                    template = template.replace('[[JenisJaminan]]','{{ $suretyBond->insurance_type->name }}')
                    template = template.replace('[[NamaPrincipal]]','{{ $suretyBond->principal->name }}')
                    template = template.replace('[[AlamatPrincipal]]','{{ $suretyBond->principal->address }}')
                    template = template.replace('[[NamaPICPrincipal]]','{{ $suretyBond->principal->pic_name }}')
                    template = template.replace('[[JabatanPICPrincipal]]','{{ $suretyBond->principal->pic_position }}')
                    template = template.replace('[[NilaiKontrak]]','{{ $suretyBond->contract_value }}')
                    template = template.replace('[[NilaiJaminan]]','{{ $suretyBond->insurance_value }}')
                    template = template.replace('[[JangkaAwal]]','{{ $suretyBond->start_date }}')
                    template = template.replace('[[JangkaAkhir]]','{{ $suretyBond->end_date }}')
                    template = template.replace('[[BatasToleransiJatuhTempo]]','{{ $suretyBond->due_day_tolerance }}')
                    template = template.replace('[[JumlahHari]]','{{ $suretyBond->day_count }}')
                    template = template.replace('[[NamaProyek]]','{{ $suretyBond->project_name }}')
                    template = template.replace('[[DokumenPendukung]]','{{ $suretyBond->document_title }}')
                    template = template.replace('[[NoDokumenPendukung]]','{{ $suretyBond->document_number }}')
                    template = template.replace('[[TanggalBerakhirDokumenPendukung]]','{{ $suretyBond->document_expired_at }}')
                    template = template.replace('[[NamaObligee]]','{{ $suretyBond->obligee->name }}')
                    template = template.replace('[[AlamatObligee]]','{{ $suretyBond->obligee->address }}')
                    template = template.replace('[[ServiceCharge]]','{{ $suretyBond->service_charge }}')
                    template = template.replace('[[BiayaAdmin]]','{{ $suretyBond->admin_charge }}')
                    template = template.replace('[[PremiBayar]]','{{ $suretyBond->total_charge }}')
                    template = template.replace('[[TotalNilai]]','{{ $suretyBond->score }}')
                    template = template.replace('[[StatusProses]]','{{ $suretyBond->process_status->status->name }}')
                    template = template.replace('[[StatusJaminan]]','{{ $suretyBond->insurance_status->status->name }}')
                    template = template.replace('[[StatusPembayaran]]','{{ $suretyBond->finance_status->status->name }}')
                @endif
                tinymce.activeEditor.setContent(template);
            })
        })
    </script>
@endpush
