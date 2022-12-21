@extends('layouts.main', ['title' => 'Laporan'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    {{-- Table --}}
    <x-card>
        <x-table id="table">
            @slot('thead')
                <tr class="text-center">
                    <th>TGL SETOR</th>
                    <th>JUMLAH POLIS</th>
                    <th>JUMLAH TAGIHAN</th>
                    <th>TGL TITIPAN</th>
                    <th>JUMLAH TITIPAN</th>
                    <th>KETERANGAN</th>
                </tr>
            @endslot
            @foreach ($rows as $row)
                <tr class="text-center">
                    <td>{{ $row->tgl_setor }}</td>
                    <td>{{ $row->jumlah_polis }}</td>
                    <td>{{ $row->jumlah_tagihan }}</td>
                    <td>{{ $row->tgl_titipan }}</td>
                    <td>{{ $row->jumlah_titipan }}</td>
                    <td>{{ $row->keterangan }}</td>
                </tr>
            @endforeach
        </x-table>
    </x-card>
@endsection

@push('js')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

    </script>
@endpush
