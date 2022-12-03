@php
    $isActive = Route::is($activeRoute);
    if ($activeRoute == 'design') {
        $isActive = false;
        if ($routeParams['page'] == explode('/', url()->current())[4]) {
            $isActive = true;
        }
    }
@endphp
<li class="menu-item @if($isActive) active @isset($submenus) open @endisset @endif">
    <a href="{{ $submenus ? 'javascript:void(0);' : route($route, $routeParams) }}" class="menu-link @isset($submenus) menu-toggle @endisset">
        <i class="menu-icon {{ $icon }}"></i>
        <div>{!! $slot !!}</div>
    </a>

    @isset($submenus)
        <ul class="menu-sub">
           {!! $submenus !!}
        </ul>
    @endisset
</li>
