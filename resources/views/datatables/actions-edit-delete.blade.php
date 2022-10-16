<x-button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modal-edit" size="sm" icon="bx bxs-edit" face="warning" data-id="{{ $model->id }}">Ubah</x-button>
<x-button class="btn-delete" size="sm" icon="bx bxs-trash" face="danger" data-id="{{ $model->id }}" data-name="{{ $model->name }}">Hapus</x-button>
