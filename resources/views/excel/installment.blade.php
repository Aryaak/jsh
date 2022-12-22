<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Cicil Cabang</title>
</head>
<body>
    <table>
        <tr>
            <th colspan="6"><b>Laporan Cicil Cabang</b></th>
        </tr>
        @if ($name !== '')
            <tr>
                <th colspan="6"><b>{{ $name }}</b></th>
            </tr>
        @endif
        <tr>
            <th colspan="6"><b>Periode: {{ date('Y') }}</b></th>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th><b>Tgl Setor</b></th>
                <th><b>Jumlah Polis</b></th>
                <th><b>Jumlah Tagihan</b></th>
                <th><b>Tgl Titipan</b></th>
                <th><b>Jumlah Titipan</b></th>
                <th><b>Keterangan</b></th>
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
                    <td>{{ \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(\Carbon\Carbon::make($d->tgl_setor)) }}</td>
                    <td>{{ $d->jumlah_polis }}</td>
                    <td>{{ $d->jumlah_tagihan }}</td>
                    <td>{{ \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel(\Carbon\Carbon::make($d->tgl_titipan)) }}</td>
                    <td>{{ $d->jumlah_titipan }}</td>
                    <td>{{ $d->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @php
        $kekurangan = $sum_tagihan - $sum_titipan;
    @endphp
    <table>
        <tr>
            <td></td>
            <td>Tagihan</td>
            <td>:</td>
            <td colspan="2">{{ $sum_tagihan }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Titipan</td>
            <td>:</td>
            <td colspan="2">{{ $sum_titipan }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><b>Kekurangan</b></td>
            <td><b>:</b></td>
            <td colspan="2"><b>{{ $kekurangan }}</b></td>
            <td></td>
        </tr>
    </table>
</body>
</html>
