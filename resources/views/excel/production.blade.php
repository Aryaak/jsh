<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Produksi</title>
</head>
<body>

    <table>
        <tr>
            <th colspan="18"><b>Laporan Produksi</b></th>
        </tr>
        @if ($name !== '')
            <tr>
                <th colspan="18"><b>{{ $name }}</b></th>
            </tr>
        @endif
        <tr>
            <th colspan="18"><b>Periode: {{ $start }} - {{ $end }}</b></th>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th rowspan="2"><b>No.</b></th>
                <th rowspan="2"><b>No. Bond</b></th>
                <th rowspan="2"><b>Nama Principals</b></th>
                <th rowspan="2"><b>Nilai Bond</b></th>
                <th colspan="2"><b>Jangka Waktu</b></th>
                <th rowspan="2"><b>Jml Hari</b></th>
                <th rowspan="2"><b>ASS</b></th>
                <th colspan="4"><b>Setor Asuransi</b></th>
                <th colspan="3"><b>Setor Kantor</b></th>
                <th rowspan="2"><b>Laba</b></th>
                <th rowspan="2"><b>Keterangan</b></th>
                <th rowspan="2"><b>Status</b></th>
            </tr>
            <tr>
                <th><b>Awal</b></th>
                <th><b>Akhir</b></th>
                <th><b>Nett Premi</b></th>
                <th><b>Biaya Polis</b></th>
                <th><b>Materai</b></th>
                <th><b>Total Nett Premi</b></th>
                <th><b>Total Nett Kantor</b></th>
                <th><b>Biaya Admin</b></th>
                <th><b>Total Kantor</b></th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_insurance_value = $sum_insurance_net = $sum_insurance_polish_cost = $sum_insurance_stamp_cost = $sum_insurance_nett_total = $sum_office_net = $sum_admin_charge = $sum_office_total = $sum_profit = 0;
            @endphp
            @forelse ($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $d->bond_number }}</td>
                    <td>{{ $d->principal_name }}</td>
                    <td>{{ $d->insurance_value }}</td>
                    <td>{{ \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(\Carbon\Carbon::make($d->start_date)) }}</td>
                    <td>{{ \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(\Carbon\Carbon::make($d->end_date)) }}</td>
                    <td>
                        @if ($d->due_day_tolerance > 0)
                            {{ $d->day_count - $d->due_day_tolerance }} (+{{ $d->due_day_tolerance }})
                        @else
                            {{ $d->day_count }}
                        @endif
                    </td>
                    <td>{{ $d->code }}</td>
                    <td>{{ $d->insurance_net }}</td>
                    <td>{{ $d->insurance_polish_cost }}</td>
                    <td>{{ $d->insurance_stamp_cost }}</td>
                    <td>{{ $d->insurance_nett_total }}</td>
                    <td>{{ $d->office_net }}</td>
                    <td>{{ $d->admin_charge }}</td>
                    <td>{{ $d->office_total }}</td>
                    <td>{{ $d->profit }}</td>
                    <td>{{ $d->agent_name }}</td>
                    <td>{{ Str::title($d->status) }}</td>
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
                    <td colspan="18">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="3"></td>
                <td><b>{{ $sum_insurance_value }}</b></td>
                <td colspan="4"></td>
                <td><b>{{ $sum_insurance_net }}</b></td>
                <td><b>{{ $sum_insurance_polish_cost }}</b></td>
                <td><b>{{ $sum_insurance_stamp_cost }}</b></td>
                <td><b>{{ $sum_insurance_nett_total }}</b></td>
                <td><b>{{ $sum_office_net }}</b></td>
                <td><b>{{ $sum_admin_charge }}</b></td>
                <td><b>{{ $sum_office_total }}</b></td>
                <td><b>{{ $sum_profit }}</b></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
