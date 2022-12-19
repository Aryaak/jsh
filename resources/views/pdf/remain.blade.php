<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Sisa Cabang</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table tr th, table tr td {
            border: 1px solid black;
            padding: 2px;
            font-size: .43em;
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
    <h4>Laporan Sisa Cabang</h4>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">No. Kwitansi</th>
                <th rowspan="2">No. Bond</th>
                <th rowspan="2">Nama Principals</th>
                <th rowspan="2">Nilai Bond</th>
                <th colspan="2">Jangka Waktu</th>
                <th rowspan="2">Jml Hari</th>
                <th rowspan="2">ASS</th>
                <th colspan="3">Setor Kantor</th>
                <th colspan="3">Kwitansi</th>
                <th rowspan="2">Sisa</th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Payment</th>
            </tr>
            <tr>
                <th>Awal</th>
                <th>Akhir</th>
                <th>Total Nett Kantor</th>
                <th>Biaya Admin</th>
                <th>Total Kantor</th>
                <th>Service Charge</th>
                <th>Biaya Admin</th>
                <th>Premi Bayar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_insurance_value = $sum_office_net = $sum_admin_charge = $sum_office_total = $sum_service_charge = $sum_receipt_total = $sum_total_charge = 0;
            @endphp
            @foreach ($data as $d)
                <tr>
                    <td class="center">{{ $loop->iteration }}.</td>
                    <td>{{ $d->receipt_number }}</td>
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
                    <td class="right">{{ number_format($d->office_net, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->admin_charge, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->office_total, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->service_charge, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->admin_charge, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->receipt_total, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($d->total_charge, 2, ',', '.') }}</td>
                    <td>{{ $d->agent_name }}</td>
                    <td class="center">{{ Str::title($d->status) }}</td>
                    <td class="center">{{ $d->payment > 0 ? "Lunas" : "Piutang" }}</td>
                </tr>
                @php
                    $sum_insurance_value += $d->insurance_value;
                    $sum_office_net += $d->office_net;
                    $sum_admin_charge += $d->admin_charge;
                    $sum_office_total += $d->office_total;
                    $sum_service_charge += $d->service_charge;
                    $sum_receipt_total += $d->receipt_total;
                    $sum_total_charge += $d->total_charge;
                @endphp
            @endforeach
            <tr>
                <td colspan="4"></td>
                <td class="right"><b>{{ number_format($sum_insurance_value, 2, ',', '.') }}</b></td>
                <td colspan="4"></td>
                <td class="right"><b>{{ number_format($sum_office_net, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_admin_charge, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_office_total, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_service_charge, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_admin_charge, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_receipt_total, 2, ',', '.') }}</b></td>
                <td class="right"><b>{{ number_format($sum_total_charge, 2, ',', '.') }}</b></td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>