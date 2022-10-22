@extends('layouts.main', ['title' => 'Jenis Jaminan'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Jenis Jaminan">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Jenis Jaminan</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th width="180px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Jenis Jaminan">
        <x-form id="form-create" method="post">
            <x-form-input id="create-code" name="code" label="Kode" class="mb-3" required />
            <x-form-input id="create-name" name="name" label="Nama" class="mb-3" required />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Jenis Jaminan">
        <div class="border-bottom pb-2 mb-2">
            <b>Kode</b>: <br>
            <span id="show-code">-</span>
        </div>
        <div>
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Jenis Jaminan">
        <x-form id="form-edit" method="put">
            <x-form-input id="create-code" name="code" label="Kode" class="mb-3" required />
            <x-form-input id="create-name" name="name" label="Nama" class="mb-3" required />
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
        let insuranceType = {}
        $(document).ready(function () {
            table = dataTableInit('table','Insurance',{url : '{{ route('insurance-types.index') }}'},[
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
            ])
        })

        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            ajaxPost("{{ route('insurance-types.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
            })
        })

        $(document).on('click', '#edit-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-edit'))
            ajaxPost("{{ route('insurance-types.update','-id-') }}".replace('-id-',insuranceType.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('insurance-types.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    insuranceType = response.data
                    $('#show-name').html(insuranceType.name)
                    $('#show-code').html(insuranceType.code)
                }
            })
        })

        $(document).on('click', '.btn-show', function () {
            $('#edit-name').val(insuranceType.name)
            $('#edit-code').val(insuranceType.alias)
        })

        $(document).on('click', '.btn-delete', function () {
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Tipe Asuransi?",
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('insurance-types.destroy','-id-') }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
