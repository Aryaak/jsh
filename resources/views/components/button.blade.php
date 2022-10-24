@if ($type == 'icon')
    @isset ($link)
        <a href="{{ $link }}" {{ $attributes->merge(['class' => "text-$face"]) }}>
            <i class="{{ $icon }} align-middle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{!! $slot !!}"></i>
        </a>
    @else
        <span data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="{!! $slot !!}" class="cursor-pointer">
            <i {{ $attributes->merge(['class' => "$icon text-$face align-middle"]) }} {{ $attributes->merge(['onclick' => '']) }}></i>
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
