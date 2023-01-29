<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Pemasukan</title>
</head>
<body>
    <table>
        <tr>
            <th colspan="7"><b>Laporan Pemasukan</b></th>
        </tr>
        @if ($name !== '')
            <tr>
                <th colspan="7"><b>{{ $name }}</b></th>
            </tr>
        @endif
        <tr>
            <th colspan="7"><b>Periode: {{ $start }} - {{ $end }}</b></th>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th><b>No.</b></th>
                <th><b>Tgl. Transaksi</b></th>
                <th><b>No. Kwitansi</b></th>
                <th><b>No. Bond</b></th>
                <th><b>No. Polis</b></th>
                <th><b>Nominal</b></th>
                <th><b>Nama Asuransi</b></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(\Carbon\Carbon::make($d->date)) }}</td>
                    <td>{{ $d->receipt_number }}</td>
                    <td>{{ $d->bond_number }}</td>
                    <td>{{ $d->polish_number }}</td>
                    <td>{{ $d->nominal }}</td>
                    <td>{{ $d->insurance_name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
