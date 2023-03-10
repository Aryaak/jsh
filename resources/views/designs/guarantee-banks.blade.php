@extends('layouts.main', ['title' => 'Bank Garansi'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Bank Garansi">
        @slot('headerAction')
            <div>
                <x-button link="" size="sm" icon="bx bx-search" face="info">Lihat Draft<x-badge face="danger" class="ms-2">2</x-badge></x-button>
                <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Bank Garansi</x-button>
            </div>
        @endslot

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
                    <x-button type="icon" class="btn-sync" size="sm"  icon="bx bx-refresh" face="warning">Sinkronkan</x-button>
                    <x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Bank Garansi" size="fullscreen" darkBody>
        <x-form id="form-create" method="post">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Bank Garansi</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="1. Data" smallHeader>
                            <x-form-input label="No. Kwitansi" id="create-receipt-number" name="receiptNumber" class="mb-3" required />
                            <x-form-input label="No. Bond" id="create-guarantee-number" name="guaranteeNumber" class="mb-3" />
                            <x-form-input label="No. Polis" id="create-polish-number" name="polishNumber" class="mb-3" />
                            <x-form-select label="Nama Agen" id="create-agent-id" :options="[]" name="agentId" class="mb-3" required/>
                            <x-form-select label="Nama Bank" id="create-bank-id" :options="[]" name="bankId" class="mb-3" required/>
                            <x-form-select label="Nama Asuransi" id="create-insurance-id" :options="[]" name="insuranceId" class="mb-3" required/>
                            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id" :options="[]" name="insuranceType" required/>
                        </x-card>
                    </div>
                    <div class="w-100 mb-4">
                        <x-card header="4. Obligee" smallHeader>
                            <x-form-select label="Nama" id="create-obligee-id" :options="[]" name="obligeeId" class="mb-3" required/>
                            <div>
                                <x-form-label>Alamat</x-form-label>
                                <div id="create-obligee-address">-</div>
                            </div>
                        </x-card>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="2. Principal" smallHeader>
                            <x-form-select label="Nama" id="create-principal-id" :options="[]" name="principalId" class="mb-3" required/>
                            <div class="mb-3">
                                <x-form-label>Alamat</x-form-label>
                                <div id="create-principal-address">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Nama PIC</x-form-label>
                                <div id="create-pic-name">-</div>
                            </div>
                            <div>
                                <x-form-label>Jabatan PIC</x-form-label>
                                <div id="create-pic-position">-</div>
                            </div>
                        </x-card>
                    </div>
                    <div class="w-100 mb-3">
                        <x-card header="5. Tambahan" smallHeader>
                            <x-form-input label="Service Charge" id="create-service-charge" name="serviceCharge" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" />
                            <x-form-input label="Biaya Admin" id="create-admin-charge" name="adminCharge" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" />
                            <div>
                                <x-form-label>Premi Bayar</x-form-label>
                                <div id="create-premi-charge">Rp0,-</div>
                            </div>
                        </x-card>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="3. Jaminan" smallHeader>
                            <x-form-input label="Nilai Kontrak" id="create-contract-value" name="contractValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                            <x-form-input label="Nilai Jaminan" id="create-insurance-value" name="insuranceValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                            <div class="row">
                                <div class="col-sm-6">
                                    <x-form-input label="Jangka Awal" id="create-start-date" name="startDate" type="date" class="mb-3" />
                                </div>
                                <div class="col-sm-6">
                                    <x-form-input label="Jangka Akhir" id="create-end-date" name="endDate" type="date" class="mb-3" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Batas Toleransi Jatuh Tempo</x-form-label>
                                <div class="d-flex flex-xl-row flex-column gap-2">
                                    <x-form-check id="create-due-day-tolerance-0" name='dueDayTolerance' value="0" type="radio" inline checked>0 Hari</x-form-check>
                                    <x-form-check id="create-due-day-tolerance-1" name='dueDayTolerance' value="1" type="radio" inline>1 Hari</x-form-check>
                                    <x-form-check id="create-due-day-tolerance-2" name='dueDayTolerance' value="2" type="radio" inline>2 Hari</x-form-check>
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-form-label required>Jumlah Hari</x-form-label>
                                <input type="hidden" id="create-day-count-input" name="dayCount" value="0">
                                <div><span class="create-day-count">0</span> Hari</div>
                            </div>
                            <x-form-input label="Nama Proyek" id="create-project-name" name="projectName" class="mb-3" required />
                            <x-form-input label="Dokumen Pendukung" id="create-document-title" name="documentTitle" class="mb-3" />
                            <x-form-input label="No. Dokumen Pendukung" id="create-document-number" name="documentNumber" class="mb-3" />
                            <x-form-input label="Tanggal Dokumen Pendukung" id="create-document-expired-at" name="documentExpiredAt" type="date" />
                        </x-card>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Bank Garansi</div>
                </div>
            </div>
            <div class="row mx-1">
                <x-card class="p-1">
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">30</div>
                            <div class="border-bottom p-1 text-center">Character</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-1" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-2" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-3" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-4" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-5" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-6" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Character:</div>
                                    <div><b>20</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">20</div>
                            <div class="border-bottom p-1 text-center">Capacity</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-7" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-8" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-9" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-10" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-11" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Capacity:</div>
                                    <div><b>17</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">20</div>
                            <div class="border-bottom p-1 text-center">Capital</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-12" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-13" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-14" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-15" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-16" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Capital:</div>
                                    <div><b>16</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">17</div>
                            <div class="border-bottom p-1 text-center">Condition</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-17" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-18" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-19" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-23" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-24" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-25" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-26" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-27" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-28" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Condition:</div>
                                    <div><b>16</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">13</div>
                            <div class="border-bottom p-1 text-center">Collateral</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-29" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-30" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-31" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-32" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="create-scoring-score-20" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-21" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="create-scoring-score-22" name="scoring[score[]]" value="10">Name</x-form-check>
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
                </x-card>
            </div>
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Bank Garansi" size="fullscreen" darkBody>
        <div class="row mb-4">
            <div class="col-12 text-center">
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Bank Garansi</div>
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
                            <x-form-label>Nama Bank</x-form-label>
                            <div id="show-bank">-</div>
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
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Bank Garansi</div>
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
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>Total Nilai: <b>69</b></div>
                            <div>
                                <x-button face='secondary' icon="bx bxs-printer">Cetak Scoring</x-button>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button class="btn-status-histories" data-bs-target="#modal-status-histories" data-bs-toggle="modal" data-bs-dismiss="modal" face='secondary' icon="bx bx-history">Riwayat Status</x-button>
                <x-button id="btn-paid-off-payment" data-id="" face="success" icon="bx bxs-badge-check">Lunasi Pembayaran</x-button>
                    <div>
                        <x-button class="btn-edit-status" data-bs-target="#modal-edit-status" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah Status</x-button>
                        <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
                    </div>
            </div>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Bank Garansi" size="fullscreen" darkBody>
        <x-form id="form-edit" method="put">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Bank Garansi</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="1. Data" smallHeader>
                            <x-form-input label="No. Kwitansi" id="edit-receipt-number" name="receiptNumber" class="mb-3" required />
                            <x-form-input label="No. Bond" id="edit-guarantee-number" name="guaranteeNumber" class="mb-3" />
                            <x-form-input label="No. Polis" id="edit-polish-number" name="polishNumber" class="mb-3" />
                            <x-form-select label="Nama Agen" id="edit-agent-id" :options="[]" name="agentId" class="mb-3" required/>
                            <x-form-select label="Nama Bank" id="edit-bank-id" :options="[]" name="bankId" class="mb-3" required/>
                            <x-form-select label="Nama Asuransi" id="edit-insurance-id" :options="[]" name="insuranceId" class="mb-3" required/>
                            <x-form-select label="Jenis Jaminan" id="edit-insurance-type-id" :options="[]" name="insuranceType" required/>
                        </x-card>
                    </div>
                    <div class="w-100 mb-4">
                        <x-card header="4. Obligee" smallHeader>
                            <x-form-select label="Nama" id="edit-obligee-id" :options="[]" name="obligeeId" class="mb-3" required/>
                            <div>
                                <x-form-label>Alamat</x-form-label>
                                <div id="edit-obligee-address">-</div>
                            </div>
                        </x-card>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="2. Principal" smallHeader>
                            <x-form-select label="Nama" id="edit-principal-id" :options="[]" name="principalId" class="mb-3" required/>
                            <div class="mb-3">
                                <x-form-label>Alamat</x-form-label>
                                <div id="edit-principal-address">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Nama PIC</x-form-label>
                                <div id="edit-pic-name">-</div>
                            </div>
                            <div>
                                <x-form-label>Jabatan PIC</x-form-label>
                                <div id="edit-pic-position">-</div>
                            </div>
                        </x-card>
                    </div>
                    <div class="w-100 mb-3">
                        <x-card header="5. Tambahan" smallHeader>
                            <x-form-input label="Service Charge" id="edit-service-charge" name="serviceCharge" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                            <x-form-input label="Biaya Admin" id="edit-admin-charge" name="adminCharge" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                            <div>
                                <x-form-label>Premi Bayar</x-form-label>
                                <div id="edit-premi-charge">Rp0,-</div>
                            </div>
                        </x-card>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="3. Jaminan" smallHeader>
                            <x-form-input label="Nilai Kontrak" id="edit-contract-value" name="contractValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                            <x-form-input label="Nilai Jaminan" id="edit-insurance-value" name="insuranceValue" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                            <div class="row">
                                <div class="col-sm-6">
                                    <x-form-input label="Jangka Awal" id="edit-start-date" name="startDate" type="date" class="mb-3" />
                                </div>
                                <div class="col-sm-6">
                                    <x-form-input label="Jangka Akhir" id="edit-end-date" name="endDate" type="date" class="mb-3" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Batas Toleransi Jatuh Tempo</x-form-label>
                                <div class="d-flex flex-xl-row flex-column gap-2">
                                    <x-form-check id="edit-due-day-tolerance-0" name='dueDayTolerance' value="0" type="radio" inline checked>0 Hari</x-form-check>
                                    <x-form-check id="edit-due-day-tolerance-1" name='dueDayTolerance' value="1" type="radio" inline>1 Hari</x-form-check>
                                    <x-form-check id="edit-due-day-tolerance-2" name='dueDayTolerance' value="2" type="radio" inline>2 Hari</x-form-check>
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-form-label required>Jumlah Hari</x-form-label>
                                <input type="hidden" id="edit-day-count-input" name="dayCount" value="0">
                                <div><span class="edit-day-count">0</span> Hari</div>
                            </div>
                            <x-form-input label="Nama Proyek" id="edit-project-name" name="projectName" class="mb-3" required />
                            <x-form-input label="Dokumen Pendukung" id="edit-document-title" name="documentTitle" class="mb-3" />
                            <x-form-input label="No. Dokumen Pendukung" id="edit-document-number" name="documentNumber" class="mb-3" />
                            <x-form-input label="Tanggal Dokumen Pendukung" id="edit-document-expired-at" name="documentExpiredAt" type="date" />
                        </x-card>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Bank Garansi</div>
                </div>
            </div>
            <div class="row mx-1">
                <x-card class="p-1">
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">30</div>
                            <div class="border-bottom p-1 text-center">Character</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-1" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-2" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-3" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-4" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-5" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-6" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Character:</div>
                                    <div><b>20</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">20</div>
                            <div class="border-bottom p-1 text-center">Capacity</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-7" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-8" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-9" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-10" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-11" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Capacity:</div>
                                    <div><b>17</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">20</div>
                            <div class="border-bottom p-1 text-center">Capital</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-12" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-13" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-14" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-15" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-16" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Capital:</div>
                                    <div><b>16</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">17</div>
                            <div class="border-bottom p-1 text-center">Condition</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-17" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-18" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-19" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-23" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-24" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-25" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-26" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-27" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-28" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                            </div>
                            <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Sub Total Nilai Condition:</div>
                                    <div><b>16</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col border p-0" style="position: relative; flex: 100%;">
                            <div class="border-bottom p-1 text-center">13</div>
                            <div class="border-bottom p-1 text-center">Collateral</div>
                            <div class="px-3 pt-3 pb-5">
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-29" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-30" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-31" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-32" name="scoring[score[]]" value="10">Name</x-form-check>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-bold">Kategori</div>
                                    <x-form-check id="edit-scoring-score-20" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-21" name="scoring[score[]]" value="10">Name</x-form-check>
                                    <x-form-check id="edit-scoring-score-22" name="scoring[score[]]" value="10">Name</x-form-check>
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
                </x-card>
            </div>
        </x-form>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="edit-save" face="success" icon="bx bxs-save">Simpan</x-button>
            </div>
        @endslot
    </x-modal>

    <x-modal id="modal-edit-status" title="Ubah Status" size="lg">
        <div class="pb-2 mb-2 text-center">
            <b>No. Bond</b> <br>
            <span id="edit-status-no-bond">-</span>
        </div>
        <div>

            <x-form id="form-edit-status" method="put">
                @php
                    $processStatusses = [
                        'input',
                        'analisa asuransi',
                        'analisa bank',
                        'terbit',
                        'batal',
                    ];

                    $insuranceStatusses = [
                        'belum terbit',
                        'terbit',
                        'batal',
                        'revisi',
                        'salah cetak',
                    ];
                @endphp

                {{-- Status Proses --}}
                <div class="mb-4">
                    <div class="text-center">
                        <label class="form-label mb-2 d-block">Status Proses</label>
                        @foreach ($processStatusses as $status)
                            <x-button class="mx-2 my-2 process-status" data-status="{{ $status }}" face="outline-{{ App\Models\GuaranteeBank::mappingProcessStatusColors($status) }}" icon="{{ App\Models\GuaranteeBank::mappingProcessStatusIcons($status) }}">{{ App\Models\GuaranteeBank::mappingProcessStatusNames($status) }}</x-button>
                        @endforeach
                    </div>
                </div>

                {{-- Status Jaminan --}}
                <div>
                    <div class="text-center">
                        <label class="form-label mb-2 d-block">Status Jaminan</label>
                        @foreach ($insuranceStatusses as $status)
                            <x-button class="mx-2 my-2 insurance-status" data-status="{{ $status }}" face="outline-{{ App\Models\GuaranteeBank::mappingInsuranceStatusColors($status) }}" icon="{{ App\Models\GuaranteeBank::mappingInsuranceStatusIcons($status) }}">{{ App\Models\GuaranteeBank::mappingInsuranceStatusNames($status) }}</x-button>
                        @endforeach
                    </div>
                </div>
            </x-form>
        </div>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="edit-status-save" face="success" icon="bx bxs-save">Simpan</x-button>
            </div>
        @endslot
    </x-modal>

    <x-modal id="modal-status-histories" title="Riwayat Status" size="xl">
        <div class="pb-2 mb-2 text-center">
            <b>No. Bond</b> <br>
            <span id="status-histories-no-bond">-</span>
        </div>
        <div class="row">
            <div class="col-md-4 border rounded p-3">
                <div class="fw-bold text-center mb-3">Status Jaminan</div>
                <div class="list-group" id="insurance-status-histories">
                    {{-- Start History Items --}}
                    <x-history-item icon="bx bx-check" face="success" time="01/11/2022 22:00">Lunas</x-history-item>
                    {{-- End History Items --}}
                </div>
            </div>
            <div class="col-md-4 border rounded p-3">
                <div class="fw-bold text-center mb-3">Status Proses</div>
                <div class="list-group" id="progress-status-histories">
                    {{-- Start History Items --}}
                    <x-history-item icon="bx bx-check" face="success" time="01/11/2022 22:00">Lunas</x-history-item>
                    {{-- End History Items --}}
                </div>
            </div>
            <div class="col-md-4 border rounded p-3">
                <div class="fw-bold text-center mb-3">Status Keuangan</div>
                <div class="list-group" id="finance-status-histories">
                    {{-- Start History Items --}}
                    <x-history-item icon="bx bx-check" face="success" time="01/11/2022 22:00">Lunas</x-history-item>
                    {{-- End History Items --}}
                </div>
            </div>
        </div>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
            </div>
        @endslot
    </x-modal>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $("#table").DataTable()
            $("#create-agent-id, #create-bank-id, #create-insurance-id, #create-insurance-type-id, #create-principal-id, #create-obligee-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-agent-id, #edit-bank-id, #edit-insurance-id, #edit-insurance-type-id, #edit-principal-id, #edit-obligee-id, #edit-status, #edit-cancel-status, #edit-sync-status").select2({dropdownParent: $('#modal-edit')})
            $("#edit-status-insurance, #edit-status-process, #edit-status-finance").select2({dropdownParent: $('#modal-edit-status')})
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Bank Garansi?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
