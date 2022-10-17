<li class="menu-item @if($routeParams == []) @if(Route::is($route)) active @endif @else @if(Request::url() == route($route, $routeParams)) active @endif @endif">
    <a href="{{ route($route, $routeParams) }}" class="menu-link">
        <div>{!! $slot !!}</div>
    </a>
</li>
