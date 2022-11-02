@php
    $sbbg = ($model->bank_id) ? 'bg' : 'sb';
@endphp
<x-button type="icon" class="btn-show-{{ $sbbg }}" data-bs-toggle="modal" data-bs-target="#modal-show-{{ $sbbg }}" size="sm" icon="bx bx-search" face="info" data-id="{{ $model->id }}">Detail</x-button>
<x-button type="icon" class="btn-delete-{{ $sbbg }}" size="sm" icon="bx bxs-trash" face="danger" data-id="{{ $model->id }}" data-name="{{ $model->name }}">Hapus</x-button>
