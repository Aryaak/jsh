<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Sisa Agen</title>
</head>
<body>
    <table>
        <tr>
            <th colspan="20"><b>Laporan Sisa Agen</b></th>
        </tr>
        @if ($name !== '')
            <tr>
                <th colspan="20"><b>{{ $name }}</b></th>
            </tr>
        @endif
        <tr>
            <th colspan="20"><b>Periode: {{ $start }} - {{ $end }}</b></th>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th rowspan="2"><b>No.</b></th>
                <th rowspan="2"><b>No. Kwitansi</b></th>
                <th rowspan="2"><b>No. Bond</b></th>
                <th rowspan="2"><b>Nama Principal</b></th>
                <th rowspan="2"><b>Nama Asuransi</b></th>
                <th rowspan="2"><b>Nilai Bond</b></th>
                <th colspan="2"><b>Jangka Waktu</b></th>
                <th rowspan="2"><b>Jml Hari</b></th>
                <th rowspan="2"><b>ASS</b></th>
                <th colspan="3"><b>Setor Kantor</b></th>
                <th colspan="3"><b>Kwitansi</b></th>
                <th rowspan="2"><b>Sisa</b></th>
                <th rowspan="2"><b>Keterangan</b></th>
                <th rowspan="2"><b>Status</b></th>
                <th rowspan="2"><b>Payment</b></th>
            </tr>
            <tr>
                <th><b>Awal</b></th>
                <th><b>Akhir</b></th>
                <th><b>Total Nett Kantor</b></th>
                <th><b>Biaya Admin</b></th>
                <th><b>Total Kantor</b></th>
                <th><b>Service Charge</b></th>
                <th><b>Biaya Admin</b></th>
                <th><b>Premi Bayar</b></th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_insurance_value = $sum_office_net = $sum_admin_charge = $sum_office_total = $sum_service_charge = $sum_receipt_total = $sum_total_charge = 0;
            @endphp
            @forelse($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $d->receipt_number }}</td>
                    <td>{{ $d->bond_number }}</td>
                    <td>{{ $d->principal_name }}</td>
                    <td>{{ $d->insurance_name }}</td>
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
                    <td>{{ $d->office_net }}</td>
                    <td>{{ $d->admin_charge }}</td>
                    <td>{{ $d->office_total }}</td>
                    <td>{{ $d->service_charge }}</td>
                    <td>{{ $d->admin_charge }}</td>
                    <td>{{ $d->receipt_total }}</td>
                    <td>{{ $d->total_charge }}</td>
                    <td>{{ $d->agent_name }}</td>
                    <td>{{ Str::title($d->status) }}</td>
                    <td>{{ $d->payment > 0 ? "Lunas" : "Piutang" }}</td>
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
            @empty
                <tr>
                    <td colspan="20">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="5"></td>
                <td><b>{{ $sum_insurance_value }}</b></td>
                <td colspan="4"></td>
                <td><b>{{ $sum_office_net }}</b></td>
                <td><b>{{ $sum_admin_charge }}</b></td>
                <td><b>{{ $sum_office_total }}</b></td>
                <td><b>{{ $sum_service_charge }}</b></td>
                <td><b>{{ $sum_admin_charge }}</b></td>
                <td><b>{{ $sum_receipt_total }}</b></td>
                <td><b>{{ $sum_total_charge }}</b></td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
