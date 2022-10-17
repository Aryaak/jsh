<div class="modal fade" id="{{ $id }}">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable @isset($size) modal-{{ $size }} @endisset">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="title-{{ $id }}">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" @if($darkBody) style="background-color: #EEE" @endif>
                {!! $slot !!}
            </div>
            @isset($footer)
                <div class="modal-footer border-top">
                    {!! $footer !!}
                </div>
            @endisset
        </div>
    </div>
</div>
