@extends('layouts.main', ['title' => 'Pembayaran'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Pembayaran">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Pembayaran</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Waktu Bayar</th>
                    <th>Dari Principal</th>
                    <th>Ke Cabang</th>
                    <th>Nominal Bayar</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Pembayaran">
        <x-form id="form-create" method="post">
            <x-form-input label="Waktu Bayar" id="create-paid_at" name="paid_at" type="datetime-local" class="mb-3" required />
            <x-form-input label="Bulan" id="create-month" class-input="calculate-params" name="month" type="number" class="mb-3" required />
            <x-form-input label="Tahun" id="create-year" class-input="calculate-params" name="year" type="number" class="mb-3" required />
            <x-form-select label="Dari Principal" id="create-principal-id" class-input="calculate-params" name="principalId" class="mb-3" required />
            <x-form-select label="Ke Cabang" id="create-branch-id" class-input="calculate-params" name="branchId" class="mb-3" required />
            <x-form-input label="Nominal Bayar" id="create-nominal" name="nominal" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="create-desc" name="desc" />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Pembayaran">
        <div class="border-bottom pb-2 mb-2">
            <b>Waktu Bayar</b>: <br>
            <span id="show-paid_at">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Dari Principal</b>: <br>
            <span id="show-principal">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Ke Cabang</b>: <br>
            <span id="show-branch">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nominal Bayar</b>: <br>
            <span id="show-nominal">Rp0,-</span>
        </div>
        <div>
            <b>Keterangan</b>: <br>
            <span id="show-desc">-</span>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Pembayaran">
        <x-form id="form-edit" method="put">
            <x-form-input label="Waktu Bayar" id="edit-datetime" class-input="calculate-params" name="datetime" type="datetime-local" class="mb-3" required />
            <x-form-select label="Dari Principal" id="edit-principal-id" class-input="calculate-params" name="principalId" :options="[]" class="mb-3" required />
            <x-form-select label="Ke Cabang" id="edit-branch-id" class-input="calculate-params" name="branchId" :options="[]" class="mb-3" required />
            <x-form-input label="Nominal Bayar" id="edit-nominal" class-input="calculate-params" name="nominal" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
            <x-form-textarea label="Keterangan" id="edit-desc" name="desc" />
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
        let payment = null
        $(document).ready(function () {
            table = dataTableInit('table','Pembayaran',{
                    url : '{{ route('payments.tables') }}',
                    data : { type : 'principal_to_branch' }
                },[
                {data: 'paid_at'},
                {data: 'principal.name'},
                {data: 'branch.name'},
                {data: 'total_bill'}
            ])
            select2Init("#create-principal-id",'{{ route('select2.principal') }}',0,$('#modal-create'))
            select2Init("#create-branch-id",'{{ route('select2.branch') }}',0,$('#modal-create'))

            // $("#create-principal-id, #create-branch-id").select2({dropdownParent: $('#modal-create')})
            // $("#edit-principal-id, #edit-branch-id").select2({dropdownParent: $('#modal-edit')})
        })

        $(document).on('input', '.calculate-params', function () {
            const principalId = $('#create-principal-id').val()
            const branchId = $('#create-branch-id').val()
            const month = $('#create-month').val()
            const year = $('#create-year').val()
            if(principalId && branchId && month && year){
                let formData = new FormData(document.getElementById('form-create'))
                formData.append('type','principal_to_branch')
                ajaxPost("{{ route('payments.principal-to-branch.index') }}",formData,'',function(response){
                    if(response.success){
                        $('#create-nominal').val(numberFormat(response.data.total))
                    }
                },null,false)
            }
        })
        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            formData.append('type','principal_to_branch')
            ajaxPost("{{ route('payments.principal-to-branch.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('payments.principal-to-branch.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    payment = response.data
                    $('#show-paid_at').html(payment.paid_at)
                    $('#show-principal').html(payment.principal.name)
                    $('#show-branch').html(payment.branch.name)
                    $('#show-nominal').html(numberFormat(payment.total_bill))
                    $('#show-desc').html(payment.desc)
                }
            })
        })
        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Pembayaran?",
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxPost("{{ route('payments.principal-to-branch.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method:'delete'},'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
