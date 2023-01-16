@extends('layouts.main', ['title' => 'Cetak'])

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Cetak">
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
                    template = template.replaceAll('[[NoKwitansi]]','{{ $bankGaransi->receipt_number }}')
                    template = template.replaceAll('[[NoBond]]','{{ $bankGaransi->bond_number }}')
                    template = template.replaceAll('[[NoPolis]]','{{ $bankGaransi->polish_number }}')
                    template = template.replaceAll('[[NamaAgen]]','{{ $bankGaransi->agent->name }}')
                    template = template.replaceAll('[[NamaAsuransi]]','{{ $bankGaransi->insurance->name }}')
                    template = template.replaceAll('[[JenisJaminan]]','{{ $bankGaransi->insurance_type->name }}')
                    template = template.replaceAll('[[NamaPrincipal]]','{{ $bankGaransi->principal->name }}')
                    template = template.replaceAll('[[AlamatPrincipal]]','{{ $bankGaransi->principal->address }}')
                    template = template.replaceAll('[[NamaPICPrincipal]]','{{ $bankGaransi->principal->pic_name }}')
                    template = template.replaceAll('[[JabatanPICPrincipal]]','{{ $bankGaransi->principal->pic_position }}')
                    template = template.replaceAll('[[NilaiKontrak]]','{{ $bankGaransi->contract_value_converted }}')
                    template = template.replaceAll('[[NilaiJaminan]]','{{ $bankGaransi->insurance_value_converted }}')
                    template = template.replaceAll('[[NilaiKontrakTerbilang]]','{{ $bankGaransi->contract_value_in_text }}')
                    template = template.replaceAll('[[NilaiJaminanTerbilang]]','{{ $bankGaransi->insurance_value_in_text }}')
                    template = template.replaceAll('[[JangkaAwal]]','{{ $bankGaransi->start_date_converted }}')
                    template = template.replaceAll('[[JangkaAkhir]]','{{ $bankGaransi->end_date_converted }}')
                    template = template.replaceAll('[[BatasToleransiJatuhTempo]]','{{ $bankGaransi->due_day_tolerance }}')
                    template = template.replaceAll('[[JumlahHari]]','{{ $bankGaransi->day_count }}')
                    template = template.replaceAll('[[NamaProyek]]','{{ $bankGaransi->project_name }}')
                    template = template.replaceAll('[[DokumenPendukung]]','{{ $bankGaransi->document_title }}')
                    template = template.replaceAll('[[NoDokumenPendukung]]','{{ $bankGaransi->document_number }}')
                    template = template.replaceAll('[[TanggalBerakhirDokumenPendukung]]','{{ $bankGaransi->document_expired_at_converted }}')
                    template = template.replaceAll('[[NamaObligee]]','{{ $bankGaransi->obligee->name }}')
                    template = template.replaceAll('[[AlamatObligee]]','{{ $bankGaransi->obligee->address }}')
                    template = template.replaceAll('[[ServiceCharge]]','{{ $bankGaransi->service_charge_converted }}')
                    template = template.replaceAll('[[BiayaAdmin]]','{{ $bankGaransi->admin_charge_converted }}')
                    template = template.replaceAll('[[PremiBayar]]','{{ $bankGaransi->total_charge_converted }}')
                    template = template.replaceAll('[[ServiceChargeTerbilang]]','{{ $bankGaransi->service_charge_in_text }}')
                    template = template.replaceAll('[[BiayaAdminTerbilang]]','{{ $bankGaransi->admin_charge_in_text }}')
                    template = template.replaceAll('[[PremiBayarTerbilang]]','{{ $bankGaransi->total_charge_in_text }}')
                    template = template.replaceAll('[[TotalNilai]]','{{ $bankGaransi->score }}')
                    template = template.replaceAll('[[StatusProses]]','{{ $bankGaransi->process_status->status->name }}')
                    template = template.replaceAll('[[StatusJaminan]]','{{ $bankGaransi->insurance_status->status->name }}')
                    template = template.replaceAll('[[StatusPembayaran]]','{{ $bankGaransi->finance_status->status->name }}')
                    template = template.replaceAll('[[TanggalHariIni]]','{{ $bankGaransi->today }}')
                @else
                    template = template.replaceAll('[[NoKwitansi]]','{{ $suretyBond->receipt_number }}')
                    template = template.replaceAll('[[NoBond]]','{{ $suretyBond->bond_number }}')
                    template = template.replaceAll('[[NoPolis]]','{{ $suretyBond->polish_number }}')
                    template = template.replaceAll('[[NamaAgen]]','{{ $suretyBond->agent->name }}')
                    template = template.replaceAll('[[NamaAsuransi]]','{{ $suretyBond->insurance->name }}')
                    template = template.replaceAll('[[JenisJaminan]]','{{ $suretyBond->insurance_type->name }}')
                    template = template.replaceAll('[[NamaPrincipal]]','{{ $suretyBond->principal->name }}')
                    template = template.replaceAll('[[AlamatPrincipal]]','{{ $suretyBond->principal->address }}')
                    template = template.replaceAll('[[NamaPICPrincipal]]','{{ $suretyBond->principal->pic_name }}')
                    template = template.replaceAll('[[JabatanPICPrincipal]]','{{ $suretyBond->principal->pic_position }}')
                    template = template.replaceAll('[[NilaiKontrak]]','{{ $suretyBond->contract_value_converted }}')
                    template = template.replaceAll('[[NilaiJaminan]]','{{ $suretyBond->insurance_value_converted }}')
                    template = template.replaceAll('[[NilaiKontrakTerbilang]]','{{ $suretyBond->contract_value_in_text }}')
                    template = template.replaceAll('[[NilaiJaminanTerbilang]]','{{ $suretyBond->insurance_value_in_text }}')
                    template = template.replaceAll('[[JangkaAwal]]','{{ $suretyBond->start_date_converted }}')
                    template = template.replaceAll('[[JangkaAkhir]]','{{ $suretyBond->end_date_converted }}')
                    template = template.replaceAll('[[BatasToleransiJatuhTempo]]','{{ $suretyBond->due_day_tolerance }}')
                    template = template.replaceAll('[[JumlahHari]]','{{ $suretyBond->day_count }}')
                    template = template.replaceAll('[[NamaProyek]]','{{ $suretyBond->project_name }}')
                    template = template.replaceAll('[[DokumenPendukung]]','{{ $suretyBond->document_title }}')
                    template = template.replaceAll('[[NoDokumenPendukung]]','{{ $suretyBond->document_number }}')
                    template = template.replaceAll('[[TanggalBerakhirDokumenPendukung]]','{{ $suretyBond->document_expired_at_converted }}')
                    template = template.replaceAll('[[NamaObligee]]','{{ $suretyBond->obligee->name }}')
                    template = template.replaceAll('[[AlamatObligee]]','{{ $suretyBond->obligee->address }}')
                    template = template.replaceAll('[[ServiceCharge]]','{{ $suretyBond->service_charge_converted }}')
                    template = template.replaceAll('[[BiayaAdmin]]','{{ $suretyBond->admin_charge_converted }}')
                    template = template.replaceAll('[[PremiBayar]]','{{ $suretyBond->total_charge_converted }}')
                    template = template.replaceAll('[[ServiceChargeTerbilang]]','{{ $suretyBond->service_charge_in_text }}')
                    template = template.replaceAll('[[BiayaAdminTerbilang]]','{{ $suretyBond->admin_charge_in_text }}')
                    template = template.replaceAll('[[PremiBayarTerbilang]]','{{ $suretyBond->total_charge_in_text }}')
                    template = template.replaceAll('[[TotalNilai]]','{{ $suretyBond->score }}')
                    template = template.replaceAll('[[StatusProses]]','{{ $suretyBond->process_status->status->name }}')
                    template = template.replaceAll('[[StatusJaminan]]','{{ $suretyBond->insurance_status->status->name }}')
                    template = template.replaceAll('[[StatusPembayaran]]','{{ $suretyBond->finance_status->status->name }}')
                    template = template.replaceAll('[[TanggalHariIni]]','{{ $suretyBond->today }}')
                @endif
                tinymce.activeEditor.setContent(template);
            })
        })
    </script>
@endpush
