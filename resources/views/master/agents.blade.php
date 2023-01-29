@extends('layouts.main', ['title' => 'Agen'])

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@section('contents')
    <x-card header="Daftar Agen">
        @slot('headerAction')
            <x-button data-bs-toggle="modal" data-bs-target="#modal-create" size="sm" icon="bx bx-plus">Tambah Agen</x-button>
        @endslot

        <x-table id="table">
            @slot('thead')
                <tr>
                    <th width="10px">No.</th>
                    <th>Cabang</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th width="80px">Tindakan</th>
                </tr>
            @endslot
        </x-table>
    </x-card>
@endsection

@section('modals')
    <x-modal id="modal-create" title="Tambah Agen">
        <x-form id="form-create" method="post">
            <x-form-select label="Cabang" id="create-branch-id" name="branch_id" class="mb-3" required/>
            <x-form-input label="Nama" id="create-name" name="name" class="mb-3" required />
            <x-form-input label="No. HP" id="create-phone" name="phone" class="mb-3" required />
            <x-form-input label="Alamat Email" id="create-email" name="email" class="mb-3" type="email" required/>
            <x-form-input label="Nomor Identitas" id="create-identity-number" name="identity_number" class="mb-3" required/>
            <x-form-textarea label="Alamat" id="create-address" name="address" class="mb-3" required/>
            <x-form-select label="Nama Bank" id="create-bank-id" :options="[]" name="bank_id" class="mb-3" required/>
            <x-form-input label="No. Rekening" id="create-bank-number" name="number" class="mb-3" required/>
            <x-form-input label="Atas Nama Rekening" id="create-bank-owner-name" name="name_bank" class="mb-3" required/>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <x-form-label for="create-is-verified">Sudah Diverifikasi?</x-form-label>
                    <x-form-check id="create-is-verified" type="switch" name="is_verified" value=1></x-form-check>
                </div>
                <div class="col-sm-6">
                    <x-form-label for="create-is-active">Status Aktif</x-form-label>
                    <x-form-check id="create-is-active" type="switch" name="is_active" value=1></x-form-check>
                </div>
            </div>
        </x-form>

        @slot('footer')
            <x-button id="create-save" face="success" icon="bx bxs-save">Simpan</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-show" title="Detail Agen">
        <div class="mb-5 text-center">
            <small>Cabang:</small>
            <div id="show-branch" class="h4 mb-2 fw-bold">-</div>
        </div>

        <div class="border-bottom pb-2 mb-2">
            <b>Nama</b>: <br>
            <span id="show-name">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>No. HP</b>: <br>
            <span id="show-phone">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat Email</b>: <br>
            <span id="show-email">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Alamat</b>: <br>
            <span id="show-address">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Nama Bank</b>: <br>
            <span id="show-bank">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>No. Rekening</b>: <br>
            <span id="show-bank-number">-</span>
        </div>
        <div class="border-bottom pb-2 mb-2">
            <b>Atas Nama Rekening</b>: <br>
            <span id="show-bank-owner">-</span>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <b>Sudah Diverifikasi</b>: <br>
                <span id="show-is-verified"><x-badge face="label-success" rounded>Sudah</x-badge></span>
            </div>
            <div class="col-sm-6">
                <b>Status Aktif</b>: <br>
                <span id="show-is-active"><x-badge face="label-success" rounded>Tidak Aktif</x-badge></span>
            </div>
        </div>

        @slot('footer')
            <x-button class="btn-edit" data-bs-target="#modal-edit" data-bs-toggle="modal" data-bs-dismiss="modal" face="warning" icon="bx bxs-edit">Ubah</x-button>
        @endslot
    </x-modal>

    <x-modal id="modal-edit" title="Ubah Agen">
        <x-form id="form-edit" method="put">
            <x-form-select label="Cabang" id="edit-branch-id" :options="[]" name="branch_id" class="mb-3" required/>
            <x-form-input label="Nama" id="edit-name" name="name" class="mb-3" required />
            <x-form-input label="No. HP" id="edit-phone" name="phone" class="mb-3" required />
            <x-form-input label="Alamat Email" id="edit-email" name="email" class="mb-3" type="email" required/>
            <x-form-input label="Nomor Identitas" id="edit-identity-number" name="identity_number" class="mb-3" required/>
            <x-form-textarea label="Alamat" id="edit-address" name="address" class="mb-3" required/>
            <x-form-select label="Nama Bank" id="edit-bank-id" name="bank_id" class="mb-3" required/>
            <x-form-input label="No. Rekening" id="edit-bank-number" name="number" class="mb-3" required/>
            <x-form-input label="Atas Nama Rekening" id="edit-bank-owner-name" name="name_bank" class="mb-3" required/>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <x-form-label for="edit-is-verified">Sudah Diverifikasi?</x-form-label>
                    <x-form-check id="edit-is-verified" type="switch" name="is_verified" value=1></x-form-check>
                </div>
                <div class="col-sm-6">
                    <x-form-label for="edit-is-active">Status Aktif</x-form-label>
                    <x-form-check id="edit-is-active" type="switch" name="is_active" value=1></x-form-check>
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
        let agent = null
        $(document).ready(function () {
            table = dataTableInit('table','Agen',{url : '{{ route($global->currently_on.'.master.agents.index', ['regional' => $global->regional ?? '', 'branch' => $global->branch ?? '']) }}'},[
                {data: 'branch.name', name: 'branch.name'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
            ],{
                order: [[1,'asc']],
            })

            select2Init("#create-branch-id",'{{ route('select2.branch') }}',0,$('#modal-create'))
            select2Init("#edit-branch-id",'{{ route('select2.branch') }}',0,$('#modal-edit'))

            select2Init("#create-bank-id",'{{ route('select2.bank') }}',0,$('#modal-create'))
            select2Init("#edit-bank-id",'{{ route('select2.bank') }}',0,$('#modal-edit'))
        })

        $(document).on('click', '#create-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-create'))
            if (document.getElementById('create-is-verified').checked == false) {
                formData.append('is_verified',0)
            }
            if (document.getElementById('create-is-active').checked == false) {
                formData.append('is_active',0)
            }
            ajaxPost("{{ route('master.agents.store') }}",formData,'#modal-create',function(){
                table.ajax.reload()
                clearForm('#form-create')
            })
        })

        $(document).on('click', '.btn-show', function () {
            ajaxGet("{{ route('master.agents.show','-id-') }}".replace('-id-',$(this).data('id')),'',function(response){
                if(response.success){
                    agent = response.data
                    $('#show-branch').html(agent.branch.name)
                    $('#show-name').html(agent.name)
                    $('#show-phone').html(agent.phone)
                    $('#show-email').html(agent.email)
                    $('#show-address').html(agent.address)
                    $('#show-bank').html(agent.bank_accounts.bank.name)
                    $('#show-bank-number').html(agent.bank_accounts.number)
                    $('#show-bank-owner').html(agent.bank_accounts.name)
                    if(agent.is_verified == 1){
                        $('#show-is-verified').html(`
                            <x-badge face="label-success" rounded>Sudah</x-badge>
                        `)

                    }else{
                        $('#show-is-verified').html(`
                            <x-badge face="label-danger" rounded>Belum</x-badge>
                        `)
                    }

                    if(agent.is_active == 1){
                        $('#show-is-active').html(`
                            <x-badge face="label-success" rounded>Aktif</x-badge>
                        `)

                    }else{
                        $('#show-is-active').html(`
                            <x-badge face="label-danger" rounded>Belum Aktif</x-badge>
                        `)
                    }
                }
            })
        })

        $(document).on('click', '.btn-edit', function () {
            let formData = new FormData(document.getElementById('form-edit'))
            $('#edit-branch-id').append(new Option(agent.branch.name,agent.branch.id,true,true)).trigger('change');
            $('#edit-name').val(agent.name)
            $('#edit-phone').val(agent.phone)
            $('#edit-email').val(agent.email)
            $('#edit-address').val(agent.address)
            $('#edit-identity-number').val(agent.identity_number)
            $('#edit-bank-id').append(new Option(agent.bank_accounts.bank.name,agent.bank_accounts.bank.id,true,true)).trigger('change');
            $('#edit-bank-number').val(agent.bank_accounts.number)
            $('#edit-bank-owner-name').val(agent.bank_accounts.name)
            if(agent.is_verified == 1){
                document.getElementById("edit-is-verified").checked = true;
            }else{
                document.getElementById("edit-is-verified").checked = false;
            }

            if(agent.is_active == 1){
                document.getElementById("edit-is-active").checked = true;
            }else{
                document.getElementById("edit-is-active").checked = false;
            }
        })

        $(document).on('click', '#edit-save', function () {
            loading()
            let formData = new FormData(document.getElementById('form-edit'))
            formData.append("bank_account_id",agent.bank_accounts.id)
            formData.append("agent_id",agent.id)
            if (document.getElementById('edit-is-verified').checked == false) {
                formData.append('is_verified',0)
            }
            if (document.getElementById('edit-is-active').checked == false) {
                formData.append('is_active',0)
            }
            ajaxPost("{{ route('master.agents.update','-id-') }}".replace('-id-',agent.id),formData,'#modal-edit',function(){
                table.ajax.reload()
            })
        })

        $(document).on('click', '.btn-delete', function () {
            // Delete
            NegativeConfirm.fire({
                title: "Yakin ingin menghapus agen " + $(this).data('name') + "?",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading()
                    let formData = new FormData()
                    formData.append('_method','delete')
                    ajaxPost("{{ route('master.agents.destroy','-id-') }}".replace('-id-',$(this).data('id')),formData,'',function(){
                        table.ajax.reload()
                    })
                }
            })
        })
    </script>
@endpush
