<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Laba</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table tr th, table tr td {
            border: 1px solid black;
            padding: 10px;
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
        <h2>Laporan Laba</h2>
        @if ($name !== '')
            <h2>{{ $name }}</h2>
        @endif
        <h3>Periode: {{ $start }} - {{ $end }}</h3>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Tgl. Transaksi</th>
                <th>Debit</th>
                <th>Kredit</th>
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
                    <td class="center">{{ $loop->iteration }}.</td>
                    <td class="center">{{ $d->title }}</td>
                    <td class="center">{{ Sirius::toLongDateTime($d->paid_at) }}</td>
                    <td class="right">{{ Sirius::toRupiah($d->debit, 2) }}</td>
                    <td class="right">{{ Sirius::toRupiah($d->credit, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="center">Tidak ada data.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="3"></td>
                <td class="right"><b>{{ Sirius::toRupiah($sum_debit, 2) }}</b></td>
                <td class="right"><b>{{ Sirius::toRupiah($sum_credit, 2) }}</b></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
