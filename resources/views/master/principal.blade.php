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
                    <th>Skor</th>
                    {{-- <th>Status Sinkronisasi</th> --}}
                    <th width="105px">Tindakan</th>
                </tr>
            @endslot
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
                    <x-form-input label="Jamsyar ID" id="create-info-jamsyar-id" name="info[jamsyarId]" class="mb-3" />
                    <x-form-input label="Jamsyar Kode" id="create-info-jamsyar-code" name="info[jamsyarCode]" class="mb-3" />
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
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Daftar Akta Pendirian</div>
                    </div>
                    <x-button id="create-new-certificate" icon="bx bx-plus">Tambah Akta Pendirian</x-button>
                    <div id="create-certificate-container" class="row">
                        {{-- Tempat Tambah Akta Pendirian --}}
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
                                @foreach ($scorings as $scoring)
                                    <x-form-check id="create-scoring-score-{{ $scoring->id }}" input-class="create-scoring" name="scoring[{{ $scoring->id }}]" value="1">{{ $scoring->title }}</x-form-check>
                                @endforeach
                            </div>
                        </div>
                        <div class="my-3">
                            Total Nilai: <b id="create-total-score">0</b>
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
                    <div class="h5 fw-bold border-bottom mb-3 pb-2">Daftar Akta Pendirian</div>
                </div>
                <div id="show-certificate-container" class="row">
                    {{-- START Copy ini saat looping akta --}}
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
                    {{-- END Copy ini saat looping akta --}}
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
                            @foreach ($scorings as $scoring)
                                <x-form-check id="show-scoring-score-{{ $scoring->id }}" name="scoring[{{ $scoring->id }}]" value="1" disabled>{{ $scoring->title }}</x-form-check>
                            @endforeach
                        </div>
                    </div>
                    <div class="my-3">Total Nilai: <b><span id="show-score"></span></b></div>
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
                    <x-form-select label="Provinsi" id="edit-info-province-id" name="info[provinceId]" class="mb-3" required />
                    <x-form-select label="Kota" id="edit-info-city-id" name="info[cityId]" class="mb-3" required />
                    <x-form-input label="Jamsyar ID" id="edit-info-jamsyar-id" name="info[jamsyarId]" class="mb-3" />
                    <x-form-input label="Jamsyar Kode" id="edit-info-jamsyar-code" name="info[jamsyarCode]" class="mb-3" />
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
                        <div class="h5 fw-bold border-bottom mb-3 pb-2">Daftar Akta Pendirian</div>
                    </div>
                    <x-button id="edit-new-certificate" icon="bx bx-plus">Tambah Akta Pendirian</x-button>
                    <div id="edit-certificate-container" class="row">
                        {{-- Tempat Tambah Akta Pendirian --}}
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
                                @foreach ($scorings as $scoring)
                                    <x-form-check id="edit-scoring-score-{{ $scoring->id }}" input-class="edit-scoring" name="scoring[{{ $scoring->id }}]" value="1">{{ $scoring->title }}</x-form-check>
                                @endforeach
                            </div>
                        </div>
                        <div class="my-3">
                            <div>Total Nilai: <b><span id="edit-total-score">0</span></b></div>
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
        let table = null
        let principal = null
        var createCertificateCounter = 0
        var editCertificateCounter = 0

        $(document).ready(function () {
            table = dataTableInit('table','Principal',{url : '{{ route($global->currently_on.'.master.principals.index', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}'},[
                {data: 'name', name: 'name'},
                {data: 'address', name: 'address'},
                {data: 'phone', name: 'phone'},
                {data: 'score', name: 'score'},
                // {data: 'phone', name: 'phone'},
            ])

            select2Init("#create-info-province-id, #edit-info-province-id",'{{ route('select2.province') }}',0,$('#modal-create'))
            select2Init("#create-info-city-id",'{{ route('select2.city') }}',0,$('#modal-create'),'--  Pilih --',false,function(params){
                return {
                    search: params.term ?? '',
                    province_id: $('#create-info-province-id').val()
                }
            })
            select2Init("#edit-info-province-id",'{{ route('select2.province') }}',0,$('#modal-edit'))
            select2Init("#edit-info-city-id",'{{ route('select2.city') }}',0,$('#modal-edit'),'--  Pilih --',false,function(params){
                return {
                    search: params.term ?? '',
                    province_id: $('#edit-info-province-id').val()
                }
            })
        })

        $(document).on('click', '.create-scoring, .edit-scoring', function () {
            const creadit = $(this).attr('id').split('-')[0]
            var totalScore = $('.'+creadit+'-scoring:checkbox:checked').length / $('.'+creadit+'-scoring:checkbox').length * 10
            totalScore = String(totalScore).replace('.', ',')
            $('#'+creadit+'-total-score').removeClass().html(totalScore).addClass(setScoreColor(totalScore))
        })
        $(document).on('click', '#create-save', function () {
            loading()
            ajaxPost("{{ route('master.principals.store') }}",new FormData(document.getElementById('form-create')),'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })

        $(document).on('click', '#edit-save', function () {
            loading()
            ajaxPost("{{ route('master.principals.update','-id-') }}".replace('-id-',principal.id),new FormData(document.getElementById('form-edit')),'#modal-edit',function(){
                table.ajax.reload()
            })
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.principals.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    principal = response.data
                    $('#show-name').html(principal.name)
                    $('#show-email').html(principal.email)
                    $('#show-phone').html(principal.phone)
                    $('#show-domisile').html(principal.domicile)
                    $('#show-province').html(principal.city.province.name)
                    $('#show-city').html(principal.city.name)
                    $('#show-address').html(principal.address)
                    $('#show-jamsyar-id').html(principal.jamsyar_id)
                    $('#show-pic-name').html(principal.pic_name)
                    $('#show-pic-position').html(principal.pic_position)
                    $('#show-npwp-number').html(principal.npwp_number)
                    $('#show-npwp-expired-at').html(principal.npwp_expired_at_converted)
                    $('#show-nib-number').html(principal.nib_number)
                    $('#show-nib-expired-at').html(principal.nib_expired_at_converted)
                    $('#show-status').html(principal.status)
                    $('#show-jamsyar-code').html(principal.jamsyar_code)
                    $('#show-score').removeClass().html(principal.score).addClass(setScoreColor(principal.score))
                    $('input[type="checkbox"]:checked').prop('checked',false)
                    principal.scorings.forEach(e => { $('#show-scoring-score-'+e.id).prop('checked',true) });
                    let html = ''
                    principal.certificates.forEach(e => {
                       html += "<div id='show-certificate-1' class='mt-4 col-md-6'>"+
                            "<div class='border rounded p-3'>"+
                                "<div class='border-bottom pb-2 mb-2'><b>Nomor</b>: <br><span id='show-certificate-number-"+e.id+"'>"+e.number+"</span></div>"+
                                "<div><b>Berlaku Hingga</b>: <br><span id='show-certificate-expired-at-"+e.id+"'>"+e.expired_at+"</span></div>"+
                            "</div>"+
                        "</div>"
                    });
                    $('#show-certificate-container').html(html)
                }
            })
        })

        $(document).on('click', '.btn-edit', function () {
            $('#edit-info-name').val(principal.name)
            $('#edit-info-email').val(principal.email)
            $('#edit-info-phone').val(principal.phone)
            $('#edit-info-domicile').val(principal.domicile)
            select2SetVal('edit-info-province-id',principal.city.province.id,principal.city.province.name)
            select2SetVal('edit-info-city-id',principal.city.id,principal.city.name)
            $('#edit-info-pic-name').val(principal.pic_name)
            $('#edit-info-pic-position').val(principal.pic_position)
            $('#edit-info-npwp-number').val(principal.npwp_number)
            $('#edit-info-npwp-expired-at').val(principal.npwp_expired_at)
            $('#edit-info-nib-number').val(principal.nib_number)
            $('#edit-info-nib-expired-at').val(principal.nib_expired_at)
            $('#edit-info-address').val(principal.address)
            $('#edit-info-jamsyar-id').val(principal.jamsyar_id)
            $('#edit-info-jamsyar-code').val(principal.jamsyar_code)
            $('#edit-total-score').removeClass().html(principal.score).addClass(setScoreColor(principal.score))
            $('input[type="checkbox"]:checked').prop('checked',false)
            principal.scorings.forEach(e => { $('#edit-scoring-score-'+e.id).prop('checked',true) });
            counter = 0
            principal.certificates.forEach(e => {
                $("#edit-certificate-container").append(`
                <div id="edit-certificate-` + counter + `" class="mt-4 col-md-6">
                    <div class="border rounded p-3">
                        <input type="hidden" id="edit-certificate-id" name="certificate[id][]" />
                        <x-button class="btn-delete-certificate w-100 mb-3" face='danger' icon="bx bx-trash" size='sm'>Hapus Sertifikat</x-button>
                        <x-form-input label="Nomor" id="edit-certificate-number-` + counter + `" name="certificate[number][]" value="`+e.number+`" class="mb-3" required />
                        <x-form-input label="Berlaku Hingga" id="edit-certificate-expired-at-` + counter + `" name="certificate[expiredAt][]" value="`+e.expired_at+`" class="mb-3" type="date" required />
                    </div>
                </div>
            `)
            counter++
            });
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Principal?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('master.principals.destroy','-id-') }}".replace('-id-',$(this).data('id')),{_method: 'delete'},'',function(){
                        table.ajax.reload()
                    })
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
                title: "Ingin menghapus akta ini?"
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
                inputId = `<input type="hidden" id="edit-certificate-id" name="certificate[id][]" />`
            }

            $("#" + createOrEdit + "-certificate-container").append(`
                <div id="` + createOrEdit + `-certificate-` + counter + `" class="mt-4 col-md-6">
                    <div class="border rounded p-3">
                        ` + inputId + `
                        <x-button class="btn-delete-certificate w-100 mb-3" face='danger' icon="bx bx-trash" size='sm'>Hapus Akta Pendirian</x-button>
                        <x-form-input label="Nomor" id="` + createOrEdit + `-certificate-number-` + counter + `" name="certificate[number][]" class="mb-3" required />
                        <x-form-input label="Berlaku Hingga" id="` + createOrEdit + `-certificate-expired-at-` + counter + `" name="certificate[expiredAt][]" class="mb-3" type="date" required />
                    </div>
                </div>
            `)
        }
        function setScoreColor(value){
            value = parseFloat(value.replace(',', '.'))
            let color = 'text-danger'
            if(value >= 6.6){
                color = 'text-success'
            }else if(value >= 3.3){
                color = 'text-warning'
            }
            return color
        }
    </script>
@endpush
