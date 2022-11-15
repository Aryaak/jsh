@extends('layouts.main', ['title' => 'Template'])

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
            <x-form-input id="edit-name" name="title" label="Nama" class="mb-3" required />
            <x-form-textarea id="edit-text" name="text" label="Template" tinymce required />
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
    <script src="https://cdn.tiny.cloud/1/{{ config('app.tiny_mce_key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script>
    <script>
        let table = null
        let template = null

        $(document).ready(function () {
            table = dataTableInit('table','Template',{url : '{{ route($global->currently_on.'.master.templates.index', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}'},[
                {data: 'title', name: 'title'},
            ])
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.templates.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    $('#show-template').html('');
                    template = response.data
                    var url = '{{ url("/pdf/download/:id") }}';
                    url = url.replace(':id', template.id);
                    $('#show-template').append(`
                        <x-button class="template-pdf" target="_blank" link=`+url+` face="secondary" icon='bx bxs-cloud-download'>`+ template.title +`</x-button>
                    `)
                }
            })
        })

        $("#edit-save").click(function () {
            loading()
            tinymce.triggerSave();
            let formData = new FormData(document.getElementById('form-edit'))
            ajaxPost("{{ route('master.templates.update','-id-') }}".replace('-id-',template.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })
        })

        $(document).on('click', '.btn-edit', function () {
            let formData = new FormData(document.getElementById('form-edit'))
            $('#edit-name').val(template.title);
            tinymce.get("edit-text").setContent(template.text);
        })
    </script>
@endpush
