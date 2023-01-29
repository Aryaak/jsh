@extends('layouts.main', ['title' => 'Draf Surety Bond'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Draf Surety Bond">
        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>No. Kwitansi</th>
                    <th>No. Bond</th>
                    <th>No. Polis</th>
                    <th>Status BG</th>
                    <th>Status Sinkron</th>
                    <th>Tanggal</th>
                    <th width="105px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td><x-badge face="label-primary">Tes</x-badge></td>
                <td><x-badge face="label-success">Sinkron</x-badge></td>
                <td>Tes</td>
                <td>
                    <x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-show" title="Detail Surety Bond" size="fullscreen" darkBody>
        <div class="row mb-4">
            <div class="col-12 text-center">
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Surety Bond</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="w-100 mb-4">
                    <x-card header="1. Data" smallHeader>
                        <div class="mb-3">
                            <x-form-label>No. Kwitansi</x-form-label>
                            <div id="show-receipt-number">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>No. Bond</x-form-label>
                            <div id="show-guarantee-number">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>No. Polis</x-form-label>
                            <div id="show-polish-number">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Nama Agen</x-form-label>
                            <div id="show-agent">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Nama Asuransi</x-form-label>
                            <div id="show-insurance">-</div>
                        </div>
                        <div>
                            <x-form-label>Jenis Jaminan</x-form-label>
                            <div id="show-insurance-type">-</div>
                        </div>
                    </x-card>
                </div>
                <div class="w-100 mb-4">
                    <x-card header="4. Obligee" smallHeader>
                        <div class="mb-3">
                            <x-form-label>Nama</x-form-label>
                            <div id="show-obligee-name">-</div>
                        </div>
                        <div>
                            <x-form-label>Alamat</x-form-label>
                            <div id="show-obligee-address">-</div>
                        </div>
                    </x-card>
                </div>
            </div>
            <div class="col-md-4">
                <div class="w-100 mb-4">
                    <x-card header="2. Principal" smallHeader>
                        <div class="mb-3">
                            <x-form-label>Nama</x-form-label>
                            <div id="show-principal-name">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Alamat</x-form-label>
                            <div id="show-principal-address">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Nama PIC</x-form-label>
                            <div id="show-pic-name">-</div>
                        </div>
                        <div>
                            <x-form-label>Jabatan PIC</x-form-label>
                            <div id="show-pic-position">-</div>
                        </div>
                    </x-card>
                </div>
                <div class="w-100 mb-3">
                    <x-card header="5. Tambahan" smallHeader>
                        <div class="mb-3">
                            <x-form-label>Service Charge</x-form-label>
                            <div id="show-service-charge">Rp0,-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Biaya Admin</x-form-label>
                            <div id="show-admin-charge">Rp0,-</div>
                        </div>
                        <div>
                            <x-form-label>Premi Bayar</x-form-label>
                            <div id="show-premi-charge">Rp0,-</div>
                        </div>
                    </x-card>
                </div>
            </div>
            <div class="col-md-4">
                <div class="w-100 mb-4">
                    <x-card header="3. Jaminan" smallHeader>
                        <div class="mb-3">
                            <x-form-label>Nilai Kontrak</x-form-label>
                            <div id="show-contract-value">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Nilai Jaminan</x-form-label>
                            <div id="show-insurance-value">-</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <div>
                                    <x-form-label>Jangka Awal</x-form-label>
                                    <div id="show-start-date">-</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <x-form-label>Jangka Akhir</x-form-label>
                                    <div id="show-end-date">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Batas Toleransi Jatuh Tempo</x-form-label>
                            <div id="show-due-day-tolerance">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Jumlah Hari</x-form-label>
                            <div id="show-day-count">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Nama Proyek</x-form-label>
                            <div id="show-project-name">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>Dokumen Pendukung</x-form-label>
                            <div id="show-document-title">-</div>
                        </div>
                        <div class="mb-3">
                            <x-form-label>No. Dokumen Pendukung</x-form-label>
                            <div id="show-document-number">-</div>
                        </div>
                        <div>
                            <x-form-label>Tanggal Dokumen Pendukung</x-form-label>
                            <div id="show-document-expired-at">-</div>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 text-center">
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Surety Bond</div>
            </div>
        </div>
        <div class="row mx-1">
            <x-card class="p-1">
                <div class="d-flex flex-column flex-lg-row">
                    <div class="border p-0" style="position: relative; flex: 100%;">
                        <div class="border-bottom p-1 text-center">30</div>
                        <div class="border-bottom p-1 text-center">Character</div>
                        <div class="px-3 pt-3 pb-5">
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-1" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-2" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-3" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-4" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-5" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-6" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                        </div>
                        <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Sub Total Nilai Character:</div>
                                <div><b>20</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="border p-0" style="position: relative; flex: 100%;">
                        <div class="border-bottom p-1 text-center">20</div>
                        <div class="border-bottom p-1 text-center">Capacity</div>
                        <div class="px-3 pt-3 pb-5">
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-7" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-8" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-9" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-10" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-11" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                        </div>
                        <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Sub Total Nilai Capacity:</div>
                                <div><b>17</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="border p-0" style="position: relative; flex: 100%;">
                        <div class="border-bottom p-1 text-center">20</div>
                        <div class="border-bottom p-1 text-center">Capital</div>
                        <div class="px-3 pt-3 pb-5">
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-12" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-13" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-14" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-15" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-16" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                        </div>
                        <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Sub Total Nilai Capital:</div>
                                <div><b>16</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="border p-0" style="position: relative; flex: 100%;">
                        <div class="border-bottom p-1 text-center">17</div>
                        <div class="border-bottom p-1 text-center">Condition</div>
                        <div class="px-3 pt-3 pb-5">
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-17" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-18" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-19" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-23" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-24" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-25" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-26" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-27" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-28" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                        </div>
                        <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Sub Total Nilai Condition:</div>
                                <div><b>16</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="border p-0" style="position: relative; flex: 100%;">
                        <div class="border-bottom p-1 text-center">13</div>
                        <div class="border-bottom p-1 text-center">Collateral</div>
                        <div class="px-3 pt-3 pb-5">
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-29" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-30" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-31" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-32" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                            <div class="mb-3">
                                <div class="fw-bold">Kategori</div>
                                <x-form-check id="show-scoring-score-20" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-21" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                                <x-form-check id="show-scoring-score-22" name="scoring[score[]]" value="10" disabled>Name</x-form-check>
                            </div>
                        </div>
                        <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Sub Total Nilai Prospect:</div>
                                <div><b>1</b></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">Total Nilai: <b>69</b></div>
            </x-card>
        </div>

        @slot('footer')
            <x-button class="btn-decline" face="danger" icon="bx bx-x">Tolak</x-button>
            <x-button class="btn-approve" face="success" icon="bx bx-check">Setuju</x-button>
        @endslot
    </x-modal>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $("#table").DataTable()
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Draf Surety Bond?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })

        $(document).on('click', '.btn-approve', function () {
            // Delete
            Confirm.fire({
                title: "Yakin ingin menyetujui Draf Surety Bond?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })

        $(document).on('click', '.btn-decline', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menolak Draf Surety Bond?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
