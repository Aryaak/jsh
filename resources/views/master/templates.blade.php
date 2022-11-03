@extends('layouts.main', ['title' => 'Master Data'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Template">
        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-show" title="Detail Template">
        <div>
            <b>Unduh Template</b>: <br>
            <span id="show-template"></span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Template" size="fullscreen">
        <x-form id="form-edit" method="put">
            <div class="mb-3">
                <x-form-label>Nama</x-form-label>
                <div id="edit-name">Tes</div>
            </div>
            <x-form-textarea label="Template" id="edit-template" name="template" tinymce />
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
    <script>
        let table = null
        let template = null

        $(document).ready(function () {
            table = dataTableInit('table','Template',{url : '{{ route('master.templates.index') }}'},[
                {data: 'title', name: 'title'},
            ])
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.templates.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    template = response.data
                    var url = '{{ url("/pdf/download/:id") }}';
                    url = url.replace(':id', template.id);
                    $('#show-template').append(`
                        <x-button class="template-pdf" target="_blank" link=`+url+` face="secondary" icon='bx bxs-cloud-download'>`+ template.title +`</x-button>
                    `)
                }
            })
        })
    </script>
@endpush
