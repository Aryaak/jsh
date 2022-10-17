<x-button class="btn-sync" size="sm"  icon="bx bx-refresh" face="warning" data-id="{{ $model->id }}">Sinkronkan</x-button>
<x-button class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info" data-id="{{ $model->id }}">Detail</x-button>
<x-button class="btn-delete" size="sm" icon="bx bxs-trash" face="danger" data-id="{{ $model->id }}" data-name="{{ $model->name }}">Hapus</x-button>
