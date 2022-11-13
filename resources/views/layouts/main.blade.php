<!DOCTYPE html>
<!-- beautify ignore:start -->
<html lang="id" class="light-style layout-menu-fixed" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | JSH Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('theme/fonts/boxicons/css/boxicons.min.css') }}" />
    <script src="https://kit.fontawesome.com/740dcf2f7e.js" crossorigin="anonymous"></script>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/my.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('theme/css/theme-default.css') }}" class="template-customizer-theme-css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Page CSS -->
    @stack('css')

    <!-- Helpers -->
    <script src="{{ asset('theme/js/helpers.js') }}"></script>

    <!-- Vite -->
    @vite('resources/js/app.js')
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand mb-4 mt-3">
                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo w-100">
                            <img src="{{ asset('assets/logos/logo.png') }}" alt="Logo JSH" class="w-100">
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle" style="font-size:1.55em!important"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow mt-4"></div>

                <ul class="menu-inner py-1 pb-5">

                    <x-menu route="dashboard" icon="bx bx-home-circle">Dasbor</x-menu>

                    {{-- Master Data --}}
                    <x-menu route="master.*" icon="bx bxs-data">
                        Master Data
                        @slot('submenus')
                            <x-submenu route="master.regionals.index">Regional</x-submenu>
                            <x-submenu route="master.branches.index">Cabang</x-submenu>
                            <x-submenu route="master.insurance-types.index">Jenis Jaminan</x-submenu>
                            <x-submenu route="master.templates.index">Template</x-submenu>
                            <x-submenu route="master.insurances.index">Asuransi</x-submenu>
                            <x-submenu route="master.insurance-rates.index">Rate Asuransi</x-submenu>
                            <x-submenu route="master.banks.index">Bank</x-submenu>
                            <x-submenu route="master.bank-rates.index">Rate Bank</x-submenu>
                            <x-submenu route="master.agents.index">Agen</x-submenu>
                            <x-submenu route="master.agent-rates.index">Rate Agen</x-submenu>
                            <x-submenu route="master.obligees.index">Obligee</x-submenu>
                            <x-submenu route="master.principals.index">Principal</x-submenu>
                        @endslot
                    </x-menu>


                    {{-- Produk --}}
                    <x-menu route="products.*" icon="bx bxs-receipt">
                        Produk
                        @slot('submenus')
                            <x-submenu route="products.surety-bonds.index">Surety Bond</x-submenu>
                            <x-submenu route="products.guarantee-banks.index">Bank Garansi</x-submenu>
                        @endslot
                    </x-menu>


                    {{-- Pembayaran --}}
                    <x-menu route="payments.*" icon="bx bxs-wallet">
                        Pembayaran
                        @slot('submenus')
                            <x-submenu route="payments.principal-to-branch.index">Principal ke Cabang</x-submenu>
                            <x-submenu route="dashboard">Cabang ke Regional</x-submenu>
                            <x-submenu route="payments.regional-to-insurance.index">Regional ke Asuransi</x-submenu>
                            <x-submenu route="payments.branch-to-agent.index">Cabang ke Agen</x-submenu>
                        @endslot
                    </x-menu>

                    {{-- Laporan Surety Bond --}}
                    <x-menu route="payments.sb.*" icon="bx bxs-file">
                        Laporan Surety Bond
                        @slot('submenus')
                            <x-submenu route="sb-reports.product">Produksi</x-submenu>
                            <x-submenu route="sb-reports.finance">Keuangan</x-submenu>
                            <x-submenu route="dashboard">Sisa Agen</x-submenu>
                            <x-submenu route="sb-reports.income">Pemasukan</x-submenu>
                            <x-submenu route="sb-reports.expense">Pengeluaran</x-submenu>
                            <x-submenu route="dashboard">Laba</x-submenu>
                        @endslot
                    </x-menu>

                    {{-- Laporan Bank Garansi --}}
                    <x-menu route="payments.bg.*" icon="bx bxs-file">
                        Laporan Bank Garansi
                        @slot('submenus')
                            <x-submenu route="bg-reports.product">Produksi</x-submenu>
                            <x-submenu route="bg-reports.finance">Keuangan</x-submenu>
                            <x-submenu route="dashboard">Sisa Agen</x-submenu>
                            <x-submenu route="bg-reports.income">Pemasukan</x-submenu>
                            <x-submenu route="bg-reports.expense">Pengeluaran</x-submenu>
                            <x-submenu route="dashboard">Laba</x-submenu>
                        @endslot
                    </x-menu>
                </ul>
            </aside>

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                <nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        {{-- Breadcrumb --}}
                        @php
                            $url = Str::replaceFirst(config('app.url'), '', Request::url());
                            $titles = explode('/', $url);
                            $real_titles = [];
                            $main_title = 'Dasbor';
                            foreach ($titles as $key => $title) {
                                $title = Str::title(str_replace('-', ' ', $title));
                                if ($key != count($titles) - 1) {
                                    $real_titles[] = $title;
                                }
                                else {
                                    $main_title = $title;
                                }
                            }
                        @endphp
                        <div class="my-3">
                            <h5 class="fw-bold my-3">
                                <span class="text-muted fw-light">
                                    @foreach ($real_titles as $title)
                                        {{ $title }} /
                                    @endforeach
                                </span> {{ $main_title }}
                            </h5>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar">
                                        <img src="{{ 'https://ui-avatars.com/api/?name=Admin' }}" alt="Foto {{ auth()->user()->name ?? 'Admin' }}" class="w-px-40 rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="{{ 'https://ui-avatars.com/api/?name=Admin' }}" alt="Foto {{ auth()->user()->name ?? 'Admin' }}" class="w-px-40 rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ auth()->user()->name ?? 'Admin' }}</span>
                                                    <small class="text-muted">{{ Str::title(auth()->user()->role ?? 'Admin') }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
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
                    </div>
                </nav>

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content  -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        @yield('contents')
                    </div>

                    @yield('modals')

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © 2022, made with ❤️ by <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                            </div>
                            <div>
                                {{-- More Footer --}}
                            </div>
                        </div>
                    </footer>
                </div>

            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('theme/plugins/jquery/jquery.js') }}"></script>
    <script src="{{ asset('theme/plugins/popper/popper.js') }}"></script>
    <script src="{{ asset('theme/js/bootstrap.js') }}"></script>
    <script src="{{ asset('theme/plugins/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('theme/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://malsup.github.io/jquery.blockUI.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('theme/js/main.js') }}"></script>
    <script src="{{ asset('js/my.js') }}"></script>

    <!-- Page JS -->
    @stack('js')

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>

    </script>
</body>
</html>
