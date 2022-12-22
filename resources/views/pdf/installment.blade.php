<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Cicil Cabang</title>
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

        table.no-style tr th, table.no-style tr td {
            border: none!important;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .w-25 {
            width: 25% !important;
        }
    </style>
</head>
<body>
    <div class="center">
        <h2>Laporan Cicil Cabang</h2>
        @if ($name !== '')
            <h2>{{ $name }}</h2>
        @endif
        <h3>Periode: {{ date('Y') }}</h3>
    </div>
    <br>
    <table>
        <thead>
            <tr class="center">
                <th>Tgl Setor</th>
                <th>Jumlah Polis</th>
                <th>Jumlah Tagihan</th>
                <th>Tgl Titipan</th>
                <th>Jumlah Titipan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_tagihan = $sum_titipan = 0;
            @endphp
            @forelse ($data as $d)
                @php
                    $sum_tagihan += $d->jumlah_tagihan;
                    $sum_titipan += $d->jumlah_titipan;
                @endphp
                <tr>
                    <td class="center">{{ Sirius::toLongDate($d->tgl_setor) }}</td>
                    <td class="right">{{ Sirius::toRupiah($d->jumlah_polis) }}</td>
                    <td class="right">{{ Sirius::toRupiah($d->jumlah_tagihan) }}</td>
                    <td class="center">{{ Sirius::toLongDate($d->tgl_titipan) }}</td>
                    <td class="right">{{ Sirius::toRupiah($d->jumlah_titipan) }}</td>
                    <td>{{ $d->keterangan }}</td>
                </tr>
            @empty
                <tr class="center">
                    <td colspan="6">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @php
        $kekurangan = $sum_tagihan - $sum_titipan;
    @endphp

    <table class="no-style">
        <tr>
            <td class="w-25"></td>
            <td>Tagihan</td>
            <td>:</td>
            <td class="right">{{ Sirius::toRupiah($sum_tagihan) }}</td>
            <td class="w-25"></td>
        </tr>
        <tr>
            <td></td>
            <td>Titipan</td>
            <td>:</td>
            <td class="right">{{ Sirius::toRupiah($sum_titipan) }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><b>Kekurangan</b></td>
            <td><b>:</b></td>
            <td class="right"><b>{{ Sirius::toRupiah($kekurangan) }}</b></td>
            <td></td>
        </tr>
    </table>
</body>
</html>
