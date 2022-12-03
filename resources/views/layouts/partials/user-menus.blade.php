<ul class="navbar-nav flex-row align-items-center ms-auto">
    <!-- User -->
    @auth
        @php
            $params = [];
            if (auth()->user()->role == 'regional') {
                $params = ['regional' => $global->regional->slug];
            }
            elseif (auth()->user()->role == 'branch') {
                $params = ['regional' => $global->regional->slug, 'branch' => $global->branch->slug];
            }
        @endphp
    @endauth
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=Desain' }}" alt="Foto {{ auth()->user()->name ?? 'Desain' }}" class="w-px-40 rounded-circle" />
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="{{ !auth()->guest() ? route(auth()->user()->role.'.profile', $params) : '' }}">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=Desain' }}" alt="Foto {{ auth()->user()->name ?? '' }}" class="w-px-40 rounded-circle" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ auth()->user()->name ?? 'Desain' }}</span>
                            <small class="text-muted">{{ Str::title(auth()->user()->role_converted ?? 'Admin') }}</small>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="{{ !auth()->guest() ? route(auth()->user()->role.'.profile', $params) : '' }}">
                    <i class="bx bx-user align-middle me-2"></i>
                    <span class="align-top">Setting Akun</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit()">
                    <i class="bx bx-power-off align-middle me-2"></i>
                    <span class="align-top">Keluar</span>
                    <form action="{{ route('logout') }}" method="post" id="logout-form">
                        @csrf
                    </form>
                </a>
            </li>
        </ul>
    </li>
</ul>
