@extends('layouts.main', ['title' => 'Regional'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Regional">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Regional</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Jamsyar Username</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Regional">
        <x-form id="form-create" method="post">
            <x-form-input id="create-name" name="name" label="Nama" class="mb-3" required />
            <x-form-input id="create-jamsyar-username" name="jamsyar_username" label="Jamsyar Username" class="mb-3" required />
            <x-form-input id="create-jamsyar-password" name="jamsyar_password" label="Jamsyar Password" class="mb-3" type="password" required />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Regional">
        <div class="border-bottom mb-2 pb-2">
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

    <x-modal id="modal-edit" title="Ubah Regional">
        <x-form id="form-edit" method="put">
            <x-form-input id="edit-name" name="name" label="Nama" class="mb-3" required />
            <x-form-input id="edit-jamsyar-username" name="jamsyar_username" label="Jamsyar Username" class="mb-3" required />
            <x-form-input id="edit-jamsyar-password" name="jamsyar_password" label="Jamsyar Password" class="mb-3" type="password" required />
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
        let regional = {}
        $(document).ready(function () {
            table = dataTableInit('table','Regional',{url : '{{ route('master.regionals.index') }}'},[
                {data: 'name', name: 'name'},
                {data: 'jamsyar_username', name: 'jamsyar_username'},
            ])
        })
        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            formData.append('is_regional',1)
            ajaxPost("{{ route('master.branches.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })
        $(document).on('click', '#edit-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-edit'))
            formData.append('is_regional',1)
            ajaxPost("{{ route('master.branches.update','-id-') }}".replace('-id-',regional.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.branches.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    regional = response.data
                    $('#show-name').html(regional.name)
                    $('#show-jamsyar-username').html(regional.jamsyar_username)
                    $('#show-jamsyar-password').html(regional.jamsyar_password)
                }
            })
        })
        $(document).on('click', '.btn-edit', function () {
            $('#edit-name').val(regional.name)
            $('#edit-jamsyar-username').val(regional.jamsyar_username)
            $('#edit-jamsyar-password').val(regional.jamsyar_password)
        })

        $(document).on('click', '.btn-delete', function () {
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Regional?",
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('master.branches.destroy','-id-') }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
