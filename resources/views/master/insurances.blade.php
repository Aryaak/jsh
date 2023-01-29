@extends('layouts.main', ['title' => 'Asuransi'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Asuransi">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Asuransi</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th>Alias</th>
                    <th>Alamat</th>
                    <th>Nama PIC</th>
                    <th>Jabatan PIC</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Asuransi">
        <x-form id="form-create" method="post">
            <x-form-input id="create-name" name="name" label="Nama" class="mb-3" required />
            <x-form-input id="create-alias" name="alias" label="Alias" class="mb-3" required />
            <x-form-textarea id="create-address" name="address" label="Alamat" class="mb-3" required />
            <x-form-input id="create-pic-name" name="pc_name" label="Nama PIC" class="mb-3" required />
            <x-form-input id="create-pic-position" name="pc_position" label="Jabatan PIC" required />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Asuransi">
        <div class="border-bottom pb-2 mb-2">
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alias</b>: <br>
            <span id="show-alias">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat</b>: <br>
            <span id="show-address">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nama PIC</b>: <br>
            <span id="show-pic-name">-</span>
        </div>
        <div>
            <b>Alamat PIC</b>: <br>
            <span id="show-pic-address">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Asuransi">
        <x-form id="form-edit" method="put">
            <x-form-input id="edit-name" name="name" label="Nama" class="mb-3" required />
            <x-form-input id="edit-alias" name="alias" label="Alias" class="mb-3" required />
            <x-form-textarea id="edit-address" name="address" label="Alamat" class="mb-3" required />
            <x-form-input id="edit-pic-name" name="pc_name" label="Nama PIC" class="mb-3" required />
            <x-form-input id="edit-pic-position" name="pc_position" label="Jabatan PIC" required />
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
        let insurance = {}
        $(document).ready(function () {
            table = dataTableInit('table','Asuransi',{url : '{{ route($global->currently_on.'.master.insurances.index', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}'},[
                {data: 'name', name: 'name'},
                {data: 'alias', name: 'alias'},
                {data: 'address', name: 'address'},
                {data: 'pc_name', name: 'pc_name'},
                {data: 'pc_position', name: 'pc_position'},
            ])
        })

        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            ajaxPost("{{ route('master.insurances.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })

        $(document).on('click', '#edit-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-edit'))
            ajaxPost("{{ route('master.insurances.update','-id-') }}".replace('-id-',insurance.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.insurances.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    insurance = response.data
                    $('#show-name').html(insurance.name)
                    $('#show-alias').html(insurance.alias)
                    $('#show-address').html(insurance.address)
                    $('#show-pic-name').html(insurance.pc_name)
                    $('#show-pic-address').html(insurance.pc_position)
                }
            })
        })

        $(document).on('click', '.btn-edit', function () {
            $('#edit-name').val(insurance.name)
            $('#edit-alias').val(insurance.alias)
            $('#edit-address').val(insurance.address)
            $('#edit-pic-name').val(insurance.pc_name)
            $('#edit-pic-position').val(insurance.pc_position)
        })

        $(document).on('click', '.btn-delete', function () {
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus asuransi " + $(this).data('name') + "?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('master.insurances.destroy','-id-') }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
