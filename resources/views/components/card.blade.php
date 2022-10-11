<div {!! $attributes->merge(['class' => 'card']) !!}>
    @isset($header)
        <div class="card-header border-bottom mb-4">
            <div class="d-flex justify-content-between">
                <div class="h4 fw-bold mb-0">{!! $header !!}</div>
                @isset($headerAction)
                    <div>
                        {!! $headerAction !!}
                    </div>
                @endisset
            </div>
        </div>
    @endisset
    <div class="card-body">
        {!! $slot !!}
    </div>
</div>
