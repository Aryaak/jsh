@isset ($link)
    <a href="{{ $link }}" {{ $attributes->merge(['class' => "btn btn-$face btn-$size"]) }}>
        @isset ($icon)
            <i class="{{ $icon }} me-1 align-middle"></i>
        @endisset
        {{ $slot }}
    </a>
@else
    <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => "btn btn-$face btn-$size"]) }} {{ $attributes->merge(['onclick' => '']) }}>
        @isset ($icon)
            <i class="{{ $icon }} me-1 align-middle"></i>
        @endisset
        {{ $slot }}
    </button>
@endisset
