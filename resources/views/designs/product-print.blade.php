@extends('layouts.main', ['title' => 'Draf Surety Bond'])

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Cetak Surety Bond">
        <div class="h6">Jaminan: Apa Hayo</div>
        <x-form method="post" submit="Cetak" submitIcon="bx bxs-printer">
            @php
                $options = [
                    1 => 'Kwitansi',
                    2 => "Surat Permohonan",
                ];
            @endphp
            <x-form-select label="Pilih Template" name="template" id="template" :$options class="mb-3" class-input="select2" />
            <x-form-textarea label="Pratinjau" name="preview" id="preview" tinymce />
        </x-form>
    </x-card>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function (){
            $('.select2').select2()
        })
    </script>
@endpush
