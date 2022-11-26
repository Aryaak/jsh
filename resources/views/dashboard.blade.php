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
            <canvas id="chart_sb"></canvas>
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

        // CHART SURETY BONDS
        // const data_sb = {
        //     labels: labels,
        //     datasets: [{
        //         label: 'Profit',
        //         backgroundColor: 'rgb(255, 99, 132)',
        //         borderColor: 'rgb(255, 99, 132)',
                // data: [
                //     @json($data_sbs[0]['total_profit']),
                //     @json($data_sbs[1]['total_profit']),
                //     @json($data_sbs[2]['total_profit']),
                //     @json($data_sbs[3]['total_profit']),
                //     @json($data_sbs[4]['total_profit']),
                //     @json($data_sbs[5]['total_profit']),
                //     @json($data_sbs[6]['total_profit']),
                //     @json($data_sbs[7]['total_profit']),
                //     @json($data_sbs[8]['total_profit']),
                //     @json($data_sbs[9]['total_profit']),
                //     @json($data_sbs[10]['total_profit']),
                //     @json($data_sbs[11]['total_profit']),
                // ],
        //     }]
        // };
        // var option = {
        //     showLines: true,
        //     onClick: function(evt) {
        //         var element = myChart_sb.getElementAtEvent(evt);
        //         if(element.length > 0)
        //         {
        //             var ind = element[0]._index;
        //             if(confirm('Do you want to remove this point?')){
        //                 data.datasets[0].data.splice(ind, 1);
        //                 data.labels.splice(ind, 1);
        //                 myLineChart.update(data);
        //             }
        //         }
        //     }
        // };
        // const config_sb = {
        //     type: 'line',
        //     data: data_sb,
        //     options: option
        // };
        // const myChart_sb = new Chart(
        //     document.getElementById('chart_sb'),
        //     config_sb
        // );

        var canvas = document.getElementById('chart_sb');
        var data = {
            labels: labels,
            datasets: [
                {
                    label: "Profit Surety Bonds",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 5,
                    pointHitRadius: 10,
                    data: [
                        @json($data_sbs[0]['total_profit']),
                        @json($data_sbs[1]['total_profit']),
                        @json($data_sbs[2]['total_profit']),
                        @json($data_sbs[3]['total_profit']),
                        @json($data_sbs[4]['total_profit']),
                        @json($data_sbs[5]['total_profit']),
                        @json($data_sbs[6]['total_profit']),
                        @json($data_sbs[7]['total_profit']),
                        @json($data_sbs[8]['total_profit']),
                        @json($data_sbs[9]['total_profit']),
                        @json($data_sbs[10]['total_profit']),
                        @json($data_sbs[11]['total_profit']),
                    ],
                }
            ]
        };

        var option = {
            showLines: true,
            onClick: (e, activeEls) => {
                let datasetIndex = activeEls[0].datasetIndex;
                let dataIndex = activeEls[0].index;
                let datasetLabel = e.chart.data.datasets[datasetIndex].label;
                let value = e.chart.data.datasets[datasetIndex].data[dataIndex];
                let label = e.chart.data.labels[dataIndex];

            }
        };

        var myLineChart = new Chart(canvas,{
            type: 'line',
            data: data,
            options: option,
        });
        // ==================
    </script>
@endpush
