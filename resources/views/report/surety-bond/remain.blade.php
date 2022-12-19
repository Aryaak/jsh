@extends('layouts.main', ['title' => 'Laporan'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    {{-- Filter --}}
    <x-card class="mb-4">
        <div class="row mb-2">
            @php
                $options = [
                    0 => 'Sesuaikan Sendiri',
                    1 => 'Hari Ini',
                    7 => 'Seminggu',
                    31 => 'Sebulan',
                    93 => '3 Bulan',
                    186 => '6 Bulan',
                    365 => 'Setahun',
                ];

                $columns = [
                    1 => "No. Kwitansi",
                    2 => "No. Bond",
                    3 => "Nama Principal",
                    4 => "Nilai Bond",
                ];

                $operators = [
                    'like' => "Mirip Seperti",
                    '=' => "Sama Dengan (=)",
                    '>' => "Lebih Dari (>)",
                    '>=' => "Lebih Dari atau Sama Dengan (≥)",
                    '<' => "Kurang Dari (<)",
                    '<=' => "Kurang Dari atau Sama Dengan (≤)",
                ];
            @endphp

            <div class="col-md-4 mb-2"><x-form-select label="Periode" id="period" :options="$options" name="" /></div>
            <div class="col-md-4 mb-2"><x-form-input label="Tanggal Awal" id="startDate" name="startDate" type="date" value="{{ today()->toDateString() }}"/></div>
            <div class="col-md-4 mb-2"><x-form-input label="Tanggal Akhir" id="endDate" name="endDate" type="date" value="{{ today()->toDateString() }}"/></div>
        </div>

        <x-button type="button" id="add-new-filter" class="mb-3" icon="bx bx-plus" face="secondary">Tambah Filter</x-button>
        <x-button type="button" id="delete-new-filter" class="mb-3 d-none" icon="bx bx-x" face="danger">Hapus Filter</x-button>

        <form id="filter-form"></form>

        <x-button type="submit" onclick="filter()" class="w-100" icon='bx bxs-filter-alt'>Filter</x-button>
    </x-card>

    {{-- Summary --}}
    {{-- <div class="row">
        <div class="col-md-4 mb-3">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0 text-danger">
                        <i class="bx bx-money"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        <span id="total-expense">Rp10.000.000,-</span><br>
                        <small class="h6">Total Pengeluaran</small>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-md-4 mb-3">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0 text-primary">
                        <i class="bx bx-money"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        <span id="total-income">Rp30.000.000,-</span><br>
                        <small class="h6">Total Pemasukan</small>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-4">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0 text-success">
                        <i class="bx bx-money"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        <span id="total-profit">Rp20.000.000,-</span><br>
                        <small class="h6">Total Profit</small>
                    </div>
                </div>
            </x-card>
        </div>
    </div> --}}

    {{-- Chart --}}
    {{-- <x-card class="mb-4">
        <div class="chart-container-11">
            <canvas id="chart"></canvas>
        </div>
    </x-card> --}}

    {{-- Table --}}
    <x-card>
        <x-table id="table">
            @slot('thead')
                <tr>
                    <th rowspan="2" class="text-center">No.</th>
                    <th rowspan="2" class="text-center">No. Kwitansi</th>
                    <th rowspan="2" class="text-center">No. Bond</th>
                    <th rowspan="2" class="text-center">Nama Prinicipal</th>
                    <th rowspan="2" class="text-center">Nilai Bond</th>
                    <th colspan="2" class="text-center">Jangka Waktu</th>
                    <th rowspan="2" class="text-center">Jml Hari</th>
                    <th rowspan="2" class="text-center">ASS</th>
                    <th colspan="3" class="text-center">Setor Kantor</th>
                    <th colspan="3" class="text-center">Kwitansi</th>
                    <th rowspan="2" class="text-center">Sisa</th>
                    <th rowspan="2" class="text-center">Ket</th>
                    <th rowspan="2" class="text-center">Status</th>
                    <th rowspan="2" class="text-center">Payment</th>
                </tr>
                <tr>
                    <th class="text-center">Awal</th>
                    <th class="text-center">Akhir</th>
                    <th class="text-center">Total Nett Kantor</th>
                    <th class="text-center">Biaya Admin</th>
                    <th class="text-center">Total Kantor</th>
                    <th class="text-center">Service Charge</th>
                    <th class="text-center">Biaya Admin</th>
                    <th class="text-center">Premi Bayar</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@push('js')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chart = null
        let table = null
        let filterCount = 0

        const select = $("#period")
        const start = $("#startDate")
        const end = $("#endDate")
        $(document).ready(function() {
            table = dataTableInit('table','Sisa Agen',{
                url : '{{ route($global->currently_on.'.sb-reports.remain', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}',
                data: function(data){
                    const formData = $("#filter-form").serializeArray();
                    data.params = {}
                    $.each(formData, function(key, val) {
                        data.params[val.name] = val.value;
                    });
                    data.params.startDate = start.val()
                    data.params.endDate = end.val()
                    @if (request()->has('start') && request()->has('end'))
                        data.params.startDate = "{{ request()->start }}"
                        data.params.endDate = "{{ request()->end }}"
                    @endif
                    data.request_for = 'datatable'
                }
            },[
                {data: 'receipt_number', name: 'sb.receipt_number'},
                {data: 'bond_number', name: 'sb.bond_number'},
                {data: 'principal_name', name: 'p.name'},
                {data: 'insurance_value', name: 'sb.insurance_value'},
                {data: 'start_date', name: 'sb.start_date'},
                {data: 'end_date', name: 'sb.end_date'},
                {data: 'day_count', name: 'sb.day_count',render: function(row, type, data) {
                    if(data.due_day_tolerance > 0){
                        return (row - data.due_day_tolerance)+' + ('+data.due_day_tolerance+')'
                    }else{
                        return row
                    }
                }},
                {data: 'code', name: 'it.code'},
                {data: 'office_net', name: 'sb.office_net'},
                {data: 'admin_charge', name: 'sb.admin_charge'},
                {data: 'office_total', name: 'office_total', searchable:false},
                {data: 'service_charge', name: 'sb.service_charge'},
                {data: 'admin_charge', name: 'sb.admin_charge'},
                {data: 'receipt_total', name: 'receipt_total', searchable:false},
                {data: 'total_charge', name: 'total_charge', searchable:false},
                {data: 'agent_name', name: 'a.name'},
                {data: 'status',searchable:false,orderable:false},
                {data: 'payment',searchable:false,orderable:false,render: function(row) {
                    return row >0 ? 'Lunas' : 'Piutang';
                }},
            ],{},null,false,false)
        })
        function filter(){
            table.ajax.reload()

            const filter = $("#filter-form").serializeArray();
            var params = {}
            $("#params-container").html('')
            $.each(filter, function(key, val) {
                $("#params-container").append(`<x-form-input id="params" name="`+val.name+`" class="mb-3" value="`+val.value+`" required hidden/>`)
                $("#params-container").append(`<x-form-input id="params" name="name[]" class="mb-3" value="`+val.name+`" required hidden/>`)
            });
            $("#params-container").append(`<x-form-input id="params" name="startDate" class="mb-3" value="`+start.val()+`" required hidden/>`)
            $("#params-container").append(`<x-form-input id="params" name="endDate" class="mb-3" value="`+end.val()+`" required hidden/>`)
            @if (request()->has('start') && request()->has('end'))
                $("#params-container").append(`<x-form-input id="params" name="startDate" class="mb-3" value="{{ request()->start }}" required hidden/>`)
                $("#params-container").append(`<x-form-input id="params" name="endDate" class="mb-3" value="{{ request()->end }}" required hidden/>`)
            @endif
        }
        select.change(function() {
            const val = $(this).val()
            if (val == 1 || val == 7 || val == 31 || val == 93 || val == 186 || val == 365 ) end.val("{{ date('Y-m-d', strtotime('now')) }}")
            if (val == 1) start.val(moment().format("YYYY-MM-DD"))
            if (val == 7) start.val(moment().subtract(7, 'days').format("YYYY-MM-DD"))
            if (val == 31) start.val(moment().subtract(1, 'month').format("YYYY-MM-DD"))
            if (val == 93) start.val(moment().subtract(3, 'month').format("YYYY-MM-DD"))
            if (val == 186) start.val(moment().subtract(6, 'month').format("YYYY-MM-DD"))
            if (val == 365) start.val(moment().subtract(1, 'year').format("YYYY-MM-DD"))
            end.prop('min', start.val())
        })

        start.change(function() {
            end.prop('min', start.val())
            select.val("0")
            select.trigger("change")
        })

        end.change(function() {
            select.val("0")
            select.trigger("change")
        })

        $(document).ready(function() {
            select.select2()
        })

        $("#add-new-filter").click(function () {
            addNewFilter()
        })

        $("#delete-new-filter").click(function() {
            $('.filters').remove()
            $(this).addClass('d-none')
        })

        function addNewFilter() {
            $("#delete-new-filter").removeClass('d-none')

            filterCount++

            $("#filter-form").append(`
                <div class="row filters">
                    <div class="col-md-4 mb-2"><x-form-select label="Kolom" id="column-` + filterCount + `" :options="$columns" name="columns[` + filterCount + `][name]" value='1' /></div>
                    <div class="col-md-4 mb-2"><x-form-select label="Operator" id="operator-` + filterCount + `" :options="$operators" name="columns[` + filterCount + `][operator]"  value='like' /></div>
                    <div class="col-md-4 mb-2"><x-form-input label="Isi Filter" id="value-` + filterCount + `" name="columns[` + filterCount + `][value]" type="search"/></div>
                </div>
            `)

            $("#column-" + filterCount + ", #operator-" + filterCount + "").select2()
        }

        $("#filter-form").submit(function (e){
            e.preventDefault()
            filter()
        })
    </script>
@endpush
