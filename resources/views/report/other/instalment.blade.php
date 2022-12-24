@extends('layouts.main', ['title' => 'Laporan Cicil Cabang'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card class="mb-4">
        <div class="row">
            <div class="col-6">
                <x-button id="print-pdf" class="w-100" icon='bx bxs-printer' face="danger">Cetak PDF</x-button>
            </div>
            <div class="col-6 mt-s-3">
                <x-button id="print-excel" class="w-100" icon='bx bxs-printer' face="success">Cetak Excel</x-button>
            </div>
        </div>
    </x-card>

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
            @php
                $sum_tagihan = $sum_titipan = 0;
            @endphp
            @forelse ($rows as $row)
                @php
                    $sum_tagihan += (float)$row->jumlah_tagihan;
                    $sum_titipan += (float)$row->jumlah_titipan;
                @endphp
                <tr>
                    <td class="text-center">{{ $row->tgl_setor }}</td>
                    <td class="text-right">{{ Sirius::toRupiah((float)$row->jumlah_polis) }}</td>
                    <td class="text-right">{{ Sirius::toRupiah((float)$row->jumlah_tagihan) }}</td>
                    <td class="text-center">{{ $row->tgl_titipan }}</td>
                    <td class="text-right">{{ Sirius::toRupiah((float)$row->jumlah_titipan) }}</td>
                    <td>{{ $row->keterangan }}</td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Tidak ada data.</td>
                </tr>
            @endforelse
        </x-table>
        @php
            $kekurangan = $sum_tagihan - $sum_titipan;
        @endphp
        <br>
        <div class="d-flex" style="flex-grow: 1fr">
            <div class="w-100"></div>
            <div class="w-100">
                <div>Tagihan</div>
                <div>Titipan</div>
                <hr>
                <div class="fw-bold">Kekurangan</div>
            </div>
            <div class="text-right w-100">
                <div>:</div>
                <div>:</div>
                <hr>
                <div class="fw-bold">:</div>
            </div>
            <div class="text-right w-100">
                <div>{{ Sirius::toRupiah($sum_tagihan) }}</div>
                <div>{{ Sirius::toRupiah($sum_titipan) }}</div>
                <hr>
                <div class="fw-bold">{{ Sirius::toRupiah($kekurangan) }}</div>
            </div>
            <div class="w-100"></div>
        </div>
    </x-card>
@endsection

@push('js')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $("#print-pdf").click(function () {
            window.open('{{ route($global->currently_on.'.other-reports.print.installment', ['print' => 'pdf', 'regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}');
        })

        $("#print-excel").click(function () {
            window.open('{{ route($global->currently_on.'.other-reports.print.installment', ['print' => 'excel', 'regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}');
        })
    </script>
@endpush
