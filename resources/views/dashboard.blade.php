@extends('layouts.main', ['title' => 'Dasbor'])

@section('contents')
    {{-- Summary --}}
    <div class="row">
        <div class="col-md-4 mb-3">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0 text-primary">
                        <i class="bx bxs-user-account"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        <span id="total-agent">{{ $agen }}</span><br>
                        <small class="h6">Total Agen</small>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="col-md-4 mb-3">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0 text-danger">
                        <i class="bx bx-receipt"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        <span id="total-surety-bond-not-paid">{{ $non_lunas }}</span><br>
                        <small class="h6">Total Surety Bond Belum Lunas</small>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-md-4 mb-4">
            <x-card>
                <div class="d-flex display-5 align-items-center">
                    <div class="p-0 m-0 text-success">
                        <i class="bx bxs-receipt"></i>
                    </div>
                    <div class="border-start ps-3 ms-3">
                        <span id="total-surety-bond-not-paid">{{ $lunas }}</span><br>
                        <small class="h6">Total Surety Bond Lunas</small>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <x-card class="mb-4">
        <div class="income-chart-container">
            <canvas id="chart-1"></canvas>
        </div>
    </x-card>

    <x-card class="mb-4">
        <div class="expense-chart-container">
            <canvas id="chart-2"></canvas>
        </div>
    </x-card>

    <x-card class="mb-4">
        <div class="surety-bond-chart-container">
            <canvas id="chart-3"></canvas>
        </div>
    </x-card>

    <x-card class="mb-4">
        <div class="guarantee-bank-chart-container">
            <canvas id="chart-4"></canvas>
        </div>
    </x-card>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
          const labels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Data 2022',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45, 0, 10, 5, 2, 20],
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('chart-1'),
            config
        );
    </script>
@endpush
