@extends('layouts.main', ['title' => 'Pembayaran'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Total Hutang" class="mb-3">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-payable" size="sm" icon="bx bx-search" face="info">Detail Hutang</x-button>
        @endslot
        <div class="h1 text-end text-danger fw-bold mb-0">
            Rp10.000.000,-
        </div>
    </x-card>

    <x-card header="Daftar Pembayaran">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Pembayaran</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Waktu Bayar</th>
                    <th>Nominal Bayar</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Rp100.000.000,-</td>
                <td>
                    <x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    @php
        $months = [];
        foreach (range(1, 12) as $month) {
            $months[$month] = Sirius::longMonth($month);
        }

        $years = [];
        foreach (range(date('Y'), 2000) as $year) {
            $years[$year] = $year;
        }
    @endphp

    <x-modal id="modal-create" title="Tambah Pembayaran" size="fullscreen">
        <x-form id="form-create" method="post">
            <x-form-input label="Waktu Bayar" id="create-datetime" name="datetime" type="datetime-local" class="mb-3" required />
            <x-form-select label="Bulan" id="create-month" name="month" class="mb-3" :options="$months" value="{{ date('m') }}" required />
            <x-form-select label="Tahun" id="create-year" name="year" class="mb-3" :options="$years" value="{{ date('Y') }}" required />
            <div class="mb-3">
                <x-form-label>Total Hutang</x-form-label>
                <div id="create-payable" class="text-danger">Rp0,-</div>
            </div>
            <div class="mb-3">
                <x-form-label>Total Tagihan</x-form-label>
                <div id="create-bill">Rp0,-</div>
            </div>
            <x-form-input label="Nominal Bayar" id="create-nominal" name="nominal" prefix="Rp" suffix=",-" class-input="to-rupiah" class="mb-3" required />
            <x-form-textarea label="Keterangan" id="create-desc" name="desc" />
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Pembayaran">
        <div class="border-bottom pb-2 mb-2">
            <b>Waktu Bayar</b>: <br>
            <span id="show-datetime">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Bulan</b>: <br>
            <span id="show-month">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Tahun</b>: <br>
            <span id="show-year">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nominal Bayar</b>: <br>
            <span id="show-nominal">Rp0,-</span>
        </div>
        <div>
            <b>Keterangan</b>: <br>
            <span id="show-desc">-</span>
        </div>
    </x-modal>

    <x-modal id="modal-payable" title="Detail Hutang" size="fullscreen">
        <x-table id="payable-table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Total Hutang</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>2022</td>
                <td>November</td>
                <td>Rp10.000.000,-</td>
            </tr>
        </x-table>
    </x-modal>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $("#table").DataTable()
            $("#create-month, #create-year").select2({dropdownParent: $('#modal-create')})
            $("#create-branch-id, #create-regional-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-branch-id, #edit-regional-id").select2({dropdownParent: $('#modal-edit')})
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Pembayaran?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
