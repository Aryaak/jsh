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
                    <th>Dari Regional</th>
                    <th>Ke Asuransi</th>
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
            <x-form-input label="Waktu Bayar" id="create-paid-at" class-input="calculate-params" name="paidAt" type="datetime-local" class="mb-3" required />
            <x-form-input label="Bulan" id="create-month" class-input="calculate-params" name="month" type="number" class="mb-3" required />
            <x-form-input label="Tahun" id="create-year" class-input="calculate-params" name="year" type="number" class="mb-3" required />
            <x-form-select label="Dari Regional" id="create-regional-id" class-input="calculate-params" name="regionalId" class="mb-3" required />
            <x-form-select label="Ke Asuransi" id="create-insurance-id" class-input="calculate-params" name="insuranceId" class="mb-3" required />
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
            <span id="show-paid-at">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Dari Regional</b>: <br>
            <span id="show-regional">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Ke Asuransi</b>: <br>
            <span id="show-insurance">-</span>
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
            <x-form-input label="Waktu Bayar" id="edit-datetime" name="datetime" type="datetime-local" class="mb-3" required />
            <x-form-select label="Dari Regional" id="edit-regional-id" name="regionalId" :options="[]" class="mb-3" required />
            <x-form-select label="Ke Asuransi" id="edit-insurance-id" name="insuranceId" :options="[]" class="mb-3" required />
            <x-form-input label="Nominal Bayar" id="edit-nominal" name="nominal" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
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
        const type = 'regional_to_insurance'
        $(document).ready(function () {
            table = dataTableInit('table','Pembayaran',{
                    url : '{{ route('payments.tables') }}',
                    data : { type : type }
                },[
                {data: 'paid_at'},
                {data: 'regional.name'},
                {data: 'insurance.name'},
                {data: 'total_bill'}
            ])
            select2Init("#create-regional-id",'{{ route('select2.regional') }}',0,$('#modal-create'))
            select2Init("#create-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-create'))
        })
        $(document).on('input', '.calculate-params', function () {
            const regionalId = $('#create-regional-id').val()
            const insuranceId = $('#create-insurance-id').val()
            const month = $('#create-month').val()
            const year = $('#create-year').val()
            if(regionalId && insuranceId && month && year){
                let formData = new FormData(document.getElementById('form-create'))
                formData.append('type',type)
                ajaxPost("{{ route('payments.calculate') }}",formData,'',function(response){
                    if(response.success){
                        $('#create-nominal').val(numberFormat(response.data.total))
                    }
                },null,false)
            }
        })
        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            formData.append('type',type)
            ajaxPost("{{ route('payments.payment.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('payments.payment.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    payment = response.data
                    $('#show-paid-at').html(payment.paid_at)
                    $('#show-regional').html(payment.regional.name)
                    $('#show-insurance').html(payment.insurance.name)
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
                    ajaxPost("{{ route('payments.payment.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method:'delete'},'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
