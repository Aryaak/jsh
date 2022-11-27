@extends('layouts.main', ['title' => 'Pembayaran'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Total Hutang" class="mb-3">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-payable" size="sm" icon="bx bx-search" face="info">Detail Hutang</x-button>
        @endslot
        <div class="h1 text-end text-danger fw-bold mb-0" id="payable-total">

        </div>
    </x-card>

    <x-card header="Daftar Pembayaran">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" id="btn-create" size="sm" icon="bx bx-plus">Tambah Pembayaran</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Waktu Bayar</th>
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
            <x-form-input label="Waktu Bayar" id="create-datetime" name="datetime" type="datetime-local" class="mb-3" required />
            <div class="row mb-3">
                <div class="col">
                    <x-form-label>Total Tagihan</x-form-label>
                    <div id="create-payable-total">Rp0,-</div>
                </div>
            </div>
            <x-form-input label="Nominal Bayar" id="create-nominal" name="nominal" prefix="Rp" suffix=",-" class-input="to-rupiah" class="mb-3" required />
            <x-form-textarea label="Keterangan" id="create-desc" name="desc" />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Pembayaran">
        <div class="border-bottom pb-2 mb-2">
            <b>Waktu Bayar</b>: <br>
            <span id="show-datetime">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Bulan</b>: <br>
            <span id="show-month">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Tahun</b>: <br>
            <span id="show-year">-</span>
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

    <x-modal id="modal-payable" title="Detail Hutang" size="fullscreen">
        <x-table id="payable-table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Total Hutang</th>
                    <th>Terbayar</th>
                    <th>Sisa</th>
                </tr>
            @endslot
        </x-table>
    </x-modal>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let table = null
        let payment = null
        const type = 'branch_to_regional'
        $(document).ready(function () {
            table = dataTableInit('table','Pembayaran',{
                    url : '{{ route('branch.payments.branch-to-regional.index',['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}',
                    data : { type : type }
                },[
                {data: 'paid_at'},
                {data: 'nominal'},
            ])
            $("#create-month, #create-year").select2({dropdownParent: $('#modal-create')})
            $("#create-branch-id, #create-regional-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-branch-id, #edit-regional-id").select2({dropdownParent: $('#modal-edit')})

            payments()
        })
        function payments(){
            $('#payable-table tbody').html('')
            ajaxPost("{{ route('branch.payments.branch-to-regional.payable',['regional' => $global->regional, 'branch' => $global->branch]) }}",{},'',function(response){
                if(response.success){
                    const data = response.data
                    let html = ''
                    let iteration = 1
                    data.index.forEach(e => {
                        html+="<tr><td>"+iteration+"</td><td>"+e.month+"</td><td>"+e.year+"</td><td>"+e.payable_total_converted+"</td><td>"+e.paid_total_converted+"</td><td>"+e.unpaid_total_converted+"</td></tr>"
                        iteration++
                    });
                    $('#payable-table tbody').html(html)
                }
            },null,false)
        }

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Pembayaran?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
        $(document).on('click', '#btn-create', function () {
            $('#create-nominal').html(`<i class='fa-solid fa-spinner fa-spin me-2'></i>Menghitung ...`)
            let formData = new FormData(document.getElementById('form-create'))
            ajaxPost("{{ route('branch.payments.branch-to-regional.calculate',['regional' => $global->regional, 'branch' => $global->branch]) }}",formData,'',function(response){
                if(response.success){
                    const data = response.data
                    $('#create-payable-total').html(data.payable_total_converted)
                }
            },function (response) {
                $('#create-nominal').html(`<span class='color-danger'><i class='fa-solid fa-x me-2'></i>Terjadi masalah pada sistem</span>`)
            },false)
        })
        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            formData.append('type',type)
            formData.set('nominal',formData.get('nominal').replaceAll('.',''))
            ajaxPost("{{ route('branch.payments.branch-to-regional.store',['regional' => $global->regional, 'branch' => $global->branch]) }}",formData,'#modal-create',function(){
                payments()
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
                    $('#show-datetime').html(payment.paid_at_converted)
                    $('#show-month').html(payment.month)
                    $('#show-year').html(payment.year)
                    $('#show-nominal').html(payment.total_bill_converted)
                    $('#show-desc').html(payment.desc ?? '-')

                }
            })
        })
        $(document).on('click', '.btn-delete', function () {
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Pembayaran ini?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('branch.payments.branch-to-regional.destroy',['regional' => $global->regional, 'branch' => $global->branch,'instalment' => '-instalment-']) }}".replace('-instalment-',$(this).data('id')),{_method: 'delete'},'',function(){
                        payments()
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
