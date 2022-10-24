<x-button type="icon" class="btn-sync" size="sm"  icon="bx bx-refresh" face="warning" data-id="{{ $model->id }}">Sinkronkan</x-button>
<x-button type="icon" class="btn-edit" data-bs-toggle="modal" data-bs-target="#modal-edit" size="sm" icon="bx bxs-edit" face="warning" data-id="{{ $model->id }}">Ubah</x-button>
<x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger" data-id="{{ $model->id }}" data-name="{{ $model->name }}">Hapus</x-button>
