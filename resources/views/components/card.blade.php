<div {!! $attributes->merge(['class' => 'card']) !!}>
    @isset($header)
        <div class="card-header border-bottom mb-4" @if($smallHeader) style="padding:1rem 1.5rem" @endif>
            <div class="d-flex justify-content-between">
                <div class="@if($smallHeader) h5 @else h4 @endif fw-bold mb-0">{!! $header !!}</div>
                @isset($headerAction)
                    <div>
                        {!! $headerAction !!}
                    </div>
                @endisset
            </div>
        </div>
    @endisset
    <div class="card-body" @if($darkBody) style="background-color: #EEE" @endif>
        {!! $slot !!}
    </div>
</div>
