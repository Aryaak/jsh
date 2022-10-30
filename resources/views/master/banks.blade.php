@extends('layouts.main', ['title' => 'Bank'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Bank">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Bank</x-button>
        @endslot

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
    <x-modal id="modal-create" title="Tambah Bank" size="fullscreen">
        <x-form id="form-create" method="post">
            <x-form-input label="Nama" id="create-name" name="name" class="mb-3" required />
            <x-button id="create-new-template" icon="bx bx-plus">Tambah Template Syarat Bank</x-button>
            <div id="create-template-container">
                {{-- Tempat Tambah Template --}}
            </div>
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Bank">
        <div class="border-botton pb-2 mb-2">
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>
        <div>
            <b>Unduh Template</b>: <br>
            <span id="show-template"></span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Bank" size="fullscreen">
        <x-form id="form-edit" method="put">
            <x-form-input id="edit-name" name="name" label="Nama" class="mb-3" required />
            <x-button id="edit-new-template" icon="bx bx-plus">Tambah Template Syarat Bank</x-button>
            <div id="edit-template-container">
                {{-- Tempat Tambah Template --}}
            </div>
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
        var createTemplateCounter = 0
        var editTemplateCounter = 0
        let table = null
        let bank = null

        $(document).ready(function () {
            table = dataTableInit('table','Bank',{url : '{{ route('master.banks.index') }}'},[
                {data: 'name', name: 'name'},
            ])
        })

        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                e.stopImmediatePropagation();
            }
        });

        $("#create-new-template").click(function () {
            addNewTemplate('create')
        })

        $("#edit-new-template").click(function () {
            addNewTemplate('edit')
        })

        $("#create-save").click(function () {
            loading()
            tinymce.triggerSave();
            let formData = new FormData(document.getElementById('form-create'))
            ajaxPost("{{ route('master.banks.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })

            createTemplateCounter = 0
            $("#create-template-container").html('')
        })

        $("#edit-save").click(function () {
            loading()
            tinymce.triggerSave();
            let formData = new FormData(document.getElementById('form-edit'))
            ajaxPost("{{ route('master.banks.update','-id-') }}".replace('-id-',bank.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })

            editTemplateCounter = 0
            $("#edit-template-container").html('')
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.banks.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    bank = response.data
                    $('#show-name').html(bank.name)
                    $('#show-template').html('')
                    for (let i = 0; i < bank.templates.length; i++) {
                        var url = '{{ url("/pdf/download/:id") }}';
                        url = url.replace(':id', bank.templates[i].id);
                        $('#show-template').append(`
                            <x-button class="template-pdf" target="_blank" link=`+url+` face="secondary" icon='bx bxs-cloud-download'>`+ bank.templates[i].title +`</x-button>
                        `)
                    }
                }
            })

            editTemplateCounter = 0
            $("#edit-template-container").html('')
        })

        $(document).on('click', '.btn-edit', function () {
            let formData = new FormData(document.getElementById('form-edit'))
            $('#edit-name').val(bank.name)
            for (let i = 1; i <= bank.templates.length; i++) {
                addNewTemplate('edit', bank.templates[i-1].text, bank.templates[i-1].id)
                $('#edit-template-title-'+i).val(bank.templates[i-1].title)
                $('#edit-template-type-'+i).val(bank.templates[i-1].type)
            }
        })

        $(document).on('click', '.btn-delete', function () {
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Bank?",
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('master.banks.destroy','-id-') }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })

        $(document).on('click', '.btn-delete-template', function () {
            NegativeConfirm.fire({
                title: "Ingin menghapus template ini?"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().remove()
                }
            })
        })

        function addNewTemplate(createOrEdit, valueTemplate = '',id = '') {
            var counter = 0;
            var inputId = '';

            if (createOrEdit == 'create') {
                createTemplateCounter++
                counter = createTemplateCounter
            }
            else {
                editTemplateCounter++
                counter = editTemplateCounter
                inputId = `<input type="hidden" id="edit-template-id" value="`+ id +`" name="id[]" />`
            }

            $("#" + createOrEdit + "-template-container").append(`
                <div id="` + createOrEdit + `-template-` + counter + `" class="border rounded p-3 mt-3">
                    ` + inputId + `
                    <x-button class="btn-delete-template w-100 mb-3" face='danger' icon="bx bx-trash" size='sm'>Hapus Template</x-button>
                    <x-form-input label="Judul" id="` + createOrEdit + `-template-title-` + counter + `" name="title[]" class="mb-3" required />
                    <x-form-input label="Jenis" id="` + createOrEdit + `-template-type-` + counter + `" name="type[]" class="mb-3" required />
                    <x-form-textarea label="Template" id="` + createOrEdit + `-template-text-` + counter + `" name="text[]" class="mb-3" required />
                </div>
            `);

            $("#" + createOrEdit + "-template-text-" + counter).tinymce({
                language: 'id',
                plugins: 'image table lists fullscreen code',
                menubar: 'file edit insert view table format table tools help',
                toolbar: 'undo redo | styles | bold italic underline | numlist bullist | image | alignleft aligncenter alignright alignjustify | code fullscreen',
                images_upload_handler: tinyMCEImageUploadHandler("{{ route('uploader.tinymce') }}", "{{ csrf_token() }}"),
                setup: function (editor) {
                    editor.on('init', function (e) {
                        editor.setContent(valueTemplate);
                    });
                }
            });
        }
    </script>
@endpush
