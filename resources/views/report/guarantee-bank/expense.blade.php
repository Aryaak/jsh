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
                    3 => "No. Polis",
                    4 => "Nilai Jaminan",
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

        <form id="filter-form">
        </form>

        <x-button type="submit" onclick="filter()" class="w-100" icon='bx bxs-filter-alt'>Filter</x-button>
    </x-card>

    {{-- Chart --}}
    <x-card class="mb-4">
        <div class="chart-container-11">
            <canvas id="chart"></canvas>
        </div>
    </x-card>

    {{-- Table --}}
    <x-card>
        <x-table id="table">
            @slot('thead')
                <tr>
                    <th>No.</th>
                    <th>Tanggal Transaksi</th>
                    <th>No. Kwitansi</th>
                    <th>No. Bond</th>
                    <th>No. Polis</th>
                    <th>Nominal</th>
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
            select.select2()
            table = dataTableInit('table','Pemasukan',{
                url : '{{ route('bg-reports.expense') }}',
                data: function(data){
                    const formData = $("#filter-form").serializeArray();
                    data.params = {}
                    $.each(formData, function(key, val) {
                        data.params[val.name] = val.value;
                    });
                    data.params.startDate = start.val()
                    data.params.endDate = end.val()
                    data.request_for = 'datatable'
                }
            },[
                {data: 'date',name: 'created_at'},
                {data: 'receipt_number',name: 'receipt_number'},
                {data: 'bond_number',name: 'bond_number'},
                {data: 'polish_number',name: 'polish_number'},
                {data: 'nominal', name: 'insurance_total_net'}
            ],{},null,false,false)
            drawChart()
        })
        function filter(){
            table.ajax.reload()
            drawChart()
        }
        function drawChart(){
            let formData = new FormData(document.getElementById('filter-form'))
            formData.append('startDate',start.val())
            formData.append('endDate',end.val())
            formData.append('request_for','chart')

            ajaxPost('{{ route('bg-reports.expense') }}',formData, null, function (result) {
                const income = result.data
                if(chart) chart.destroy()
                chart = new Chart(document.getElementById('chart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: income.labels,
                        datasets: [{
                            label: "Total",
                            data: income.datasets,
                            backgroundColor: '#8CC152FF',
                            backgroundColor: '#8CC152AA',
                            borderWidth: 1,
                            pointRadius: 4,
                            pointRotation: 3,
                            tension: .3,
                            fill: true
                        }]
                    },
                    options: ChartOptionToRupiah
                });

                Swal.close()
            }, function (errorResponse) {
                Swal.fire({
                    title: "Gagal menghitung nominal!",
                    text: errorResponse.message,
                    icon: 'error',
                })
            }, false)
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


        $("#add-new-filter").click(function () {
            addNewFilter()
        })

        function addNewFilter() {
            filterCount++

            $("#filter-form").append(`
                <div class="row">
                    <div class="col-md-4 mb-2"><x-form-select label="Kolom" id="column-` + filterCount + `" :options="$columns" name="columns[` + filterCount + `][name]" /></div>
                    <div class="col-md-4 mb-2"><x-form-select label="Operator" id="operator-` + filterCount + `" :options="$operators" name="columns[` + filterCount + `][operator]" /></div>
                    <div class="col-md-4 mb-2"><x-form-input label="Isi Filter" id="value-` + filterCount + `" name="columns[` + filterCount + `][value]" type="search"/></div>
                </div>
            `)

            $("#column-" + filterCount + ", #operator-" + filterCount + "").select2()
        }
    </script>
@endpush
