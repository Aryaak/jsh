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
            <canvas id="chart_bg"></canvas>
        </div>
    </x-card>

    <x-card class="mb-4">
        <div class="surety-bond-chart-container">
            <canvas id="chart_BR"></canvas>
        </div>
    </x-card>

    <x-card class="mb-4">
        <div class="guarantee-bank-chart-container">
            <canvas id="chart_RI"></canvas>
        </div>
    </x-card>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels_sb = [
            @json($data_sbs[0]['bulan']),
            @json($data_sbs[1]['bulan']),
            @json($data_sbs[2]['bulan']),
            @json($data_sbs[3]['bulan']),
            @json($data_sbs[4]['bulan']),
            @json($data_sbs[5]['bulan']),
            @json($data_sbs[6]['bulan']),
            @json($data_sbs[7]['bulan']),
            @json($data_sbs[8]['bulan']),
            @json($data_sbs[9]['bulan']),
            @json($data_sbs[10]['bulan']),
            @json($data_sbs[11]['bulan']),
        ];
        const labels_bg = [
            @json($data_bgs[0]['bulan']),
            @json($data_bgs[1]['bulan']),
            @json($data_bgs[2]['bulan']),
            @json($data_bgs[3]['bulan']),
            @json($data_bgs[4]['bulan']),
            @json($data_bgs[5]['bulan']),
            @json($data_bgs[6]['bulan']),
            @json($data_bgs[7]['bulan']),
            @json($data_bgs[8]['bulan']),
            @json($data_bgs[9]['bulan']),
            @json($data_bgs[10]['bulan']),
            @json($data_bgs[11]['bulan']),
        ];
        const labels_RI = [
            @json($data_RI[0]['bulan']),
            @json($data_RI[1]['bulan']),
            @json($data_RI[2]['bulan']),
            @json($data_RI[3]['bulan']),
            @json($data_RI[4]['bulan']),
            @json($data_RI[5]['bulan']),
            @json($data_RI[6]['bulan']),
            @json($data_RI[7]['bulan']),
            @json($data_RI[8]['bulan']),
            @json($data_RI[9]['bulan']),
            @json($data_RI[10]['bulan']),
            @json($data_RI[11]['bulan']),
        ];
        const labels_BR = [
            @json($data_BR[0]['bulan']),
            @json($data_BR[1]['bulan']),
            @json($data_BR[2]['bulan']),
            @json($data_BR[3]['bulan']),
            @json($data_BR[4]['bulan']),
            @json($data_BR[5]['bulan']),
            @json($data_BR[6]['bulan']),
            @json($data_BR[7]['bulan']),
            @json($data_BR[8]['bulan']),
            @json($data_BR[9]['bulan']),
            @json($data_BR[10]['bulan']),
            @json($data_BR[11]['bulan']),
        ];
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
        // SB
        var canvas_sb = document.getElementById('chart_sb');
        var data_sb = {
            labels: labels_sb,
            datasets: [
                {
                    label: "Profit",
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
        var option_sb = {
            showLines: true,
            onClick: (e, activeEls) => {
                let datasetIndex = activeEls[0].datasetIndex;
                let dataIndex = activeEls[0].index;
                let datasetLabel = e.chart.data.datasets[datasetIndex].label;
                let value = e.chart.data.datasets[datasetIndex].data[dataIndex];
                let label = e.chart.data.labels[dataIndex];

                const tgl = label.split(" ")
                let bulan = tgl[0]
                let tahun = tgl[1]

                if(bulan == 'Januari'){bulan = '01'}
                else if(bulan == 'Februari'){bulan = '02'}
                else if(bulan == 'Maret'){bulan = '03'}
                else if(bulan == 'April'){bulan = '04'}
                else if(bulan == 'Mei'){bulan = '05'}
                else if(bulan == 'Juni'){bulan = '06'}
                else if(bulan == 'Juli'){bulan = '07'}
                else if(bulan == 'Agustus'){bulan = '08'}
                else if(bulan == 'September'){bulan = '09'}
                else if(bulan == 'Oktober'){bulan = '10'}
                else if(bulan == 'November'){bulan = '11'}
                else if(bulan == 'Desember'){bulan = '12'}

                var start = tahun+'-'+bulan+'-01'
                var end = tahun+'-'+bulan+'-31'

                @if ($global->currently_on == 'main')
                    var url = "{{ route('main.sb-reports.production', ['startDate' => '-start-', 'endDate' => '-end-']) }}"
                @endif
                @if ($global->currently_on == 'regional')
                    var url = "{{ route('regional.sb-reports.production', ['regional' => $global->regional, 'startDate' => '-start-', 'endDate' => '-end-']) }}"
                @endif
                @if ($global->currently_on == 'branch')
                    var url = "{{ route('branch.sb-reports.production', ['regional' => $global->regional, 'branch' => $global->branch, 'startDate' => '-start-', 'endDate' => '-end-']) }}"
                @endif

                var url2 = url.replace('-start-',start)
                var url3 = url2.replace('-end-',end)
                window.location.href = url3.replace('&amp;','&')
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Surety Bonds',
                    padding: {
                        top: 0,
                        bottom: 0
                    },
                    font: {
                        size: 24,
                        style: 'italic',
                        family: 'Helvetica Neue'
                    }
                }
            }
        };
        var sb = new Chart(canvas_sb,{
            type: 'line',
            data: data_sb,
            options: option_sb,
        });
        // ==================

        // BG
        var canvas_bg = document.getElementById('chart_bg');
        var data_bg = {
            labels: labels_bg,
            datasets: [
                {
                    label: "Profit",
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
                        @json($data_bgs[0]['total_profit']),
                        @json($data_bgs[1]['total_profit']),
                        @json($data_bgs[2]['total_profit']),
                        @json($data_bgs[3]['total_profit']),
                        @json($data_bgs[4]['total_profit']),
                        @json($data_bgs[5]['total_profit']),
                        @json($data_bgs[6]['total_profit']),
                        @json($data_bgs[7]['total_profit']),
                        @json($data_bgs[8]['total_profit']),
                        @json($data_bgs[9]['total_profit']),
                        @json($data_bgs[10]['total_profit']),
                        @json($data_bgs[11]['total_profit']),
                    ],
                }
            ]
        };
        var option_bg = {
            showLines: true,
            onClick: (e, activeEls) => {
                let datasetIndex = activeEls[0].datasetIndex;
                let dataIndex = activeEls[0].index;
                let datasetLabel = e.chart.data.datasets[datasetIndex].label;
                let value = e.chart.data.datasets[datasetIndex].data[dataIndex];
                let label = e.chart.data.labels[dataIndex];


                const tgl = label.split(" ")
                let bulan = tgl[0]
                let tahun = tgl[1]

                if(bulan == 'Januari'){bulan = '01'}
                else if(bulan == 'Februari'){bulan = '02'}
                else if(bulan == 'Maret'){bulan = '03'}
                else if(bulan == 'April'){bulan = '04'}
                else if(bulan == 'Mei'){bulan = '05'}
                else if(bulan == 'Juni'){bulan = '06'}
                else if(bulan == 'Juli'){bulan = '07'}
                else if(bulan == 'Agustus'){bulan = '08'}
                else if(bulan == 'September'){bulan = '09'}
                else if(bulan == 'Oktober'){bulan = '10'}
                else if(bulan == 'November'){bulan = '11'}
                else if(bulan == 'Desember'){bulan = '12'}

                var start = tahun+'-'+bulan+'-01'
                var end = tahun+'-'+bulan+'-31'

                @if ($global->currently_on == 'main')
                    var url = "{{ route('main.bg-reports.production', ['startDate' => '-start-', 'endDate' => '-end-']) }}"
                @endif
                @if ($global->currently_on == 'regional')
                    var url = "{{ route('regional.bg-reports.production', ['regional' => $global->regional ?? '', 'startDate' => '-start-', 'endDate' => '-end-']) }}"
                @endif
                @if ($global->currently_on == 'branch')
                    var url = "{{ route('branch.bg-reports.production', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '', 'startDate' => '-start-', 'endDate' => '-end-']) }}"
                @endif

                var url2 = url.replace('-start-',start)
                var url3 = url2.replace('-end-',end)
                window.location.href = url3.replace('&amp;','&')
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Bank Garansi',
                    padding: {
                        top: 0,
                        bottom: 0
                    },
                    font: {
                        size: 24,
                        style: 'italic',
                        family: 'Helvetica Neue'
                    }
                }
            }
        };
        var bg = new Chart(canvas_bg,{
            type: 'line',
            data: data_bg,
            options: option_bg,
        });
        // ==================

        // Pengeluaran (Instalment)
        var canvas_BR = document.getElementById('chart_BR');
        var data_BR = {
            labels: labels_BR,
            datasets: [
                {
                    label: "Pengeluaran",
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
                        @json($data_BR[0]['pengeluaran']),
                        @json($data_BR[1]['pengeluaran']),
                        @json($data_BR[2]['pengeluaran']),
                        @json($data_BR[3]['pengeluaran']),
                        @json($data_BR[4]['pengeluaran']),
                        @json($data_BR[5]['pengeluaran']),
                        @json($data_BR[6]['pengeluaran']),
                        @json($data_BR[7]['pengeluaran']),
                        @json($data_BR[8]['pengeluaran']),
                        @json($data_BR[9]['pengeluaran']),
                        @json($data_BR[10]['pengeluaran']),
                        @json($data_BR[11]['pengeluaran']),
                    ],
                }
            ]
        };
        var option_BR = {
            showLines: true,
            onClick: (e, activeEls) => {
                let datasetIndex = activeEls[0].datasetIndex;
                let dataIndex = activeEls[0].index;
                let datasetLabel = e.chart.data.datasets[datasetIndex].label;
                let value = e.chart.data.datasets[datasetIndex].data[dataIndex];
                let label = e.chart.data.labels[dataIndex];
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Pengeluaran Cabang ke Regional',
                    padding: {
                        top: 0,
                        bottom: 0
                    },
                    font: {
                        size: 24,
                        style: 'italic',
                        family: 'Helvetica Neue'
                    }
                }
            }
        };
        var BR = new Chart(canvas_BR,{
            type: 'line',
            data: data_BR,
            options: option_BR,
        });
        // ==================

        // Pemasukan (Payment)
        var canvas_RI = document.getElementById('chart_RI');
        var data_RI = {
            labels: labels_RI,
            datasets: [
                {
                    label: "Pemasukan",
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
                        @json($data_RI[0]['pemasukan']),
                        @json($data_RI[1]['pemasukan']),
                        @json($data_RI[2]['pemasukan']),
                        @json($data_RI[3]['pemasukan']),
                        @json($data_RI[4]['pemasukan']),
                        @json($data_RI[5]['pemasukan']),
                        @json($data_RI[6]['pemasukan']),
                        @json($data_RI[7]['pemasukan']),
                        @json($data_RI[8]['pemasukan']),
                        @json($data_RI[9]['pemasukan']),
                        @json($data_RI[10]['pemasukan']),
                        @json($data_RI[11]['pemasukan']),
                    ],
                }
            ]
        };
        var option_RI = {
            showLines: true,
            onClick: (e, activeEls) => {
                let datasetIndex = activeEls[0].datasetIndex;
                let dataIndex = activeEls[0].index;
                let datasetLabel = e.chart.data.datasets[datasetIndex].label;
                let value = e.chart.data.datasets[datasetIndex].data[dataIndex];
                let label = e.chart.data.labels[dataIndex];
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Pemasukan Regional ke Asuransi',
                    padding: {
                        top: 0,
                        bottom: 0
                    },
                    font: {
                        size: 24,
                        style: 'italic',
                        family: 'Helvetica Neue'
                    }
                }
            }
        };
        var RI = new Chart(canvas_RI,{
            type: 'line',
            data: data_RI,
            options: option_RI,
        });
        //
    </script>
@endpush
