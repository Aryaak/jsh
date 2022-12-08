@php
    $route = ($model->bank_id) ? 'guarantee-banks' : 'surety-bonds';
    $param = ($model->bank_id) ? 'bank_garansi' : 'surety_bond';
@endphp
{{-- <x-button type="icon" class="btn-sync" size="sm" icon="bx bx-refresh" face="warning" data-id="{{ $model->id }}">Sync</x-button> --}}
<x-button type="icon" size="sm" icon="bx bxs-printer" face="dark" link="{{ route('branch.products.'.$route.'.print', ['regional' => $global->regional->slug, 'branch' => $global->branch->slug, $param => $model->id]) }}">Cetak</x-button>
<x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info" data-id="{{ $model->id }}">Detail</x-button>
<x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger" data-id="{{ $model->id }}" data-name="{{ $model->name }}">Hapus</x-button>
