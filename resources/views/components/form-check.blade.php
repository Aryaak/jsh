@php
    $class = 'form-check';
    if ($type == 'switch') {
        $class .= ' form-switch';
        $type = 'checkbox';
    }
    if ($inline) {
        $class .= ' form-check-inline';
    }
@endphp
<div {{ $attributes->merge(['class' => $class]) }}>
    <input class="form-check-input" type="{{ $type }}" value="{{ $value ?? '' }}" id="{{ $id }}" name="{{ $name ?? '' }}" @if($checked) checked @endif @if($disabled) disabled @endif @if($required) required @endif />
    <label class="form-check-label" for="{{ $id }}">
        {!! $slot !!}
    </label>
</div>
