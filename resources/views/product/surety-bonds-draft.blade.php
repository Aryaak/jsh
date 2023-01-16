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
                    <th>No. Bond</th>
                    <th>No. Polis</th>
                    <th>Nama Principal</th>
                    <th>Status Jaminan</th>
                    <th>Nilai Jaminan</th>
                    <th>Tanggal</th>
                    <th width="105px">Tindakan</th>
                </tr>
            @endslot
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
                    <x-card header="Data" smallHeader>
                        <div class="mb-3">
                            <x-form-label>Nama Cabang</x-form-label>
                            <div id="show-branch-name">-</div>
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
                            <x-form-label>Tanggal Dokumen Pendukung</x-form-label>
                            <div id="show-document-expired-at">-</div>
                        </div>
                    </x-card>
                </div>
            </div>
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
        let table = null
        let suretyBond = null
        $(document).ready(function () {
            table = dataTableInit('table','Draf Surety Bond',{url : '{{ route($global->currently_on.'.products.draft.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '']) }}'},[
                {data: 'bond_number', name: 'bond_number'},
                {data: 'polish_number', name: 'polish_number'},
                {data: 'principal.name', name: 'principal.name'},
                {data: 'approved_status', name: 'approved_status'},
                {data: 'insurance_value', name: 'insurance_value'},
                {data: 'start_date', name: 'start_date'},
            ])
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route($global->currently_on.'.products.draft.show', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond_draft' => '-id-']) }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    suretyBond = response.data
                    $('#show-branch-name').html(suretyBond.branch.regional.name+' - '+suretyBond.branch.name)
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
                }
            })
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus draf surety bond ini?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('branch.products.draft.destroy', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond_draft' => '-id-']) }}".replace('-id-',$(this).data('id')),{_method : 'delete'},'',function(response){
                        table.ajax.reload()
                    })
                }
            })
        })

        $(document).on('click', '.btn-approve', function () {
            // Delete
            Confirm.fire({
                title: "Yakin ingin menyetujui Draf Surety Bond?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('branch.products.client.approve', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond_draft' => '-id-']) }}".replace('-id-',suretyBond.id),{_method : 'post'},'',function(response){
                        table.ajax.reload()
                        $("#modal-show").modal('hide')
                    })
                }
            })
        })

        $(document).on('click', '.btn-decline', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menolak Draf Surety Bond?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('branch.products.client.decline', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'surety_bond_draft' => '-id-']) }}".replace('-id-',suretyBond.id),{_method : 'put'},'',function(response){
                        table.ajax.reload()
                        $("#modal-show").modal('hide')
                    })
                }
            })
        })
    </script>
@endpush
