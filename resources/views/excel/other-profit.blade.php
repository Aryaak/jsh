<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Laba</title>
</head>
<body>
    <table>
        <tr>
            <th colspan="5"><b>Laporan Laba</b></th>
        </tr>
        @if ($name !== '')
            <tr>
                <th colspan="5"><b>{{ $name }}</b></th>
            </tr>
        @endif
        <tr>
            <th colspan="5"><b>Periode: {{ $start }} - {{ $end }}</b></th>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th><b>No.</b></th>
                <th><b>Judul</b></th>
                <th><b>Tgl. Transaksi</b></th>
                <th><b>Debit</b></th>
                <th><b>Kredit</b></th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_debit = $sum_credit = 0;
            @endphp
            @forelse ($data as $d)
                @php
                    $sum_debit += $d->debit;
                    $sum_credit += $d->credit;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $d->title }}</td>
                    <td>{{ \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(\Carbon\Carbon::make($d->paid_at)) }}</td>
                    <td>{{ $d->debit }}</td>
                    <td>{{ $d->credit }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="3"></td>
                <td><b>{{ $sum_debit }}</b></td>
                <td><b>{{ $sum_credit }}</b></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
