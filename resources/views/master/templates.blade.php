@extends('layouts.main', ['title' => 'Template'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Template">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" id="tambah-template" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Template</x-button>
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
    <x-modal id="modal-show" title="Detail Template">
        <div>
            <b>Unduh Template</b>: <br>
            <span id="show-template"></span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-create" title="Tambah Template" size="fullscreen">
        <x-form id="form-create" method="post">
            <div id="create-template-container">
                {{-- Tempat Tambah Template --}}
            </div>
            <div class="alert alert-primary">
                <b class="d-flex align-items-center mb-3"><i class="bx bxs-info-circle me-2"></i>Petunjuk Penggunaan</b>
                <p>Berikut beberapa parameter <i>placeholder</i> yang dapat Anda gunakan di template Anda:</p>
                <x-template-placeholder>[[NoKwitansi]]</x-template-placeholder>
                <x-template-placeholder>[[NoBond]]</x-template-placeholder>
                <x-template-placeholder>[[NoPolis]]</x-template-placeholder>
                <x-template-placeholder>[[NamaAgen]]</x-template-placeholder>
                <x-template-placeholder>[[NamaAsuransi]]</x-template-placeholder>
                <x-template-placeholder>[[JenisJaminan]]</x-template-placeholder>
                <x-template-placeholder>[[NamaPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[AlamatPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[NamaPICPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[JabatanPICPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[NilaiKontrak]]</x-template-placeholder>
                <x-template-placeholder>[[NilaiJaminan]]</x-template-placeholder>
                <x-template-placeholder>[[JangkaAwal]]</x-template-placeholder>
                <x-template-placeholder>[[JangkaAkhir]]</x-template-placeholder>
                <x-template-placeholder>[[BatasToleransiJatuhTempo]]</x-template-placeholder>
                <x-template-placeholder>[[JumlahHari]]</x-template-placeholder>
                <x-template-placeholder>[[NamaProyek]]</x-template-placeholder>
                <x-template-placeholder>[[DokumenPendukung]]</x-template-placeholder>
                <x-template-placeholder>[[NoDokumenPendukung]]</x-template-placeholder>
                <x-template-placeholder>[[TanggalBerakhirDokumenPendukung]]</x-template-placeholder>
                <x-template-placeholder>[[NamaObligee]]</x-template-placeholder>
                <x-template-placeholder>[[AlamatObligee]]</x-template-placeholder>
                <x-template-placeholder>[[ServiceCharge]]</x-template-placeholder>
                <x-template-placeholder>[[BiayaAdmin]]</x-template-placeholder>
                <x-template-placeholder>[[PremiBayar]]</x-template-placeholder>
                <x-template-placeholder>[[TotalNilai]]</x-template-placeholder>
                <x-template-placeholder>[[StatusProses]]</x-template-placeholder>
                <x-template-placeholder>[[StatusJaminan]]</x-template-placeholder>
                <x-template-placeholder>[[StatusPembayaran]]</x-template-placeholder>
            </div>
        </x-form>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
            </div>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Template" size="fullscreen">
        <x-form id="form-edit" method="put">
            <div id="edit-template-container">
                {{-- Tempat Tambah Template --}}
            </div>
            <div class="alert alert-primary">
                <b class="d-flex align-items-center mb-3"><i class="bx bxs-info-circle me-2"></i>Petunjuk Penggunaan</b>
                <p>Berikut beberapa parameter <i>placeholder</i> yang dapat Anda gunakan di template Anda:</p>
                <x-template-placeholder>[[NoKwitansi]]</x-template-placeholder>
                <x-template-placeholder>[[NoBond]]</x-template-placeholder>
                <x-template-placeholder>[[NoPolis]]</x-template-placeholder>
                <x-template-placeholder>[[NamaAgen]]</x-template-placeholder>
                <x-template-placeholder>[[NamaAsuransi]]</x-template-placeholder>
                <x-template-placeholder>[[JenisJaminan]]</x-template-placeholder>
                <x-template-placeholder>[[NamaPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[AlamatPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[NamaPICPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[JabatanPICPrincipal]]</x-template-placeholder>
                <x-template-placeholder>[[NilaiKontrak]]</x-template-placeholder>
                <x-template-placeholder>[[NilaiKontrakTerbilang]]</x-template-placeholder>
                <x-template-placeholder>[[NilaiJaminan]]</x-template-placeholder>
                <x-template-placeholder>[[NilaiJaminanTerbilang]]</x-template-placeholder>
                <x-template-placeholder>[[JangkaAwal]]</x-template-placeholder>
                <x-template-placeholder>[[JangkaAkhir]]</x-template-placeholder>
                <x-template-placeholder>[[BatasToleransiJatuhTempo]]</x-template-placeholder>
                <x-template-placeholder>[[JumlahHari]]</x-template-placeholder>
                <x-template-placeholder>[[NamaProyek]]</x-template-placeholder>
                <x-template-placeholder>[[DokumenPendukung]]</x-template-placeholder>
                <x-template-placeholder>[[NoDokumenPendukung]]</x-template-placeholder>
                <x-template-placeholder>[[TanggalBerakhirDokumenPendukung]]</x-template-placeholder>
                <x-template-placeholder>[[NamaObligee]]</x-template-placeholder>
                <x-template-placeholder>[[AlamatObligee]]</x-template-placeholder>
                <x-template-placeholder>[[ServiceCharge]]</x-template-placeholder>
                <x-template-placeholder>[[BiayaAdminTerbilang]]</x-template-placeholder>
                <x-template-placeholder>[[BiayaAdmin]]</x-template-placeholder>
                <x-template-placeholder>[[BiayaAdminTerbilang]]</x-template-placeholder>
                <x-template-placeholder>[[PremiBayar]]</x-template-placeholder>
                <x-template-placeholder>[[PremiBayarTerbilang]]</x-template-placeholder>
                <x-template-placeholder>[[TotalNilai]]</x-template-placeholder>
                <x-template-placeholder>[[StatusProses]]</x-template-placeholder>
                <x-template-placeholder>[[StatusJaminan]]</x-template-placeholder>
                <x-template-placeholder>[[StatusPembayaran]]</x-template-placeholder>
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
        let table = null
        let template = null

        $(document).ready(function () {
            table = dataTableInit('table','Template',{url : '{{ route($global->currently_on.'.master.templates.index', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}'},[
                {data: 'title', name: 'title'},
            ])
        })

        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                e.stopImmediatePropagation();
            }
        });

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

        $(document).on('click', '#tambah-template', function () {
            $('#create-template-container').html('');
            $('#edit-template-container').html('');
            addNewTemplate('create')
        })

        $(document).on('click', '#create-save', function () {
            loading()
            tinymce.triggerSave();
            let formData = new FormData(document.getElementById('form-create'))
            ajaxPost("{{ route('master.templates.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
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
            $('#create-template-container').html('');
            $('#edit-template-container').html('');
            addNewTemplate('edit',template.text)
            $('#title').val(template.title);
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus template " + $(this).data('name') + "?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('master.templates.destroy','-id-') }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })

        function addNewTemplate(createOrEdit, valueTemplate = '',id = '') {
            var counter = 0;
            var inputId = '';

            $("#" + createOrEdit + "-template-container").append(`
                <div id="` + createOrEdit + `-template-` + counter + `" class="border rounded p-3 mt-3">
                    ` + inputId + `
                    <x-form-input label="Judul" id="title" name="title" class="mb-3" required />
                    <x-form-textarea label="Template" id="text" name="text" class="mb-3" required />
                </div>
            `);

            $("#text").tinymce({
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
