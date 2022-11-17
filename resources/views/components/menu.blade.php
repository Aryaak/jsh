<li class="menu-item @if(Route::is($activeRoute)) active @isset($submenus) open @endisset @endif">
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
