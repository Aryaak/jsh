<div {!! $attributes->merge(['class' => 'list-group-item d-flex justify-content-between align-items-center']) !!}>
    <div>
        <i class="bx bxs-circle me-2 align-middle text-{{ $face }}" style="font-size:.3em!important"></i>
        <span class="badge rounded-pill bg-label-{{ $face }}"><i class="{{ $icon }} me-1 align-middle"></i>{!! $slot !!}</span>
    </div>
    @isset ($time)
        <div><small>{{ $time }}</small></div>
    @endisset
</div>
