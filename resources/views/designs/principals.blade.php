@extends('layouts.main', ['title' => 'Principal'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Principal">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Principal</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP/Telp</th>
                    <th>Status Sinkronisasi</th>
                    <th width="105px">Tindakan</th>
                </tr>
            @endslot
            <tr>
                <td>1</td>
                <td>Tes</td>
                <td>Tes</td>
                <td>Tes</td>
                <td><x-badge face="label-success">Sinkron</x-badge></td>
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
    <x-modal id="modal-create" title="Tambah Principal" size="fullscreen">
        <x-form id="form-create" method="post">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Principal</div>
                </div>
                <div class="col-md-6">
                    <x-form-input label="Nama Principal" id="create-info-name" name="info[name]" class="mb-3" required />
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

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="w-100 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Daftar Akta Pembangunan</div>
                    </div>
                    <x-button id="create-new-certificate" icon="bx bx-plus">Tambah Sertifikat Pembangunan</x-button>
                    <div id="create-certificate-container" class="row">
                        {{-- Tempat Tambah Sertifikat Pembangunan --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="w-100 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Principal</div>
                    </div>
                    <div class="col-md-3" style="margin: 0 auto">
                        <div class="border rounded p-0">
                            <div class="p-3">
                                <x-form-check id="create-scoring-score-1" name="scoring[score[]]" value="10">Name</x-form-check>
                                <x-form-check id="create-scoring-score-2" name="scoring[score[]]" value="10">Name</x-form-check>
                            </div>
                        </div>
                        <div class="my-3">
                            Total Nilai: <b>69</b>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Principal" size="fullscreen">
        <div class="row mb-2">
            <div class="col-12 text-center">
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Principal</div>
            </div>
            <div class="col-md-6">
                <div class="border-bottom pb-2 mb-2">
                    <b>Nama Principal</b>: <br>
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

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="w-100 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Daftar Akta Pembangunan</div>
                </div>
                <div id="show-certificate-container" class="row">
                    {{-- START Copy ini saat looping sertifikat --}}
                    <div id="show-certificate-1" class="mt-4 col-md-6">
                        <div class="border rounded p-3">
                            <div class="border-bottom pb-2 mb-2">
                                <b>Nomor</b>: <br>
                                <span id="show-certificate-number-1">-</span>
                            </div>
                            <div>
                                <b>Berlaku Hingga</b>: <br>
                                <span id="show-certificate-expired-at-1">-</span>
                            </div>
                        </div>
                    </div>
                    {{-- END Copy ini saat looping sertifikat --}}
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="w-100 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Principal</div>
                </div>
                <div class="col-md-3" style="margin: 0 auto">
                    <div class="border rounded p-0">
                        <div class="p-3">
                            <x-form-check id="show-scoring-score-1" name="scoring[score[]]" value="10">Name</x-form-check>
                            <x-form-check id="show-scoring-score-2" name="scoring[score[]]" value="10">Name</x-form-check>
                        </div>
                    </div>
                    <div class="my-3">Total Nilai: <b>69</b></div>
                </div>
            </div>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Principal" size="fullscreen">
        <x-form id="form-edit" method="put">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Principal</div>
                </div>
                <div class="col-md-6">
                    <x-form-input label="Nama Principal" id="edit-info-name" name="info[name]" class="mb-3" required />
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

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="w-100 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Daftar Akta Pembangunan</div>
                    </div>
                    <x-button id="edit-new-certificate" icon="bx bx-plus">Tambah Sertifikat Pembangunan</x-button>
                    <div id="edit-certificate-container" class="row">
                        {{-- Tempat Tambah Sertifikat Pembangunan --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="w-100 text-center">
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Principal</div>
                    </div>
                    <div class="col-md-3" style="margin: 0 auto">
                        <div class="border rounded p-0">
                            <div class="p-3">
                                <x-form-check id="edit-scoring-score-1" name="scoring[score[]]" value="10">Name</x-form-check>
                                <x-form-check id="edit-scoring-score-2" name="scoring[score[]]" value="10">Name</x-form-check>
                            </div>
                        </div>
                        <div class="my-3">
                            Total Nilai: <b>69</b>
                        </div>
                    </div>
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
        var createCertificateCounter = 0
        var editCertificateCounter = 0

        $(document).ready(function () {
            const table = $("#table").DataTable()
            $("#create-info-province-id, #create-info-city-id").select2({dropdownParent: $('#modal-create')})
            $("#edit-info-province-id, #edit-info-city-id").select2({dropdownParent: $('#modal-edit')})
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Principal?",
            }).then((result) => {
                if (result.isConfirmed) {
                }
            })
        })



        $("#create-new-certificate").click(function () {
            addNewCertificate('create')
        })

        $("#edit-new-certificate").click(function () {
            addNewCertificate('edit')
        })

        $(document).on('click', '.btn-delete-certificate', function () {
            NegativeConfirm.fire({
                title: "Ingin menghapus sertifikat ini?"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent().parent().remove()
                }
            })
        })

        function addNewCertificate(createOrEdit) {
            var counter = 0;
            var inputId = '';

            if (createOrEdit == 'create') {
                createCertificateCounter++
                counter = createCertificateCounter
            }
            else {
                editCertificateCounter++
                counter = editCertificateCounter
                inputId = `<input type="hidden" id="edit-certificate-id" name="certificate[id[]]" />`
            }

            $("#" + createOrEdit + "-certificate-container").append(`
                <div id="` + createOrEdit + `-certificate-` + counter + `" class="mt-4 col-md-6">
                    <div class="border rounded p-3">
                        ` + inputId + `
                        <x-button class="btn-delete-certificate w-100 mb-3" face='danger' icon="bx bx-trash" size='sm'>Hapus Sertifikat Pembangunan</x-button>
                        <x-form-input label="Nomor" id="` + createOrEdit + `-certificate-number-` + counter + `" name="certificate[number[]]" class="mb-3" required />
                        <x-form-input label="Berlaku Hingga" id="` + createOrEdit + `-certificate-expired-at-` + counter + `" name="certificate[expiredAt[]]" class="mb-3" type="date" required />
                    </div>
                </div>
            `)
        }
    </script>
@endpush
