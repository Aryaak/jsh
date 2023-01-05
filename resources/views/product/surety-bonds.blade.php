@extends('layouts.main', ['title' => 'Surety Bond'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Surety Bond">
        @slot('headerAction')
            @if ($global->currently_on == 'branch')
                <div>
                    <x-button link="{{ route('branch.products.draft.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug]) }}" size="sm" icon="bx bx-search" face="info">Lihat Draft @if ($count_draft > 0) <x-badge face="danger" class="ms-1">{{ $count_draft }}</x-badge> @endif</x-button>
                    <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus" onclick="requestReceiptNumber()">Tambah Surety Bond</x-button>
                </div>
            @endif
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>No. Kwitansi</th>
                    <th>No. Bond</th>
                    <th>No. Polis</th>
                    <th>Nama Principal</th>
                    <th>Status Jaminan</th>
                    <th>Nilai Jaminan</th>
                    <th>Tanggal</th>
                    <th width="125px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    @if ($global->currently_on == 'branch')
        <x-modal id="modal-create" title="Tambah Surety Bond" size="fullscreen" darkBody>
            <x-form id="form-create" method="post">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Surety Bond</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Data" smallHeader>
                                <x-form-input label="No. Kwitansi" id="create-receipt-number" name="receiptNumber" class="mb-3" required readonly/>
                                <x-form-input label="No. Bond" id="create-bond-number" name="bondNumber" class="mb-3" />
                                <x-form-input label="No. Polis" id="create-polish-number" name="polishNumber" class="mb-3" />
                                <x-form-select label="Nama Agen" id="create-agent-id" name="agentId" class="mb-3" required/>
                                <x-form-select label="Nama Asuransi" id="create-insurance-id" name="insuranceId" class="mb-3" required/>
                                <x-form-select label="Jenis Jaminan" id="create-insurance-type-id" name="insuranceTypeId" required/>
                            </x-card>
                        </div>
                        <div class="w-100 mb-4">
                            <x-card header="Obligee" smallHeader>
                                <x-form-select label="Nama" id="create-obligee-id" name="obligeeId" class="mb-3" required/>
                                <div>
                                    <x-form-label>Alamat</x-form-label>
                                    <div id="create-obligee-address">-</div>
                                </div>
                            </x-card>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Principal" smallHeader>
                                <x-form-select label="Nama" id="create-principal-id" name="principalId" class="mb-3" required/>
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
                            <x-card header="Tambahan" smallHeader>
                                <x-form-input label="Service Charge" id="create-service-charge" name="serviceCharge" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                                <x-form-input label="Biaya Admin" id="create-admin-charge" name="adminCharge" prefix="Rp" suffix=",-" class="mb-3" classInput="to-rupiah" required />
                                <div>
                                    <x-form-label>Premi Bayar</x-form-label>
                                    <div id="create-premi-charge">Rp0,-</div>
                                </div>
                            </x-card>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Jaminan" smallHeader>
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
                                        <x-form-check id="create-due-day-tolerance-0" input-class='create-due-day-tolerance' name='dueDayTolerance' value="0" type="radio" inline checked>0 Hari</x-form-check>
                                        <x-form-check id="create-due-day-tolerance-1" input-class='create-due-day-tolerance' name='dueDayTolerance' value="1" type="radio" inline>1 Hari</x-form-check>
                                        <x-form-check id="create-due-day-tolerance-2" input-class='create-due-day-tolerance' name='dueDayTolerance' value="2" type="radio" inline>2 Hari</x-form-check>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-form-label required>Jumlah Hari</x-form-label>
                                    <input type="hidden" id="create-day-count-input" name="dayCount" value="0">
                                    <div><span id="create-day-count">0</span> Hari</div>
                                </div>
                                <x-form-input label="Nama Proyek" id="create-project-name" name="projectName" class="mb-3" required />
                                <x-form-input label="Dokumen Pendukung" id="create-document-title" name="documentTitle" class="mb-3" />
                                <x-form-input label="No. Dokumen Pendukung" id="create-document-number" name="documentNumber" class="mb-3" />
                                <x-form-input label="Tanggal Berakhir Dokumen Pendukung" id="create-document-expired-at" name="documentExpiredAt" type="date" />
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
                            @foreach ($scorings->groupBy('category') as $grouped)
                                <div class="col border p-0" style="position: relative; flex: 100%;">
                                    {{-- <div class="border-bottom p-1 text-center">30</div> --}}
                                    <div class="border-bottom p-1 text-center">{{ $grouped->first()->category }}</div>
                                    <div class="px-3 pt-3 pb-5">
                                        @foreach ($grouped as $score)
                                        <div class="mb-3">
                                            <div class="fw-bold">{{ $score->title }}</div>
                                            @foreach ($score->details as $detail)
                                                <x-form-check type="radio" id="create-scoring-score-{{ $score->id }}-{{ $detail->id }}" name="scoring[{{ $score->id }}]" value="{{ $detail->id }}">{{ $detail->text }}</x-form-check>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                    {{-- <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>Sub Total Nilai {{ $grouped->first()->category }}:</div>
                                            <div><b>20</b></div>
                                        </div>
                                    </div> --}}
                                </div>
                            @endforeach
                            {{-- <div class="col-12 mt-3">
                                Total Nilai: <b>69</b>
                            </div> --}}
                        </div>
                    </x-card>
                </div>
            </x-form>

            @slot('footer')
                <div class="d-flex justify-content-between w-100">
                    <div>
                    </div>
                    <div>
                        <div>Shortcut:</div>
                        <div>
                            <x-button link="{{ route('branch.master.principals.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug, 'mode' => 'tambah']) }}" target="_blank" icon="bx bxs-data">Principal</x-button>
                            <x-button link="{{ route('branch.master.obligees.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug, 'mode' => 'tambah']) }}" target="_blank" icon="bx bxs-data">Obligee</x-button>
                        </div>
                    </div>
                    <div>
                        <br>
                        <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
                    </div>
                </div>
            @endslot
        </x-modal>

        <x-modal id="modal-show" title="Detail Surety Bond" size="fullscreen" darkBody>
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Status Surety Bond</div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <x-card header="Status Jaminan" smallHeader>
                        <div id="show-insurance-status">

                        </div>
                    </x-card>
                </div>
                <div class="col-md-4">
                    <x-card header="Status Proses" smallHeader>
                        <div id="show-process-status">

                        </div>
                    </x-card>
                </div>
                <div class="col-md-4">
                    <x-card header="Status Keuangan" smallHeader>
                        <div id="show-finance-status">

                        </div>
                    </x-card>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Surety Bond</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="Data" smallHeader>
                            <div class="mb-3">
                                <x-form-label>No. Kwitansi</x-form-label>
                                <div id="show-receipt-number">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>No. Bond</x-form-label>
                                <div id="show-bond-number">-</div>
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
                        <x-card header="Obligee" smallHeader>
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
                        <x-card header="Principal" smallHeader>
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
                    <div class="w-100 mb-4">
                        <x-card header="Tambahan" smallHeader>
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
                        <x-card header="Jaminan" smallHeader>
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
                                <x-form-label>Tanggal Berakhir Dokumen Pendukung</x-form-label>
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
                        @foreach ($scorings->groupBy('category') as $grouped)
                            <div class="border p-0" style="position: relative; flex: 100%;">
                                {{-- <div class="border-bottom p-1 text-center">30</div> --}}
                                <div class="border-bottom p-1 text-center" id="show-scoring-category">{{ $grouped->first()->category }}</div>
                                <div class="px-3 pt-3 pb-5">
                                    @foreach ($grouped as $score)
                                    <div class="mb-3">
                                        <div class="fw-bold">{{ $score->title }}</div>
                                        @foreach ($score->details as $detail)
                                            <x-form-check type="radio" id="show-scoring-score-{{ $score->id }}-{{ $detail->id }}" name="scoring[{{ $score->id }}]" value="{{ $detail->id }}" disabled>{{ $detail->text }}</x-form-check>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                                <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>Sub Total Nilai {{ $grouped->first()->category }}:</div>
                                        <div><b id="show-sub-total-{{ $grouped->first()->category }}">-</b></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Total Nilai: <b id="show-total-score">69</b></div>
                                <div>
                                    <x-button face='secondary' id="print-score" icon="bx bxs-printer">Cetak Scoring</x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            @slot('footer')
                <div class="d-flex justify-content-between w-100">
                    <x-button class="btn-status-histories" data-bs-target="#modal-status-histories" data-bs-toggle="modal" data-bs-dismiss="modal" face='secondary' icon="bx bx-history">Riwayat Status</x-button>
                    <x-button id="btn-paid-off-payment" face="success" icon="bx bxs-badge-check">Lunasi Pembayaran</x-button>
                    <div>
                        <x-button class="btn-edit-status" data-bs-target="#modal-edit-status" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah Status</x-button>
                        <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah Data</x-button>
                    </div>
                </div>
            @endslot
        </x-modal>

        <x-modal id="modal-edit" title="Ubah Surety Bond" size="fullscreen" darkBody>
            <x-form id="form-edit" method="put">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Surety Bond</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Data" smallHeader>
                                <x-form-input label="No. Kwitansi" id="edit-receipt-number" name="receiptNumber" class="mb-3" required readonly/>
                                <x-form-input label="No. Bond" id="edit-bond-number" name="bondNumber" class="mb-3" />
                                <x-form-input label="No. Polis" id="edit-polish-number" name="polishNumber" class="mb-3" />
                                <x-form-select label="Nama Agen" id="edit-agent-id" name="agentId" class="mb-3" required/>
                                <x-form-select label="Nama Asuransi" id="edit-insurance-id" name="insuranceId" class="mb-3" required/>
                                <x-form-select label="Jenis Jaminan" id="edit-insurance-type-id" name="insuranceTypeId" required/>
                            </x-card>
                        </div>
                        <div class="w-100 mb-4">
                            <x-card header="Obligee" smallHeader>
                                <x-form-select label="Nama" id="edit-obligee-id" name="obligeeId" class="mb-3" required/>
                                <div>
                                    <x-form-label>Alamat</x-form-label>
                                    <div id="edit-obligee-address">-</div>
                                </div>
                            </x-card>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="w-100 mb-4">
                            <x-card header="Principal" smallHeader>
                                <x-form-select label="Nama" id="edit-principal-id" name="principalId" class="mb-3" required/>
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
                        <div class="w-100 mb-4">
                            <x-card header="Tambahan" smallHeader>
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
                            <x-card header="Jaminan" smallHeader>
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
                                        <x-form-check id="edit-due-day-tolerance-0" input-class='edit-due-day-tolerance' name='dueDayTolerance' value="0" type="radio" inline checked>0 Hari</x-form-check>
                                        <x-form-check id="edit-due-day-tolerance-1" input-class='edit-due-day-tolerance' name='dueDayTolerance' value="1" type="radio" inline>1 Hari</x-form-check>
                                        <x-form-check id="edit-due-day-tolerance-2" input-class='edit-due-day-tolerance' name='dueDayTolerance' value="2" type="radio" inline>2 Hari</x-form-check>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-form-label required>Jumlah Hari</x-form-label>
                                    <input type="hidden" id="edit-day-count-input" name="dayCount" value="0">
                                    <div><span id="edit-day-count">0</span> Hari</div>
                                </div>
                                <x-form-input label="Nama Proyek" id="edit-project-name" name="projectName" class="mb-3" required />
                                <x-form-input label="Dokumen Pendukung" id="edit-document-title" name="documentTitle" class="mb-3" />
                                <x-form-input label="No. Dokumen Pendukung" id="edit-document-number" name="documentNumber" class="mb-3" />
                                <x-form-input label="Tanggal Berakhir Dokumen Pendukung" id="edit-document-expired-at" name="documentExpiredAt" type="date" />
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
                            @foreach ($scorings->groupBy('category') as $grouped)
                                <div class="col border p-0" style="position: relative; flex: 100%;">
                                    {{-- <div class="border-bottom p-1 text-center">30</div> --}}
                                    <div class="border-bottom p-1 text-center">{{ $grouped->first()->category }}</div>
                                    <div class="px-3 pt-3 pb-5">
                                        @foreach ($grouped as $score)
                                        <div class="mb-3">
                                            <div class="fw-bold">{{ $score->title }}</div>
                                            @foreach ($score->details as $detail)
                                                <x-form-check type="radio" id="edit-scoring-score-{{ $score->id }}-{{ $detail->id }}" name="scoring[{{ $score->id }}]" value="{{ $detail->id }}">{{ $detail->text }}</x-form-check>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                    {{-- <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>Sub Total Nilai {{ $grouped->first()->category }}:</div>
                                            <div><b>20</b></div>
                                        </div>
                                    </div> --}}
                                </div>
                            @endforeach
                            {{-- <div class="col-12 mt-3">
                                Total Nilai: <b>69</b>
                            </div> --}}
                        </div>
                    </x-card>
                </div>
            </x-form>

            @slot('footer')
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <br>
                        <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                    </div>
                    <div>
                        <div>Shortcut:</div>
                        <div>
                            <x-button link="{{ route('branch.master.principals.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug, 'mode' => 'tambah']) }}" target="_blank" icon="bx bxs-data">Principal</x-button>
                            <x-button link="{{ route('branch.master.obligees.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug, 'mode' => 'tambah']) }}" target="_blank" icon="bx bxs-data">Obligee</x-button>
                        </div>
                    </div>
                    <div>
                        <br>
                        <x-button id="edit-save" face="success" icon="bx bxs-save">Simpan</x-button>
                    </div>
                </div>
            @endslot
        </x-modal>

        <x-modal id="modal-edit-status" title="Ubah Status" size="lg">
            <div class="pb-2 mb-2 text-center">
                <b>No. Bond</b> <br>
                <span id="edit-status-no-bond">-</span>
            </div>
            <div>
                {{-- Status Proses --}}
                <div class="mb-4">
                    <div class="text-center">
                        <label class="form-label mb-2 d-block">Status Proses</label>
                        <small class="d-block">Saat ini: <span id="edit-process-status" style="text-transform: capitalize"></span></small>
                        @foreach ($statuses->process as $status)
                            <x-button class="mx-2 my-2 process-status" data-status="{{ $status }}"
                                data-color="{{ App\Models\SuretyBond::mappingProcessStatusColors($status) }}"
                                data-icon="{{ App\Models\SuretyBond::mappingProcessStatusIcons($status) }}"
                                face="outline-{{ App\Models\SuretyBond::mappingProcessStatusColors($status) }}"
                                icon="{{ App\Models\SuretyBond::mappingProcessStatusIcons($status) }}">
                                {{ App\Models\SuretyBond::mappingProcessStatusNames($status) }}
                            </x-button>
                        @endforeach
                    </div>
                </div>

                {{-- Status Jaminan --}}
                <div>
                    <div class="text-center">
                        <label class="form-label mb-2 d-block">Status Jaminan</label>
                        <small class="d-block">Saat ini: <span id="edit-insurance-status" style="text-transform: capitalize"></span></small>
                        @foreach ($statuses->insurance as $status)
                            <x-button class="mx-2 my-2 insurance-status" data-status="{{ $status }}"
                                data-color="{{ App\Models\SuretyBond::mappingInsuranceStatusColors($status) }}"
                                data-icon="{{ App\Models\SuretyBond::mappingInsuranceStatusIcons($status) }}"
                                face="outline-{{ App\Models\SuretyBond::mappingInsuranceStatusColors($status) }}"
                                icon="{{ App\Models\SuretyBond::mappingInsuranceStatusIcons($status) }}">
                                {{ App\Models\SuretyBond::mappingInsuranceStatusNames($status) }}
                            </x-button>
                        @endforeach
                    </div>
                </div>
            </div>

            @slot('footer')
                <div class="d-flex justify-content-between w-100">
                    <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                </div>
            @endslot
        </x-modal>
    @elseif ($global->currently_on == 'regional')
        <x-modal id="modal-show" title="Detail Surety Bond" size="fullscreen" darkBody>
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Surety Bond</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="Data" smallHeader>
                            <div class="mb-3">
                                <x-form-label>No. Kwitansi</x-form-label>
                                <div id="show-receipt-number">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>No. Bond</x-form-label>
                                <div id="show-bond-number">-</div>
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
                        <x-card header="Obligee" smallHeader>
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
                    <div class="w-100 mb-3">
                        <x-card header="Laba" smallHeader>
                            <div class="mb-3">
                                <x-form-label>Laba</x-form-label>
                                <div id="show-profit">-</div>
                            </div>
                        </x-card>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="w-100 mb-4">
                        <x-card header="Principal" smallHeader>
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
                        <x-card header="Asuransi" smallHeader>
                            <div class="mb-3">
                                <x-form-label>Rate Asuransi</x-form-label>
                                <div id="show-insurance-rate">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Biaya Polis Asuransi</x-form-label>
                                <div id="show-insurance-polish-cost">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Materai Asuransi</x-form-label>
                                <div id="show-insurance-stamp">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Nett Premi</x-form-label>
                                <div id="show-premi-nett">-</div>
                            </div>
                            <div>
                                <x-form-label>Total Nett Premi</x-form-label>
                                <div id="show-premi-nett-total">-</div>
                            </div>
                        </x-card>
                    </div>
                    <div class="w-100 mb-4">
                        <x-card header="Tambahan" smallHeader>
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
                        <x-card header="Jaminan" smallHeader>
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
                                <x-form-label>Tanggal Berakhir Dokumen Pendukung</x-form-label>
                                <div id="show-document-expired-at">-</div>
                            </div>
                        </x-card>
                    </div>
                    <div class="w-100 mb-3">
                        <x-card header="Kantor" smallHeader>
                            <div class="mb-3">
                                <x-form-label>Rate Kantor</x-form-label>
                                <div id="show-office-rate">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Nett Kantor</x-form-label>
                                <div id="show-office-nett">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Biaya Polis</x-form-label>
                                <div id="show-office-polish-cost">-</div>
                            </div>
                            <div class="mb-3">
                                <x-form-label>Materai</x-form-label>
                                <div id="show-office-stamp-cost">-</div>
                            </div>
                            <div>
                                <x-form-label>Total Nett Kantor</x-form-label>
                                <div id="show-office-nett-total">-</div>
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
                <x-card>
                    <div class="row">
                        @foreach ($scorings->groupBy('category') as $grouped)
                            <div class="col border p-0" style="position: relative">
                                {{-- <div class="border-bottom p-1 text-center">30</div> --}}
                                <div class="border-bottom p-1 text-center" id="show-scoring-category">{{ $grouped->first()->category }}</div>
                                <div class="px-3 pt-3 pb-5">
                                    @foreach ($grouped as $score)
                                    <div class="mb-3">
                                        <div class="fw-bold">{{ $score->title }}</div>
                                        @foreach ($score->details as $detail)
                                            <x-form-check type="radio" id="show-scoring-score-{{ $score->id }}-{{ $detail->id }}" name="scoring[{{ $score->id }}]" value="{{ $detail->id }}" disabled>{{ $detail->text }}</x-form-check>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                                <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>Sub Total Nilai {{ $grouped->first()->category }}:</div>
                                        <div><b id="show-sub-total-{{ $grouped->first()->category }}">-</b></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Total Nilai: <b id="show-total-score">69</b></div>
                                <div>
                                    <x-button face='secondary' id="print-score" icon="bx bxs-printer">Cetak Scoring</x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            @slot('footer')
                <div class="d-flex justify-content-between w-100">
                    <x-button class="btn-status-histories" data-bs-target="#modal-status-histories" data-bs-toggle="modal" data-bs-dismiss="modal" face='secondary' icon="bx bx-history">Riwayat Status</x-button>
                </div>
            @endslot
        </x-modal>
    @endif

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
                <div class="list-group" id="process-status-histories">
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
        let table = null
        let suretyBond = null
        $(document).ready(function () {
            table = dataTableInit('table','Surety Bond',{url : '{{ route($global->currently_on.'.products.surety-bonds.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '']) }}'},[
                {data: 'receipt_number', name: 'receipt_number'},
                {data: 'bond_number', name: 'bond_number'},
                {data: 'polish_number', name: 'polish_number'},
                {data: 'principal.name', name: 'principal.name'},
                {data: 'insurance_status.status.name', name: 'insurance_status.status.name',orderable:false},
                {data: 'insurance_value', name: 'insurance_value'},
                {data: 'start_date', name: 'start_date'},
            ])

            @if ($global->currently_on == 'branch')
                select2Init("#create-agent-id",'{{ route('select2.agent') }}',0,$('#modal-create'))
                select2Init("#create-obligee-id",'{{ route('select2.obligee') }}',0,$('#modal-create'))
                select2Init("#create-principal-id",'{{ route('select2.principal') }}',0,$('#modal-create'))
                select2Init("#create-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-create'))
                select2Init("#create-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-create'))

                select2Init("#edit-agent-id",'{{ route('select2.agent') }}',0,$('#modal-edit'))
                select2Init("#edit-obligee-id",'{{ route('select2.obligee') }}',0,$('#modal-edit'))
                select2Init("#edit-principal-id",'{{ route('select2.principal') }}',0,$('#modal-edit'))
                select2Init("#edit-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-edit'))
                select2Init("#edit-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-edit'))
            @endif
        })

        @if ($global->currently_on == 'branch')
            $(document).on('input', '#create-service-charge, #create-admin-charge, #edit-service-charge, #edit-admin-charge', function () {
                const creadit = $(this).attr('id').split('-')[0] //create or edit
                const serviceCharge = parseInt($('#'+creadit+'-service-charge').val() ? $('#'+creadit+'-service-charge').val().replaceAll('.','') : 0)
                const adminCharge = parseInt($('#'+creadit+'-admin-charge').val() ? $('#'+creadit+'-admin-charge').val().replaceAll('.','') : 0)
                const totalCharge =  serviceCharge + adminCharge

                if (isNaN(totalCharge)) totalCharge = 0
                $('#'+creadit+'-premi-charge').html(ToRupiah.format(totalCharge).replaceAll('\u00A0', '')+",-")
            })
            $(document).on('click', '#create-save', function () {
                loading()
                ajaxPost("{{ route('branch.products.surety-bonds.store', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '']) }}",fetchFormData(new FormData(document.getElementById('form-create'))),'#modal-create',function(){
                    table.ajax.reload()
                    clearForm('#form-create')
                })
            })
            $(document).on('change', '#create-obligee-id, #edit-obligee-id', function () {
                const creadit = $(this).attr('id').split('-')[0] //create or edit
                ajaxGet('{{ route('master.obligees.show','-id-') }}'.replace('-id-',$(this).val()),null,function(response){
                $('#'+creadit+'-obligee-address').html(response.data.address)
                })
            })
            $(document).on('change', '#create-principal-id, #edit-principal-id', function () {
                const creadit = $(this).attr('id').split('-')[0] //create or edit
                ajaxGet('{{ route('master.principals.show','-id-') }}'.replace('-id-',$(this).val()),null,function(response){
                    const data = response.data
                    $('#'+creadit+'-principal-address').html(data.address)
                    $('#'+creadit+'-pic-name').html(data.pic_name)
                    $('#'+creadit+'-pic-position').html(data.pic_position)
                })
            })
            $(document).on('input', '#create-start-date, #create-end-date, #edit-start-date, #edit-end-date, .create-due-day-tolerance, .edit-due-day-tolerance', function () {
                const split = $(this).attr('id').split('-')
                let dayCount = (split[1]  == 'due') ? parseInt(calculateDayFromDates('start',split[0])) : calculateDayFromDates(split[1],split[0])
                $('#'+split[0]+'-day-count-input').val(dayCount)
                $('#'+split[0]+'-day-count').html(dayCount)
            })
        @endif

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route($global->currently_on.'.products.surety-bonds.show', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond' => '-id-']) }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    suretyBond = response.data

                    statuses = {};

                    $('#show-receipt-number').html(suretyBond.receipt_number)
                    $('#show-bond-number').html(suretyBond.bond_number)
                    $('#show-polish-number').html(suretyBond.polish_number)
                    $('#show-agent').html(suretyBond.agent.name)
                    $('#show-insurance').html(suretyBond.insurance.name)
                    $('#show-insurance-type').html(suretyBond.insurance_type.name)
                    $('#show-obligee-name').html(suretyBond.obligee.name)
                    $('#show-obligee-address').html(suretyBond.obligee.name)
                    $('#show-principal-name').html(suretyBond.principal.name)
                    $('#show-principal-address').html(suretyBond.principal.address)
                    $('#show-pic-name').html(suretyBond.principal.pic_name)
                    $('#show-pic-position').html(suretyBond.principal.pic_position)
                    $('#show-service-charge').html(suretyBond.service_charge_converted)
                    $('#show-admin-charge').html(suretyBond.admin_charge_converted)
                    $('#show-premi-charge').html(suretyBond.total_charge_converted)
                    $('#show-contract-value').html(suretyBond.contract_value_converted)
                    $('#show-insurance-value').html(suretyBond.insurance_value_converted)
                    $('#show-start-date').html(suretyBond.start_date_converted)
                    $('#show-end-date').html(suretyBond.end_date_converted)
                    $('#show-due-day-tolerance').html(suretyBond.due_day_tolerance)
                    $('#show-day-count').html(suretyBond.day_count)
                    $('#show-project-name').html(suretyBond.project_name)
                    $('#show-document-title').html(suretyBond.document_title)
                    $('#show-document-number').html(suretyBond.document_number)
                    $('#show-document-expired-at').html(suretyBond.document_expired_at_converted)
                    $('#show-insurance-rate').html(suretyBond.insurance_rate)
                    $('#show-insurance-polish-cost').html(suretyBond.insurance_polish_cost_converted)
                    $('#show-insurance-stamp').html(suretyBond.insurance_stamp_cost_converted)
                    $('#show-premi-nett').html(suretyBond.insurance_net_converted)
                    $('#show-premi-nett-total').html(suretyBond.insurance_net_total_converted)
                    $('#show-office-rate').html(suretyBond.office_rate)
                    $('#show-office-nett').html(suretyBond.office_net_converted)
                    $('#show-office-nett-total').html(suretyBond.office_net_total_converted)
                    $('#show-office-polish-cost').html(suretyBond.office_polish_cost_converted)
                    $('#show-office-stamp-cost').html(suretyBond.office_stamp_cost_converted)
                    $('#show-profit').html(suretyBond.profit_converted)
                    $('#show-total-score').html(suretyBond.score)
                    $('input[type="radio"]:checked').prop('checked',false)
                    const groupByCategory = scoringGroupBy(suretyBond.scorings)
                    Object.keys(groupByCategory).forEach(key => {
                        $('#show-scoring-category').html(key)
                        let subtotal = 0
                        groupByCategory[key].forEach(e => {
                            $('#show-scoring-score-'+e.scoring_id+'-'+e.scoring_detail_id).prop('checked',true)
                            subtotal += e.value
                        });
                        $('#show-sub-total-'+key).html(subtotal)
                    });
                    $('#status-histories-no-bond').html(suretyBond.bond_number)
                    $('#insurance-status-histories').html('')
                    $('#process-status-histories').html('')
                    $('#finance-status-histories').html('')
                    suretyBond.statuses.forEach(e => {
                        const html = `<x-history-item icon="` + suretyBond.status_style[e.type][e.status.name].icon + `" face="` + suretyBond.status_style[e.type][e.status.name].color + `" time="`+e.created_at+`">`+e.status.name+`</x-history-item>`
                        $('#'+e.type+'-status-histories').append(html)
                        statuses[e.type + 'Name'] = e.status.name
                        statuses[e.type + 'Icon'] = suretyBond.status_style[e.type][e.status.name].icon
                        statuses[e.type + 'Color'] = suretyBond.status_style[e.type][e.status.name].color
                    });

                    $("#show-insurance-status").html(`
                        <span class='d-flex align-items-center badge bg-label-` + statuses['insuranceColor'] + `'>
                            <i class='` + statuses['insuranceIcon'] + ` mx-2 py-2'></i>` + statuses['insuranceName'] + `
                        </span>
                    `)

                    $("#show-process-status").html(`
                        <span class='d-flex align-items-center badge bg-label-` + statuses['processColor'] + `'>
                            <i class='` + statuses['processIcon'] + ` mx-2 py-2'></i>` + statuses['processName'] + `
                        </span>
                    `)

                    $("#show-finance-status").html(`
                        <span class='d-flex align-items-center badge bg-label-` + statuses['financeColor'] + `'>
                            <i class='` + statuses['financeIcon'] + ` mx-2 py-2'></i>` + statuses['financeName'] + `
                        </span>
                    `)

                    if(suretyBond.finance_status.status.name == 'lunas'){
                        $('#btn-paid-off-payment').hide()
                    }else{
                        $('#btn-paid-off-payment').show()
                    }
                }
            })
        })

        $(document).on('click', '#print-score', function () {
            window.open("{{ route($global->currently_on.'.products.surety-bonds.print-score', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond' => '-id-']) }}".replace('-id-',suretyBond.id));
        })

        @if ($global->currently_on == 'branch')
            $(document).on('click', '.btn-edit', function () {
                $('input[type="radio"]:checked').prop('checked',false)
                select2SetVal("edit-agent-id",suretyBond.agent.id,suretyBond.agent.name)
                select2SetVal("edit-insurance-id",suretyBond.insurance.id,suretyBond.insurance.name)
                select2SetVal("edit-insurance-type-id",suretyBond.insurance_type.id,suretyBond.insurance_type.name)
                select2SetVal("edit-obligee-id",suretyBond.obligee.id,suretyBond.obligee.name)
                select2SetVal("edit-principal-id",suretyBond.principal.id,suretyBond.principal.name)
                $('#edit-receipt-number').val(suretyBond.receipt_number)
                $('#edit-bond-number').val(suretyBond.bond_number)
                $('#edit-polish-number').val(suretyBond.polish_number)
                $('#edit-service-charge').val(numberFormat(suretyBond.service_charge))
                $('#edit-premi-charge').html(suretyBond.total_charge_converted)
                $('#edit-admin-charge').val(numberFormat(suretyBond.admin_charge))
                $('#edit-contract-value').val(numberFormat(suretyBond.contract_value))
                $('#edit-insurance-value').val(numberFormat(suretyBond.insurance_value))
                $('#edit-start-date').val(suretyBond.start_date)
                $('#edit-end-date').val(suretyBond.end_date)
                $('#edit-due-day-tolerance-'+suretyBond.due_day_tolerance).prop('checked',true).trigger('input')
                $('#edit-day-count-input').val(suretyBond.day_count)
                $('#edit-project-name').val(suretyBond.project_name)
                $('#edit-document-title').val(suretyBond.document_title)
                $('#edit-document-number').val(suretyBond.document_number)
                $('#edit-document-expired-at').val(suretyBond.document_expired_at)
                const groupByCategory = scoringGroupBy(suretyBond.scorings)
                Object.keys(groupByCategory).forEach(key => {
                    groupByCategory[key].forEach(e => {
                        $('#edit-scoring-score-'+e.scoring_id+'-'+e.scoring_detail_id).prop('checked',true)
                    });
                });
            })
            $(document).on('click', '#edit-save', function () {
                loading()
                ajaxPost("{{ route('branch.products.surety-bonds.update', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond' => '-id-']) }}".replace('-id-',suretyBond.id),fetchFormData(new FormData(document.getElementById('form-edit'))),'#modal-edit',function(){
                    table.ajax.reload()
                })
            })
            $(document).on('click', '.btn-edit-status', function () {
                $('#edit-status-no-bond').html(suretyBond.bond_number)

                $.each($('.insurance-status'), function(index, element) {
                    $(element).removeClass('btn-' + $(element).data('color'))
                    $(element).removeClass('btn-outline-' + $(element).data('color'))
                    $(element).removeClass('d-none')
                    $(element).prop('disabled', false)
                    if ($(element).data('status') == suretyBond.insurance_status.status.name) {
                        $('#edit-insurance-status').html('<i class="' + $(element).data('icon') + ' me-1"></i>' + suretyBond.insurance_status.status.name)
                        $('#edit-insurance-status').prop("class", '')
                        $('#edit-insurance-status').addClass('badge bg-label-' + $(element).data('color'))
                        $(element).addClass('d-none')
                    }else {
                        $(element).addClass('btn-outline-' + $(element).data('color'))
                    }

                    if (suretyBond.process_status.status.name != 'terbit' && $(element).data('status') != 'belum terbit') {
                        $(element).addClass('d-none')
                    }
                    else if (suretyBond.process_status.status.name == 'terbit' && $(element).data('status') == 'belum terbit') {
                        $(element).addClass('d-none')
                    }
                })

                $.each($('.process-status'), function(index, element) {
                    $(element).removeClass('btn-' + $(element).data('color'))
                    $(element).removeClass('btn-outline-' + $(element).data('color'))
                    $(element).removeClass('d-none')
                    $(element).prop('disabled', false)
                    if (suretyBond.process_status.status.name == 'analisa asuransi' && $(element).data('status') == 'input') {
                        $(element).addClass('d-none')
                    }
                    if (suretyBond.process_status.status.name == 'terbit' || suretyBond.process_status.status.name == 'batal') {
                        $(element).addClass('d-none')
                    }
                    if ($(element).data('status') == suretyBond.process_status.status.name) {
                        $('#edit-process-status').html('<i class="' + $(element).data('icon') + ' me-1"></i>' + suretyBond.process_status.status.name)
                        $('#edit-process-status').prop("class", '')
                        $('#edit-process-status').addClass('badge bg-label-' + $(element).data('color'))
                        $(element).addClass('d-none')
                    }
                    else {
                        $(element).addClass('btn-outline-' + $(element).data('color'))
                    }
                })
            })
            $(document).on('click', '#edit-status-save', function () {
                loading()
                ajaxPost("{{ route('branch.products.surety-bonds.update-status', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond' => '-id-']) }}".replace('-id-',suretyBond.id),new FormData(document.getElementById('form-edit-status')),'#modal-edit-status',function(response){
                    table.ajax.reload()
                })
            })
            $(document).on('click', '.btn-delete', function () {
                // Delete
                NegativeConfirm.fire({
                    title: "Yakin ingin menghapus surety bond ini?",
                }).then((result) => {
                    if (result.isConfirmed) {
                        loading()
                        ajaxPost("{{ route('branch.products.surety-bonds.destroy', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond' => '-id-']) }}".replace('-id-',$(this).data('id')),{_method : 'delete'},'',function(response){
                            table.ajax.reload()
                        })
                    }
                })
            })
            $(document).on('click', '.process-status', function () {
                updateStatus('process',{
                    _method: 'put',
                    type: 'process',
                    status: $(this).data('status')
                },'#modal-edit-status')
            })
            $(document).on('click', '.insurance-status', function () {
                updateStatus('insurance',{
                    _method: 'put',
                    type: 'insurance',
                    status: $(this).data('status')
                },'#modal-edit-status')
            })
            $(document).on('click', '#btn-paid-off-payment', function () {
                Confirm.fire({
                    text: 'Yakin ingin melunasi pembayaran surety bond ini?'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateStatus('finance',{
                            _method: 'put',
                            type: 'finance',
                            status: 'lunas'
                        },'#modal-show')
                    }
                })
            })
            function updateStatus(type,params,modal){
                loading()
                ajaxPost("{{ route('branch.products.surety-bonds.update-status', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond' => '-id-']) }}".replace('-id-',suretyBond.id),params,modal,function(){
                    table.ajax.reload()
                })
            }
            function requestReceiptNumber(){
                ajaxGet("{{ route($global->currently_on.'.products.surety-bonds.request-receipt-number', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond' => '-id-']) }}",null,function(response){
                    if(response.success){
                        $('#create-receipt-number').val(response.data.receiptNumber)
                    }
                },null)
            }
        @endif
    </script>
@endpush
