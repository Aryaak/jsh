@extends('layouts.main', ['title' => 'Draf Bank Garansi'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Draf Bank Garansi">
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
    <x-modal id="modal-show" title="Detail Bank Garansi" size="fullscreen" darkBody>
        <div class="row mb-4">
            <div class="col-12 text-center">
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Informasi Bank Garansi</div>
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
                <div class="w-100 mb-3">
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
                <div class="h5 fw-bold border-bottom mb-3 pb-2">Scoring Bank Garansi</div>
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
        let table = null
        let guaranteeBank = null
        $(document).ready(function () {
            table = dataTableInit('table','Bank Garansi Draft',{url : '{{ route($global->currently_on.'.products.draft.bg.index', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '']) }}'},[
                {data: 'receipt_number', name: 'receipt_number'},
                {data: 'bond_number', name: 'bond_number'},
                {data: 'polish_number', name: 'polish_number'},
                {data: 'principal.name', name: 'principal.name'},
                {data: 'insurance_status.status.name', name: 'insurance_status.status.name',orderable:false},
                {data: 'insurance_value', name: 'insurance_value'},
                {data: 'start_date', name: 'start_date'},
            ])
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route($global->currently_on.'.products.draft.bg.show', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'bank_garansi_draft' => '-id-']) }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    guaranteeBank = response.data
                    $('#show-receipt-number').html(guaranteeBank.receipt_number)
                    $('#show-bond-number').html(guaranteeBank.bond_number)
                    $('#show-polish-number').html(guaranteeBank.polish_number)
                    $('#show-agent').html(guaranteeBank.agent.name)
                    $('#show-bank').html(guaranteeBank.bank.name)
                    $('#show-insurance').html(guaranteeBank.insurance.name)
                    $('#show-insurance-type').html(guaranteeBank.insurance_type.name)
                    $('#show-obligee-name').html(guaranteeBank.obligee.name)
                    $('#show-obligee-address').html(guaranteeBank.obligee.name)
                    $('#show-principal-name').html(guaranteeBank.principal.name)
                    $('#show-principal-address').html(guaranteeBank.principal.address)
                    $('#show-pic-name').html(guaranteeBank.principal.pic_name)
                    $('#show-pic-position').html(guaranteeBank.principal.pic_position)
                    $('#show-service-charge').html(guaranteeBank.service_charge_converted)
                    $('#show-admin-charge').html(guaranteeBank.admin_charge_converted)
                    $('#show-premi-charge').html(guaranteeBank.total_charge_converted)
                    $('#show-contract-value').html(guaranteeBank.contract_value_converted)
                    $('#show-insurance-value').html(guaranteeBank.insurance_value_converted)
                    $('#show-start-date').html(guaranteeBank.start_date_converted)
                    $('#show-end-date').html(guaranteeBank.end_date_converted)
                    $('#show-due-day-tolerance').html(guaranteeBank.due_day_tolerance)
                    $('#show-day-count').html(guaranteeBank.day_count)
                    $('#show-project-name').html(guaranteeBank.project_name)
                    $('#show-document-title').html(guaranteeBank.document_title)
                    $('#show-document-number').html(guaranteeBank.document_number)
                    $('#show-document-expired-at').html(guaranteeBank.document_expired_at_converted)
                    $('#show-insurance-rate').html(guaranteeBank.insurance_rate)
                    $('#show-insurance-polish-cost').html(guaranteeBank.insurance_polish_cost_converted)
                    $('#show-insurance-stamp').html(guaranteeBank.insurance_stamp_cost_converted)
                    $('#show-premi-nett').html(guaranteeBank.insurance_net_converted)
                    $('#show-premi-nett-total').html(guaranteeBank.insurance_net_total_converted)
                    $('#show-office-rate').html(guaranteeBank.office_rate)
                    $('#show-office-nett').html(guaranteeBank.office_net_converted)
                    $('#show-office-nett-total').html(guaranteeBank.office_net_total_converted)
                    $('#show-office-polish-cost').html(guaranteeBank.office_polish_cost_converted)
                    $('#show-office-stamp-cost').html(guaranteeBank.office_stamp_cost_converted)
                    $('#show-profit').html(guaranteeBank.profit_converted)
                    $('input[type="radio"]:checked').prop('checked',false)
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

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus Surety Bond?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('branch.products.draft.bg.destroy', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'bank_garansi_draft' => '-id-']) }}".replace('-id-',$(this).data('id')),{_method : 'delete'},'',function(response){
                        table.ajax.reload()
                    })
                }
            })
        })

        $(document).on('click', '.btn-approve', function () {
            // Delete
            Confirm.fire({
                title: "Yakin ingin menyetujui Draf Bank Garansi?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('branch.products.client.approve.bg', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'bank_garansi_draft' => '-id-']) }}".replace('-id-',guaranteeBank.id),{_method : 'post'},'',function(response){
                        table.ajax.reload()
                        $("#modal-show").modal('hide')
                    })
                }
            })
        })

        $(document).on('click', '.btn-decline', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menolak Draf Bank Garansi?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    ajaxPost("{{ route('branch.products.client.decline.bg', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug ?? '', 'bank_garansi_draft' => '-id-']) }}".replace('-id-',guaranteeBank.id),{_method : 'put'},'',function(response){
                        table.ajax.reload()
                        $("#modal-show").modal('hide')
                    })
                }
            })
        })
    </script>
@endpush
