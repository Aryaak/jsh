<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Keuangan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table tr th, table tr td {
            border: 1px solid black;
            padding: 3px;
            font-size: .6em;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="center">
        <h5>Laporan Keuangan</h5>
        @if ($name !== '')
            <h5>{{ $name }}</h5>
        @endif
        <h6>Periode: {{ $start }} - {{ $end }}</h6>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Tgl. Bayar</th>
                <th rowspan="2">No. Bond</th>
                <th rowspan="2">Nama Principals</th>
                <th rowspan="2">Nilai Bond</th>
                <th colspan="2">Jangka Waktu</th>
                <th rowspan="2">Jml Hari</th>
                <th rowspan="2">ASS</th>
                <th colspan="4">Setor Asuransi</th>
                <th colspan="3">Setor Kantor</th>
                <th rowspan="2">Laba</th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2">Status</th>
            </tr>
            <tr>
                <th>Awal</th>
                <th>Akhir</th>
                <th>Nett Premi</th>
                <th>Biaya Polis</th>
                <th>Materai</th>
                <th>Total Nett Premi</th>
                <th>Total Nett Kantor</th>
                <th>Biaya Admin</th>
                <th>Total Kantor</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_insurance_value = $sum_insurance_net = $sum_insurance_polish_cost = $sum_insurance_stamp_cost = $sum_insurance_nett_total = $sum_office_net = $sum_admin_charge = $sum_office_total = $sum_profit = 0;
            @endphp
            @forelse ($data as $d)
                <tr>
                    <td class="center">{{ $loop->iteration }}.</td>
                    <td class="center">{{ date('d/m/y', strtotime($d->paid_at)) }}</td>
                    <td>{{ $d->bond_number }}</td>
                    <td>{{ $d->principal_name }}</td>
                    <td class="right">{{ number_format($d->insurance_value, 2, ',', '.') }}</td>
                    <td class="center">{{ date('d/m/y', strtotime($d->start_date)) }}</td>
                    <td class="center">{{ date('d/m/y', strtotime($d->end_date)) }}</td>
                    <td class="center">
                        @if ($d->due_day_tolerance > 0)
                            {{ $d->day_count - $d->due_day_tolerance }} (+{{ $d->due_day_tolerance }})
                        @else
                            {{ $d->day_count }}
                        @endif
                    </td>
                    <td class="center">{{ $d->code }}</td>
                    <td class="right">{{ number_format($d->insurance_net, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->insurance_polish_cost, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->insurance_stamp_cost, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->insurance_nett_total, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->office_net, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->admin_charge, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->office_total, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->profit, 2, ',', '.') }}</td>
                    <td>{{ $d->agent_name }}</td>
                    <td class="center">{{ Str::title($d->status) }}</td>
                </tr>
                @php
                    $sum_insurance_value += $d->insurance_value;
                    $sum_insurance_net += $d->insurance_net;
                    $sum_insurance_polish_cost += $d->insurance_polish_cost;
                    $sum_insurance_stamp_cost += $d->insurance_stamp_cost;
                    $sum_insurance_nett_total += $d->insurance_nett_total;
                    $sum_office_net += $d->office_net;
                    $sum_admin_charge += $d->admin_charge;
                    $sum_office_total += $d->office_total;
                    $sum_profit += $d->profit;
                @endphp
            @empty
                <tr>
                    <td colspan="19" class="center">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="4"></td>
                <td class="right"><b>{{ number_format($sum_insurance_value, 2, ',', '.') }}</b></td>
                <td colspan="4"></td>
                <td class="right"><b>{{ number_format($sum_insurance_net, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_insurance_polish_cost, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_insurance_stamp_cost, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_insurance_nett_total, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_office_net, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_admin_charge, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_office_total, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_profit, 2, ',', '.') }}</b></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
