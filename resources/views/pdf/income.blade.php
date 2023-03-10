<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Pemasukan</title>
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
        <h2>Laporan Pemasukan</h2>
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
                <th>Tgl. Transaksi</th>
                <th>No. Kwitansi</th>
                <th>No. Bond</th>
                <th>No. Polis</th>
                <th>Nominal</th>
                <th>Nama Asuransi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $d)
                <tr>
                    <td class="center">{{ $loop->iteration }}.</td>
                    <td>{{ Sirius::toLongDateTime($d->date) }}</td>
                    <td class="center">{{ $d->receipt_number }}</td>
                    <td class="center">{{ $d->bond_number }}</td>
                    <td class="center">{{ $d->polish_number }}</td>
                    <td class="right">{{ Sirius::toRupiah($d->nominal) }}</td>
                    <td>{{ $d->insurance_name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
