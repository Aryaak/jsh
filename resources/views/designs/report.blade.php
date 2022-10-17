@extends('layouts.main', ['title' => 'Laporan'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    {{-- Filter --}}
    <x-card class="mb-4">
        <div class="row">
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
            @endphp

            <div class="col-md-4 mb-2"><x-form-select label="Periode" id="period" :options="$options" name="" empty /></div>
            <div class="col-md-4 mb-2"><x-form-input id="startDate" name="startDate" type="date" label="Tanggal Awal" value="{{ today()->toDateString() }}"/></div>
            <div class="col-md-4 mb-2"><x-form-input id="endDate" name="endDate" type="date" label="Tanggal Akhir" value="{{ today()->toDateString() }}"/></div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-2"><x-form-select label="Partner" id="partnerId" :options="[]" name="partnerId" selectedNone="Semua Partner" /></div>
            <div class="col-md-6 mb-3"><x-form-select label="Customer" id="customerId" :options="[]" name="customerId" selectedNone="Semua Customer" /></div>
        </div>

        <x-button type="button" onclick="filter()" class="w-100"><i class='bx bxs-filter-alt align-middle me-2'></i>Filter</x-button>
    </x-card>

    {{-- Summary --}}
    <div class="row">
        <div class="col-md-4 mb-3">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0">
                        <i class="bx bx-recycle"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        Rp<span id="total_transaction"></span>,-<br>
                        <small class="h6">Seluruh Transaksi</small>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-3">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0">
                        <i class="bx bx-money"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        Rp<span id="total_withdrawal"></span>,-<br>
                        <small class="h6">Seluruh Penarikan</small>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-4">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0">
                        <i class="bx bxs-report"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        Rp<span id="total_amount"></span>,-<br>
                        <small class="h6">Total Keseluruhan</small>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    {{-- Table --}}
    <x-card class="mb-4">
        <x-table id="table">
            @slot('thead')
                <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Partner</th>
                    <th>Customer</th>
                    <th>Nominal</th>
                    <th>Waktu</th>
                </tr>
            @endslot
        </x-table>
    </x-card>

    {{-- Cart --}}
    <x-card>
        <div class="chart-container-11">
            <canvas id="chart"></canvas>
        </div>
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
        let total_amount = 0
        let total_transaksi = 0
        let total_penarikan = 0
        const select = $("#period")
        const start = $("#startDate")
        const end = $("#endDate")

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
    </script>
@endpush
