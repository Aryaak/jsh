<!DOCTYPE html>
<!-- beautify ignore:start -->
<html lang="id" class="light-style layout-menu-fixed" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | JSH Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logos/favicon.png') }}" />

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

            <!-- Layout container -->
            <div class="layout-page full">

                <!-- Navbar -->
                <nav class="d-flex justify-content-center pt-5 pb-3">
                    <a href="" class="app-brand-link" style="width:300px;">
                        <span class="app-brand-logo w-100">
                            <img src="{{ asset('assets/logos/logo.png') }}" alt="Logo JSH" class="w-100">
                        </span>
                    </a>
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
