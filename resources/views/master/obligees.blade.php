@extends('layouts.main', ['title' => 'Obligee'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Obligee">
        @slot('headerAction')
            <x-button face="warning" size="sm" id="btn-sync-with-jamsyar" icon="bx bx-refresh">Sync ke Jamsyar</x-button>
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Obligee</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Status Sinkronisasi</th>
                    <th width="125px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Obligee">
        <x-form id="form-create" method="post">
            <x-form-input label="Nama" id="create-name" name="name" class="mb-3" required/>
            <x-form-select label="Provinsi" id="create-province-id" name="province_id" class="mb-3"/>
            <x-form-select label="Kota" id="create-city-id" name="city_id" class="mb-3"/>
            <x-form-select label="Jenis" id="create-type" name="type" class="mb-3" :options="$types"/>
            <x-form-input label="JamsyarID" id="create-jamsyar-id" name="jamsyar_id" class="mb-3"/>
            <x-form-input label="JamsyarCode" id="create-jamsyar-code" name="jamsyar_code" class="mb-3"/>
            <x-form-textarea label="Alamat" id="create-address" name="address" required/>
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Obligee">
        <div class="mb-5 text-center">
            <div id="show-name" class="h4 mb-2 fw-bold">Nama Obligee Di Sini</div>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Provinsi</b>: <br>
            <span id="show-province">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Kota</b>: <br>
            <span id="show-city">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat</b>: <br>
            <span id="show-address">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Jenis</b>: <br>
            <span id="show-type">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Status Sinkronisasi</b>: <br>
            <span id="show-status"><x-badge face="label-success">Sinkron</x-badge></span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>ID Jamsyar</b>: <br>
            <span id="show-jamsyar-id">-</span>
        </div>
        <div>
            <b>Kode Jamsyar</b>: <br>
            <span id="show-jamsyar-code">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Obligee">
        <x-form id="form-edit" method="put">
            <x-form-input label="Nama" id="edit-name" name="name" class="mb-3" required/>
            <x-form-select label="Provinsi" id="edit-province-id" name="province_id" class="mb-3"/>
            <x-form-select label="Kota" id="edit-city-id" name="city_id" class="mb-3"/>
            <x-form-select label="Jenis" id="edit-type" name="type" class="mb-3" :options="$types"/>
            <x-form-input label="JamsyarID" id="edit-jamsyar-id" name="jamsyar_id" class="mb-3"/>
            <x-form-input label="JamsyarCode" id="edit-jamsyar-code" name="jamsyar_code" class="mb-3"/>
            <x-form-textarea label="Alamat" id="edit-address" name="address" required/>
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
        let obligee = null
        $(document).ready(function () {
            table = dataTableInit('table','Obligee',{url : '{{ route($global->currently_on.'.master.obligees.index', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}'},[
                {data: 'name', name: 'name'},
                {data: 'address', name: 'address'},
                {data: 'status', name: 'status'},
            ])

            select2Init("#create-province-id, #edit-province-id",'{{ route('select2.province') }}',0,$('#modal-create'))
            select2Init("#create-city-id",'{{ route('select2.city') }}',0,$('#modal-create'),'--  Pilih --',false,function(params){
                return {
                    search: params.term ?? '',
                    province_id: $('#create-province-id').val()
                }
            })
            select2Init("#edit-province-id",'{{ route('select2.province') }}',0,$('#modal-edit'))
            select2Init("#edit-city-id",'{{ route('select2.city') }}',0,$('#modal-edit'),'--  Pilih --',false,function(params){
                return {
                    search: params.term ?? '',
                    province_id: $('#edit-province-id').val()
                }
            })

            @if (request()->has('mode') && request()->mode == 'tambah')
                $("#modal-create").modal('show')
            @endif
        })

        $(document).on('click', '#create-save', function () {
            loading()
            ajaxPost("{{ route('master.obligees.store') }}",new FormData(document.getElementById('form-create')),'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
                @if (request()->has('mode') && request()->mode == 'tambah')
                    setTimeout(() => {
                        window.close()
                    }, 1000);
                @endif
            })
        })

        $(document).on('click', '#edit-save', function () {
            loading()
            ajaxPost("{{ route('master.obligees.update','-id-') }}".replace('-id-',obligee.id),new FormData(document.getElementById('form-edit')),'#modal-edit',function(){
                table.ajax.reload()
            })
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.obligees.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    obligee = response.data
                    $('#show-name').html(obligee.name)
                    $('#show-address').html(obligee.address)
                    $('#show-type').html(obligee.type_name)
                    $('#show-province').html(obligee.city ? obligee.city.province.name : null)
                    $('#show-city').html(obligee.city ? obligee.city.name : null)
                    $('#show-jamsyar-id').html(obligee.jamsyar_id)
                    $('#show-jamsyar-code').html(obligee.jamsyar_code)
                }
            })
        })

        $(document).on('click', '.btn-edit', function () {
            $('#edit-name').val(obligee.name)
            $('#edit-address').val(obligee.address)
            $('#edit-type').val(obligee.type)
            if(obligee.city){
                select2SetVal('edit-province-id',obligee.city.province.id,obligee.city.province.name)
                select2SetVal('edit-city-id',obligee.city.id,obligee.city.name)
            }
            $('#edit-jamsyar-id').val(obligee.address)
            $('#edit-jamsyar-code').val(obligee.address)
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus obligee " + $(this).data('name') + "?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('master.obligees.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method: 'delete'},'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
        $(document).on('click', '.btn-sync', function () {
            loading()
            ajaxPost("{{ route('master.obligees.sync','-obligee-') }}".replace('-obligee-',$(this).data('id')),{_method: 'put'},null,function(response){
                if(response.success){
                    table.ajax.reload()
                }
            })
        })
        $(document).on('click', '#btn-sync-with-jamsyar', function () {
            loading()
            ajaxGet("{{ route('master.obligees.jamsyar') }}",null,function(response){
                if(response.success){
                    table.ajax.reload()
                }
            })
        })
    </script>
@endpush
