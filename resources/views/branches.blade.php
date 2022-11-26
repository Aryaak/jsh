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
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th>Jamsyar Username</th>
                    <th width="120px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Cabang">
        <x-form id="form-create" method="post">
            <input type="hidden" name="regionalId" value="{{ $global->regional->id }}">
            <x-form-input id="create-name" name="name" label="Nama" class="mb-3" required/>
            <x-form-input id="create-jamsyar-username" name="jamsyar_username" label="Jamsyar Username" class="mb-3" required />
            <x-form-input id="create-jamsyar-password" name="jamsyar_password" label="Jamsyar Password" type="password" required />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Cabang">
        <div class="border-bottom pb-2 mb-2">
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>
        <div class="border-bottom mb-2 pb-2">
            <b>Jamsyar Username</b>: <br>
            <span id="show-jamsyar-username">-</span>
        </div>
        <div>
            <b>Jamsyar Password</b>: <br>
            <span id="show-jamsyar-password">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Cabang">
        <x-form id="form-edit" method="put">
            <input type="hidden" name="regionalId" value="{{ $global->regional->id }}">
            <x-form-input id="edit-name" name="name" label="Nama" class="mb-3" required />
            <x-form-input id="edit-jamsyar-username" name="jamsyar_username" label="Jamsyar Username" class="mb-3" required />
            <x-form-input id="edit-jamsyar-password" name="jamsyar_password" label="Jamsyar Password" type="password" required />
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
            table = dataTableInit('table','Cabang',{url : '{{ route('regional.branches.index', ['regional' => $global->regional->slug]) }}'},[
                {data: 'name', name: 'name'},
                {data: 'jamsyar_username', name: 'jamsyar_username'},
            ])
            select2Init("#create-regional-id",'{{ route('select2.regional') }}',0,$('#modal-create'))
            select2Init("#edit-regional-id",'{{ route('select2.regional') }}',0,$('#modal-edit'))
        })
        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            formData.append('is_regional',0)
            ajaxPost("{{ route('regional.branches.store', ['regional' => $global->regional->slug]) }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })
        $(document).on('click', '#edit-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-edit'))
            formData.append('is_regional',0)
            ajaxPost("{{ route('regional.branches.update', ['regional' => $global->regional->slug, 'cabang' => '-id-']) }}".replace('-id-',branch.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('regional.branches.show', ['regional' => $global->regional->slug, 'cabang' => '-id-']) }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    branch = response.data
                    $('#show-regional').html(branch.regional.name)
                    $('#show-name').html(branch.name)
                    $('#show-jamsyar-username').html(branch.jamsyar_username)
                    $('#show-jamsyar-password').html(branch.jamsyar_password_masked)
                }
            })
        })
        $(document).on('click', '.btn-edit', function () {
            $('#edit-name').val(branch.name)
            $('#edit-regional-id').append(new Option(branch.regional.name,branch.regional.id,true,true)).trigger('change');
            $('#edit-jamsyar-username').val(branch.jamsyar_username)
            $('#edit-jamsyar-password').val(branch.jamsyar_password)
        })
        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Cabang?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('regional.expenses.destroy', ['regional' => $global->regional->slug, 'cabang' => '-id-']) }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
