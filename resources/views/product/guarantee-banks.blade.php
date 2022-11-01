@extends('layouts.main', ['title' => 'Bank Garansi'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Bank Garansi">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Bank Garansi</x-button>
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
                            <x-form-input label="No. Bond" id="create-bond-number" name="bondNumber" class="mb-3" />
                            <x-form-input label="No. Polis" id="create-polish-number" name="polishNumber" class="mb-3" />
                            <x-form-select label="Nama Agen" id="create-agent-id" name="agentId" class="mb-3" required/>
                            <x-form-select label="Nama Bank" id="create-bank-id" name="bankId" class="mb-3" required/>
                            <x-form-select label="Nama Asuransi" id="create-insurance-id" name="insuranceId" class="mb-3" required/>
                            <x-form-select label="Jenis Jaminan" id="create-insurance-type-id" name="insuranceTypeId" required/>
                        </x-card>
                    </div>
                    <div class="w-100 mb-4">
                        <x-card header="4. Obligee" smallHeader>
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
                        <x-card header="2. Principal" smallHeader>
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
                        <x-card header="5. Tambahan" smallHeader>
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
                                <x-form-check id="create-due-day-tolerance-0" input-class='create-due-day-tolerance' name='dueDayTolerance' value="0" type="radio" inline checked>0 Hari</x-form-check>
                                <x-form-check id="create-due-day-tolerance-1" input-class='create-due-day-tolerance' name='dueDayTolerance' value="1" type="radio" inline>1 Hari</x-form-check>
                                <x-form-check id="create-due-day-tolerance-2" input-class='create-due-day-tolerance' name='dueDayTolerance' value="2" type="radio" inline>2 Hari</x-form-check>
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
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Bank Garansi</div>
                </div>
            </div>
            <div class="row mx-1">
                <x-card>
                    <div class="row">
                        @foreach ($scorings->groupBy('category') as $grouped)
                            <div class="col border p-0" style="position: relative">
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
                            <x-form-label>Tanggal Berakhir Dokumen Pendukung</x-form-label>
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
                    {{-- <div class="col-12 mt-3">
                        Total Nilai: <b>69</b>
                    </div> --}}
                </div>
            </x-card>
        </div>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button class="btn-status-histories" data-bs-target="#modal-status-histories" data-bs-toggle="modal" data-bs-dismiss="modal" face='secondary' icon="bx bx-history">Riwayat Status</x-button>
                <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
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
                            <x-form-input label="No. Bond" id="edit-bond-number" name="bondNumber" class="mb-3" />
                            <x-form-input label="No. Polis" id="edit-polish-number" name="polishNumber" class="mb-3" />
                            <x-form-select label="Nama Agen" id="edit-agent-id" name="agentId" class="mb-3" required/>
                            <x-form-select label="Nama Bank" id="edit-bank-id" name="bankId" class="mb-3" required/>
                            <x-form-select label="Nama Asuransi" id="edit-insurance-id" name="insuranceId" class="mb-3" required/>
                            <x-form-select label="Jenis Jaminan" id="edit-insurance-type-id" name="insuranceTypeId" required/>
                        </x-card>
                    </div>
                    <div class="w-100 mb-4">
                        <x-card header="4. Obligee" smallHeader>
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
                        <x-card header="2. Principal" smallHeader>
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
                                <x-form-check id="edit-due-day-tolerance-0" input-class='edit-due-day-tolerance' name='dueDayTolerance' value="0" type="radio" inline checked>0 Hari</x-form-check>
                                <x-form-check id="edit-due-day-tolerance-1" input-class='edit-due-day-tolerance' name='dueDayTolerance' value="1" type="radio" inline>1 Hari</x-form-check>
                                <x-form-check id="edit-due-day-tolerance-2" input-class='edit-due-day-tolerance' name='dueDayTolerance' value="2" type="radio" inline>2 Hari</x-form-check>
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
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Bank Garansi</div>
                </div>
            </div>
            <div class="row mx-1">
                <x-card>
                    <div class="row">
                        @foreach ($scorings->groupBy('category') as $grouped)
                            <div class="col border p-0" style="position: relative">
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
                <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="edit-save" face="success" icon="bx bxs-save">Simpan</x-button>
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
        let table = null
        let guaranteeBank = null
        $(document).ready(function () {
            table = dataTableInit('table','Bank Garansi',{url : '{{ route('products.guarantee-banks.index') }}'},[
                {data: 'receipt_number', name: 'receipt_number'},
                {data: 'bond_number', name: 'bond_number'},
                {data: 'polish_number', name: 'polish_number'},
                {data: 'last_status.status.name', name: 'last_status.status.name',orderable:false},
                {data: 'insurance_value', name: 'insurance_value'},
                {data: 'start_date', name: 'start_date'},
            ])
            select2Init("#create-agent-id",'{{ route('select2.agent') }}',0,$('#modal-create'))
            select2Init("#create-obligee-id",'{{ route('select2.obligee') }}',0,$('#modal-create'))
            select2Init("#create-principal-id",'{{ route('select2.principal') }}',0,$('#modal-create'))
            select2Init("#create-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-create'))
            select2Init("#create-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-create'))
            select2Init("#create-bank-id",'{{ route('select2.bank') }}',0,$('#modal-create'))

            select2Init("#edit-agent-id",'{{ route('select2.agent') }}',0,$('#modal-edit'))
            select2Init("#edit-obligee-id",'{{ route('select2.obligee') }}',0,$('#modal-edit'))
            select2Init("#edit-principal-id",'{{ route('select2.principal') }}',0,$('#modal-edit'))
            select2Init("#edit-insurance-id",'{{ route('select2.insurance') }}',0,$('#modal-edit'))
            select2Init("#edit-insurance-type-id",'{{ route('select2.insuranceType') }}',0,$('#modal-edit'))
            select2Init("#edit-bank-id",'{{ route('select2.bank') }}',0,$('#modal-edit'))
        })
        $(document).on('click', '#create-save', function () {
            loading()
            ajaxPost("{{ route('products.guarantee-banks.store') }}",fetchFormData(new FormData(document.getElementById('form-create'))),'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })
        $(document).on('change', '#create-obligee-id, #edit-obligee-id', function () {
            const action = $(this).attr('id').split('-')[0] //create or edit
            ajaxGet('{{ route('master.obligees.show','-id-') }}'.replace('-id-',$(this).val()),null,function(response){
               $('#'+action+'-obligee-address').html(response.data.address)
            })
        })
        $(document).on('change', '#create-principal-id, #edit-principal-id', function () {
            const action = $(this).attr('id').split('-')[0] //create or edit
            ajaxGet('{{ route('master.principals.show','-id-') }}'.replace('-id-',$(this).val()),null,function(response){
                const data = response.data
                $('#'+action+'-principal-address').html(data.address)
                $('#'+action+'-pic-name').html(data.pic_name)
                $('#'+action+'-pic-position').html(data.pic_position)
            })
        })
        $(document).on('input', '#create-start-date, #create-end-date, #edit-start-date, #edit-end-date, .create-due-day-tolerance, .edit-due-day-tolerance', function () {
            const split = $(this).attr('id').split('-')
            let dayCount = (split[1]  == 'due') ? parseInt(calculateDayFromDates('start',split[0])) : calculateDayFromDates(split[1],split[0])
            $('#'+split[0]+'-day-count-input').val(dayCount)
            $('#'+split[0]+'-day-count').html(dayCount)
        })
        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('products.guarantee-banks.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    guaranteeBank = response.data
                    $('#show-receipt-number').html(guaranteeBank.receipt_number)
                    $('#show-bond-number').html(guaranteeBank.bond_number)
                    $('#show-polish-number').html(guaranteeBank.polish_number)
                    $('#show-agent').html(guaranteeBank.agent.name)
                    $('#show-bank').html(guaranteeBank.bank.name)
                    $('#show-insurance-type').html(guaranteeBank.insurance_type.name)
                    $('#show-obligee-name').html(guaranteeBank.obligee.name)
                    $('#show-obligee-address').html(guaranteeBank.obligee.name)
                    $('#show-principal-name').html(guaranteeBank.principal.name)
                    $('#show-principal-address').html(guaranteeBank.principal.address)
                    $('#show-pic-name').html(guaranteeBank.principal.pic_name)
                    $('#show-pic-position').html(guaranteeBank.principal.pic_position)
                    $('#show-service-charge').html(numberFormat(guaranteeBank.service_charge))
                    $('#show-premi-charge').html(numberFormat(guaranteeBank.insurance_total_net))
                    $('#show-admin-charge').html(numberFormat(guaranteeBank.admin_charge))
                    $('#show-contract-value').html(numberFormat(guaranteeBank.contract_value))
                    $('#show-insurance-value').html(numberFormat(guaranteeBank.insurance_value))
                    $('#show-start-date').html(guaranteeBank.start_date)
                    $('#show-end-date').html(guaranteeBank.end_date)
                    $('#show-due-day-tolerance').html(guaranteeBank.due_day_tolerance)
                    $('#show-day-count').html(guaranteeBank.day_count)
                    $('#show-project-name').html(guaranteeBank.project_name)
                    $('#show-document-title').html(guaranteeBank.document_title)
                    $('#show-document-number').html(guaranteeBank.document_number)
                    $('#show-document-expired-at').html(guaranteeBank.document_expired_at)
                    // $('#show-desc').html()
                    // $('#show-paid-date').html()
                    // $('#show-status').html()
                    // $('#show-cancel-status').html()
                    // $('#show-sync-status').html()
                    // $('input[type="radio"]:checked').prop('checked',false)
                    const groupByCategory = scoringGroupBy(guaranteeBank.scorings)
                    Object.keys(groupByCategory).forEach(key => {
                        $('#show-scoring-category').html(key)
                        let subtotal = 0
                        groupByCategory[key].forEach(e => {
                            $('#show-scoring-score-'+e.scoring_id+'-'+e.scoring_detail_id).prop('checked',true)
                            subtotal += e.value
                        });
                        $('#show-sub-total-'+key).html(subtotal)
                    });
                }
            })
        })
        $(document).on('click', '.btn-edit', function () {
            console.log(guaranteeBank);
            $('input[type="radio"]:checked').prop('checked',false)
            select2SetVal("edit-agent-id",guaranteeBank.agent.id,guaranteeBank.agent.name)
            select2SetVal("edit-bank-id",guaranteeBank.bank.id,guaranteeBank.bank.name)
            select2SetVal("edit-insurance-type-id",guaranteeBank.insurance_type.id,guaranteeBank.insurance_type.name)
            select2SetVal("edit-obligee-id",guaranteeBank.obligee.id,guaranteeBank.obligee.name)
            select2SetVal("edit-principal-id",guaranteeBank.principal.id,guaranteeBank.principal.name)
            $('#edit-receipt-number').val(guaranteeBank.receipt_number)
            $('#edit-bond-number').val(guaranteeBank.bond_number)
            $('#edit-polish-number').val(guaranteeBank.polish_number)
            $('#edit-service-charge').val(numberFormat(guaranteeBank.service_charge))
            $('#edit-premi-charge').html(numberFormat(guaranteeBank.insurance_total_net))
            $('#edit-admin-charge').val(numberFormat(guaranteeBank.admin_charge))
            $('#edit-contract-value').val(numberFormat(guaranteeBank.contract_value))
            $('#edit-insurance-value').val(numberFormat(guaranteeBank.insurance_value))
            $('#edit-start-date').val(guaranteeBank.start_date)
            $('#edit-end-date').val(guaranteeBank.end_date)
            $('#edit-due-day-tolerance-'+guaranteeBank.due_day_tolerance).prop('checked',true).trigger('input')
            $('#edit-day-count-input').val(guaranteeBank.day_count)
            $('#edit-project-name').val(guaranteeBank.project_name)
            $('#edit-document-title').val(guaranteeBank.document_title)
            $('#edit-document-number').val(guaranteeBank.document_number)
            $('#edit-document-expired-at').val(guaranteeBank.document_expired_at)
            // $('#edit-desc').val()
            // $('#edit-paid-date').val()
            // $('#edit-status').val()
            // $('#edit-cancel-status').val()
            // $('#edit-sync-status').val()
            const groupByCategory = scoringGroupBy(guaranteeBank.scorings)
            Object.keys(groupByCategory).forEach(key => {
                groupByCategory[key].forEach(e => {
                    $('#edit-scoring-score-'+e.scoring_id+'-'+e.scoring_detail_id).prop('checked',true)
                });
            });
        })
         $(document).on('click', '#edit-save', function () {
            loading()
            ajaxPost("{{ route('products.guarantee-banks.update','-id-') }}".replace('-id-',guaranteeBank.id),fetchFormData(new FormData(document.getElementById('form-edit'))),'#modal-edit',function(){
                table.ajax.reload()
            })
        })
        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Bank Garansi?",
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxPost("{{ route('products.guarantee-banks.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method : 'delete'},'',function(response){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush