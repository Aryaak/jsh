@extends('layouts.main', ['title' => 'Pembayaran'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Pembayaran">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Pembayaran</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Waktu Bayar</th>
                    <th>Dari Cabang</th>
                    <th>Ke Agen</th>
                    <th>Nominal Bayar</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
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
                <x-form-label required>Nominal Bayar</x-form-label>
                <div id="create-nominal">-</div>
            </div>
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
            <b>Ke Agen</b>: <br>
            <span id="show-agent">-</span>
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
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $("#table").DataTable()
            $("#create-month, #create-year").select2({dropdownParent: $('#modal-create')})
            $("#create-branch-id, #create-agent-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-branch-id, #edit-agent-id").select2({dropdownParent: $('#modal-edit')})
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
