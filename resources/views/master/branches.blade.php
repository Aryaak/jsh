@extends('layouts.main', ['title' => 'Cabang'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Cabang">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Cabang</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th>No.</th>
                    <th>Regional</th>
                    <th>Nama</th>
                    <th>Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Cabang">
        <x-form id="form-create" method="post">
            <x-form-select label="Regional" id="create-regional-id" name="regionalId" class="mb-3" required/>
            <x-form-input id="create-name" name="name" label="Nama" />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Cabang">
        <div class="border-bottom pb-2 mb-2">
            <b>Regional</b>: <br>
            <span id="show-regional">-</span>
        </div>
        <div>
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Cabang">
        <x-form id="form-edit" method="put">
            <x-form-select label="Regional" id="edit-regional-id" name="regionalId" class="mb-3" required/>
            <x-form-input id="edit-name" name="name" label="Nama" required />
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
        let table = null
        let branch = null
        $(document).ready(function () {
            table = dataTableInit('table','Cabang',{url : '{{ route('branches.index') }}'},[
                {data: 'regional.name', name: 'regional.name'},
                {data: 'name', name: 'name'},
            ])
            select2Init("#create-regional-id",'{{ route('select2.regional') }}',0,$('#modal-create'))
            select2Init("#edit-regional-id",'{{ route('select2.regional') }}',0,$('#modal-edit'))
        })
        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            formData.append('is_regional',0)
            ajaxPost("{{ route('branches.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
            })
        })
        $(document).on('click', '#edit-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-edit'))
            formData.append('is_regional',0)
            ajaxPost("{{ route('branches.update','-id-') }}".replace('-id-',branch.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('branches.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    branch = response.data
                    $('#show-regional').html(branch.regional.name)
                    $('#show-name').html(branch.name)
                }
            })
        })
        $(document).on('click', '.btn-edit', function () {
            $('#edit-name').val(branch.name)
            $('#edit-regional-id').append(new Option(branch.regional.name,branch.regional.id,true,true)).trigger('change');
        })
        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Cabang?",
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('branches.destroy','-id-') }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush