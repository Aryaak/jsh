<div {!! $attributes !!}>

    @if ($label)
        <x-form-label for="{{ $id ?? '' }}" required="{{ $required ?? 0 }}">
            {{ $label }}
            @if ($labelBadge)
                @slot('badge')
                    {!! $labelBadge !!}
                @endslot
            @endif
        </x-form-label>
    @endif

    @if (isset($prefix) || isset($suffix) || $type == 'password')
        <div class="input-group">
    @endif

    @isset($prefix)
        <span class="input-group-text" id="prefix-{{ $id ?? '' }}">{!! $prefix !!}</span>
    @endisset

    <input
        class="form-control @error($name) is-invalid @enderror {{ $classInput }}"
        type="{{ $type ?? 'text' }}"
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? old($name) }}"
        @isset($required) required @endisset
        @isset($readonly) readonly @endisset
        @isset($disabled) disabled @endisset
        @isset($autofocus) autofocus @endisset
    />

    @if(isset($suffix) || $type == 'password')
        <span class="input-group-text @if($type == 'password') cursor-pointer password-toggle @endif" id="suffix-{{ $id ?? '' }}">{!! $suffix ?? '<i class="bx bx-hide"></i>' !!}</span>
    @endif

    @if (isset($prefix) || isset($suffix) || $type == 'password')
        </div>
    @endif

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>

@if ($type == 'password')
    @pushOnce('js')
        <script>
            $(document).on('click', '.password-toggle', function() {
                const input = $(this).parent().find('input').eq(0);
                if (input.attr('type') == 'password') {
                    input.attr('type', 'text')
                    $(this).html(`<i class="bx bx-show"></i>`)
                } else {
                    input.attr('type', 'password')
                    $(this).html(`<i class="bx bx-hide"></i>`)
                }
            })
        </script>
    @endPushOnce
@endif
