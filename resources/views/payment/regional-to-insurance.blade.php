@extends('layouts.main', ['title' => 'Pembayaran Ke Asuransi'])

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
                    <th>Ke Asuransi</th>
                    <th>Nominal Bayar</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    @php
        $months = [];
        foreach (range(1, 12) as $month) {
            $months[$month] = Sirius::longMonth($month);
        }

        $years = [];
        foreach (range(date('Y'), 2000) as $year) {
            $years[$year] = $year;
        }
    @endphp

    <x-modal id="modal-create" title="Tambah Pembayaran" size="fullscreen">
        <x-form id="form-create" method="post">
            <input type="hidden" id="create-regional-id" class="calculate-params" name="regionalId" value="{{ $global->regional->id }}">
            <x-form-input label="Waktu Bayar" id="create-paid-at" class-input="calculate-params" name="paidAt" type="datetime-local" class="mb-3" required />
            <x-form-select label="Bulan" id="create-month" class-input="calculate-params" name="month" class="mb-3" :options="$months" value="{{ date('m') }}" required />
            <x-form-select label="Tahun" id="create-year" class-input="calculate-params" name="year" class="mb-3" :options="$years" value="{{ date('Y') }}" required />
            <x-form-select label="Ke Asuransi" id="create-insurance-id" class-input="calculate-params" name="insuranceId" class="mb-3" required />
            <div class="mb-3">
                <x-form-label required>Nominal Bayar</x-form-label>
                <div id="create-nominal">-</div>
            </div>
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
                {data: 'insurance.name'},
                {data: 'total_bill'}
            ])
            $("#create-month, #create-year").select2({dropdownParent: $('#modal-create')})
            select2Init("#create-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-create'))
        })
        $(document).on('input', '.calculate-params', function () {
            const regionalId = $('#create-regional-id').val()
            const insuranceId = $('#create-insurance-id').val()
            const month = $('#create-month').val()
            const year = $('#create-year').val()
            if(regionalId && insuranceId && month && year){
                $('#create-nominal').html(`<i class='fa-solid fa-spinner fa-spin me-2'></i>Menghitung ...`)
                let formData = new FormData(document.getElementById('form-create'))
                formData.append('type',type)
                ajaxPost("{{ route('payments.calculate') }}",formData,'',function(response){
                    if(response.success){
                        $('#create-nominal').html(response.data.total_converted)
                    }
                },function (response) {
                    $('#create-nominal').html(`<span class='color-danger'><i class='fa-solid fa-x me-2'></i>Terjadi masalah pada sistem</span>`)
                },false)
            }
        })
        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            formData.append('type',type)
            ajaxPost("{{ route('payments.payment.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
                $("#create-nominal").html('-')
                $('#create-year').val('{{ date('Y') }}').trigger('change')
                $('#create-month').val('{{ date('m') }}').trigger('change')
            })
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('payments.payment.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    payment = response.data
                    $('#show-paid-at').html(payment.paid_at_converted)
                    $('#show-insurance').html(payment.insurance.name)
                    $('#show-nominal').html(payment.total_bill_converted)
                    $('#show-desc').html(payment.desc ?? '-')
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
