@extends('layouts.main', ['title' => 'Principle'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Principle">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Principle</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP/Telp</th>
                    <th>Status Sinkronisasi</th>
                    <th width="260px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td><x-badge face="label-success">Sinkron</x-badge></td>
                <td>
                    <x-button class="btn-sync" size="sm"  icon="bx bx-refresh" face="warning">Sinkronkan</x-button>
                    <x-button class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info">Detail</x-button>
                    <x-button class="btn-delete" size="sm" icon="bx bxs-trash" face="danger">Hapus</x-button>
                </td>
            </tr>
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Principle" size="fullscreen">
        <x-form id="form-create" method="post">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Principle</div>
                </div>
                <div class="col-md-6">
                    <x-form-input label="Nama Principle" id="create-info-name" name="info[name]" class="mb-3" required />
                    <x-form-input label="Email" id="create-info-email" name="info[email]" class="mb-3" type="email" />
                    <x-form-input label="No. HP/Telp" id="create-info-phone" name="info[phone]" class="mb-3" />
                    <x-form-input label="Domisili" id="create-info-domicile" name="info[domicile]" class="mb-3" />
                    <x-form-select label="Provinsi" id="create-info-province-id" :options="[]" name="info[provinceId]" class="mb-3" required />
                    <x-form-select label="Kota" id="create-info-city-id" :options="[]" name="info[cityId]" class="mb-3" required />
                </div>
                <div class="col-md-6">
                    <x-form-input label="Nama PIC" id="create-info-pic-name" name="info[picName]" class="mb-3" />
                    <x-form-input label="Jabatan PIC" id="create-info-pic-position" name="info[picPosition]" class="mb-3" />
                    <x-form-input label="No. NPWP" id="create-info-npwp-number" name="info[npwpNumber]" class="mb-3" />
                    <x-form-input label="Tanggal Berakhir NPWP" id="create-info-npwp-expired-at" name="info[npwpExpiredAt]" type="date" class="mb-3" />
                    <x-form-input label="No. NIB" id="create-info-nib-number" name="info[nibNumber]" class="mb-3" />
                    <x-form-input label="Tanggal Berakhir NIB" id="create-info-nib-expired-at" name="info[nibExpiredAt]" type="date" class="mb-3" />
                </div>
                <div class="col-12">
                    <x-form-textarea label="Alamat" id="create-info-address" name="info[address]" class="mb-3" required />
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Principle</div>
                </div>
            </div>
            <div class="row mx-1">
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col-12 mt-3">
                    Total Nilai: <b>69</b>
                </div>
            </div>
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Principle" size="fullscreen">
        <div class="row mb-2">
            <div class="col-12 text-center">
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Principle</div>
            </div>
            <div class="col-md-6">
                <div class="border-bottom pb-2 mb-2">
                    <b>Nama Principle</b>: <br>
                    <span id="show-name">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Email</b>: <br>
                    <span id="show-email">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>No. HP/Telp</b>: <br>
                    <span id="show-phone">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Domisili</b>: <br>
                    <span id="show-domisile">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Provinsi</b>: <br>
                    <span id="show-province">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Kota</b>: <br>
                    <span id="show-city">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Alamat</b>: <br>
                    <span id="show-address">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>ID Jamsyar</b>: <br>
                    <span id="show-jamsyar-id">-</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border-bottom pb-2 mb-2">
                    <b>Nama PIC</b>: <br>
                    <span id="show-pic-name">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Jabatan PIC</b>: <br>
                    <span id="show-pic-position">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>No. NPWP</b>: <br>
                    <span id="show-npwp-number">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Tanggal Berakhir NPWP</b>: <br>
                    <span id="show-npwp-expired-at">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>No. NIB</b>: <br>
                    <span id="show-nib-number">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Tanggal Berakhir NIB</b>: <br>
                    <span id="show-nib-expired-at">-</span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Status Sinkronisasi</b>: <br>
                    <span id="show-status"><x-badge face="label-success">Sinkron</x-badge></span>
                </div>
                <div class="border-bottom pb-2 mb-2">
                    <b>Kode Jamsyar</b>: <br>
                    <span id="show-jamsyar-code">-</span>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 text-center">
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Principle</div>
            </div>
        </div>
        <div class="row mx-1">
            <div class="col border p-0" style="position: relative">
                <div class="border-bottom p-1 text-center">30</div>
                <div class="border-bottom p-1 text-center">Character</div>
                <div class="px-3 pt-3 pb-5">
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-1" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-2" name="" value="10" disabled>Name</x-form-check>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-3" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-4" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-5" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-6" name="" value="10" disabled>Name</x-form-check>
                    </div>
                </div>
                <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Sub Total Nilai Character:</div>
                        <div><b>20</b></div>
                    </div>
                </div>
            </div>
            <div class="col border p-0" style="position: relative">
                <div class="border-bottom p-1 text-center">20</div>
                <div class="border-bottom p-1 text-center">Capacity</div>
                <div class="px-3 pt-3 pb-5">
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-7" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-8" name="" value="10" disabled>Name</x-form-check>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-9" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-10" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-11" name="" value="10" disabled>Name</x-form-check>
                    </div>
                </div>
                <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Sub Total Nilai Capacity:</div>
                        <div><b>17</b></div>
                    </div>
                </div>
            </div>
            <div class="col border p-0" style="position: relative">
                <div class="border-bottom p-1 text-center">20</div>
                <div class="border-bottom p-1 text-center">Capital</div>
                <div class="px-3 pt-3 pb-5">
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-12" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-13" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-14" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-15" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-16" name="" value="10" disabled>Name</x-form-check>
                    </div>
                </div>
                <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Sub Total Nilai Capital:</div>
                        <div><b>16</b></div>
                    </div>
                </div>
            </div>
            <div class="col border p-0" style="position: relative">
                <div class="border-bottom p-1 text-center">17</div>
                <div class="border-bottom p-1 text-center">Condition</div>
                <div class="px-3 pt-3 pb-5">
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-17" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-18" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-19" name="" value="10" disabled>Name</x-form-check>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-23" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-24" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-25" name="" value="10" disabled>Name</x-form-check>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-26" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-27" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-28" name="" value="10" disabled>Name</x-form-check>
                    </div>
                </div>
                <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Sub Total Nilai Condition:</div>
                        <div><b>16</b></div>
                    </div>
                </div>
            </div>
            <div class="col border p-0" style="position: relative">
                <div class="border-bottom p-1 text-center">13</div>
                <div class="border-bottom p-1 text-center">Collateral</div>
                <div class="px-3 pt-3 pb-5">
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-29" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-30" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-31" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-32" name="" value="10" disabled>Name</x-form-check>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold">Kategori</div>
                        <x-form-check id="show-scoring-score-20" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-21" name="" value="10" disabled>Name</x-form-check>
                        <x-form-check id="show-scoring-score-22" name="" value="10" disabled>Name</x-form-check>
                    </div>
                </div>
                <div class="border-top py-1 px-3" style="position: absolute; bottom: 0; right: 0; left: 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Sub Total Nilai Prospect:</div>
                        <div><b>1</b></div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Total Nilai: <b>69</b></div>
                    <div>
                        <x-button face='secondary' icon="bx bxs-printer">Cetak Scoring</x-button>
                    </div>
                </div>
            </div>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Principle" size="fullscreen">
        <x-form id="form-edit" method="put">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Principle</div>
                </div>
                <div class="col-md-6">
                    <x-form-input label="Nama Principle" id="edit-info-name" name="info[name]" class="mb-3" required />
                    <x-form-input label="Email" id="edit-info-email" name="info[email]" class="mb-3" type="email" />
                    <x-form-input label="No. HP/Telp" id="edit-info-phone" name="info[phone]" class="mb-3" />
                    <x-form-input label="Domisili" id="edit-info-domicile" name="info[domicile]" class="mb-3" />
                    <x-form-select label="Provinsi" id="edit-info-province-id" :options="[]" name="info[provinceId]" class="mb-3" required />
                    <x-form-select label="Kota" id="edit-info-city-id" :options="[]" name="info[cityId]" class="mb-3" required />
                </div>
                <div class="col-md-6">
                    <x-form-input label="Nama PIC" id="edit-info-pic-name" name="info[picName]" class="mb-3" />
                    <x-form-input label="Jabatan PIC" id="edit-info-pic-position" name="info[picPosition]" class="mb-3" />
                    <x-form-input label="No. NPWP" id="edit-info-npwp-number" name="info[npwpNumber]" class="mb-3" />
                    <x-form-input label="Tanggal Berakhir NPWP" id="edit-info-npwp-expired-at" name="info[npwpExpiredAt]" type="date" class="mb-3" />
                    <x-form-input label="No. NIB" id="edit-info-nib-number" name="info[nibNumber]" class="mb-3" />
                    <x-form-input label="Tanggal Berakhir NIB" id="edit-info-nib-expired-at" name="info[nibExpiredAt]" type="date" class="mb-3" />
                </div>
                <div class="col-12">
                    <x-form-textarea label="Alamat" id="edit-info-address" name="info[address]" class="mb-3" required />
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Principle</div>
                </div>
            </div>
            <div class="row mx-1">
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col border p-0" style="position: relative">
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
                <div class="col-12 mt-3">
                    Total Nilai: <b>69</b>
                </div>
            </div>
        </x-form>

        @slot('footer')
            <div class="d-flex justify-content-between w-100">
                <x-button data-bs-target="#modal-show" data-bs-toggle="modal" data-bs-dismiss="modal" face="dark" icon="bx bx-arrow-back">Kembali</x-button>
                <x-button id="edit-save" face="success" icon="bx bxs-save">Simpan</x-button>
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
            $("#create-info-province-id, #create-info-city-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-info-province-id, #edit-info-city-id").select2({dropdownParent: $('#modal-edit')})
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Principle?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })
    </script>
@endpush
