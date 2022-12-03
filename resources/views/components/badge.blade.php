<span {!! $attributes->merge(['class' => "badge bg-$face " . ($rounded ? 'rounded-pill ' : '') . ($proporsional ? 'badge-center' : '') . ($icon ? 'd-flex align-items-center' : '') ]) !!} {{ ($icon ? 'style=width:max-content' : '') }}>
    @isset($icon)
        <i class="{{ $icon }} me-1"></i>
    @endisset
    {!! $slot !!}
</span>
