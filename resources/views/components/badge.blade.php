<span {!! $attributes->merge(['class' => "badge bg-$face " . ($rounded ? 'rounded-pill ' : '') . ($proporsional ? 'badge-center' : '') ]) !!}>{!! $slot !!}</span>
