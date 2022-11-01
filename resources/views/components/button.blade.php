@if ($type == 'icon')
    @isset ($link)
        <span {!! $attributes !!}>
            <a href="{{ $link }}" class="btn btn-{{ $face }} btn-{{ $size }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{!! $slot !!}">
                <i class="{{ $icon }} align-middle"></i>
            </a>
        </span>
    @else
        <span {!! $attributes !!}>
            <button type="button" class="btn btn-{{ $face }} btn-{{ $size }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{!! $slot !!}">
                <i class="{{ $icon }} align-middle"></i>
            </button>
        </span>
    @endisset
@else
    @isset ($link)
        <a href="{{ $link }}" {{ $attributes->merge(['class' => "btn btn-$face btn-$size"]) }}>
            @isset ($icon)
                <i class="{{ $icon }} me-1 align-middle"></i>
            @endisset
            {!! $slot !!}
        </a>
    @else
        <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => "btn btn-$face btn-$size"]) }} {{ $attributes->merge(['onclick' => '']) }}>
            @isset ($icon)
                <i class="{{ $icon }} me-1 align-middle"></i>
            @endisset
            {!! $slot !!}
        </button>
    @endisset
@endif
