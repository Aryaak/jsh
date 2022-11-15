<x-button type="icon" link="{{ route('branch.dashboard', ['regional' => $model->regional->slug, 'branch' => $model->slug]) }}" size="sm" icon="bx bx-key" face="secondary">Masuk</x-button>
<x-button type="icon" class="btn-show" data-bs-toggle="modal" data-bs-target="#modal-show" size="sm" icon="bx bx-search" face="info" data-id="{{ $model->id }}">Detail</x-button>
<x-button type="icon" class="btn-delete" size="sm" icon="bx bxs-trash" face="danger" data-id="{{ $model->id }}" data-name="{{ $model->name }}">Hapus</x-button>
