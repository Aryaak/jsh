<div class="d-flex justify-content-between">

    <label class="form-label" @isset($for) for="{{ $for }}" @endisset>
        {!! $slot !!}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    @isset($badge)
        {!! $badge !!}
    @endisset
</div>
