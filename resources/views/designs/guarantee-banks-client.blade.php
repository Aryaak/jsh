@extends('layouts.client', ['title' => 'Request Bank Garansi'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Request Bank Garansi">
        <div class="border rounded p-2" style="background-color: #EEE">
            <x-form id="form-create" method="post">
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Bank Garansi</div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-lg-row flex-wrap gap-2">
                    <div style="flex: 25%;">
                        <div class="w-100 mb-2">
                            <x-card header="1. Data" smallHeader>
                                <x-form-input label="No. Kwitansi" id="create-receipt-number" name="receiptNumber" class="mb-3" required />
                                <x-form-input label="No. Bond" id="create-bond-number" name="bondNumber" class="mb-3" />
                                <x-form-input label="No. Polis" id="create-polish-number" name="polishNumber" class="mb-3" />
                                <x-form-select label="Nama Agen" id="create-agent-id" :options="[]" name="agentId" class="mb-3" required/>
                                <x-form-select label="Nama Bank" id="create-bank-id" :options="[]" name="bankId" class="mb-3" required/>
                                <x-form-select label="Nama Asuransi" id="create-insurance-id" :options="[]" name="insuranceId" class="mb-3" required/>
                                <x-form-select label="Jenis Jaminan" id="create-insurance-type-id" :options="[]" name="insuranceType" required/>
                            </x-card>
                        </div>
                    </div>
                    <div style="flex: 25%;">
                        <div class="w-100 mb-2">
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
                    </div>
                    <div style="flex: 25%;">
                        <div class="w-100 mb-2">
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
                    <div style="flex: 25%;">
                        <div class="w-100 mb-2">
                            <x-card header="4. Obligee" smallHeader>
                                <x-form-select label="Nama" id="create-obligee-id" :options="[]" name="obligeeId" class="mb-3" required/>
                                <div>
                                    <x-form-label>Alamat</x-form-label>
                                    <div id="create-obligee-address">-</div>
                                </div>
                            </x-card>
                        </div>
                    </div>
                    <div style="flex: 25%;">
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
                            <div class="border p-0" style="position: relative; flex: 100%;">
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
                            <div class="border p-0" style="position: relative; flex: 100%;">
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
                            <div class="border p-0" style="position: relative; flex: 100%;">
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
                            <div class="border p-0" style="position: relative; flex: 100%;">
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
        </div>
        @slot('footer')
            <div class="text-end">
                <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
            </div>
        @endslot
    </x-card>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $("#table").DataTable()
            $("#create-agent-id, #create-bank-id, #create-insurance-id, #create-insurance-type-id, #create-principal-id, #create-obligee-id").select2()
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
