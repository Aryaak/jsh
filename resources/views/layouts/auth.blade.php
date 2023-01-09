<!DOCTYPE html>

<html lang="id" class="light-style customizer-hide" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }} | JSH Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('public/assets/logos/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('public/theme/fonts/boxicons/css/boxicons.min.css') }}" />
    <script src="https://kit.fontawesome.com/740dcf2f7e.js" crossorigin="anonymous"></script>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('public/css/my.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/theme/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('public/theme/css/theme-default.css') }}" class="template-customizer-theme-css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    @stack('css')

    <!-- Helpers -->
    <script src="{{ asset('public/theme/js/helpers.js') }}"></script>
</head>
<body>
    <div class="container-xxl"> 
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <x-card>
                    <div class="app-brand justify-content-center mb-0">
                        <a href="{{ route('main.dashboard') }}" class="app-brand-link p-3">
                            <span class="app-brand-logo w-100">
                                <img src="{{ asset('public/assets/logos/logo.png') }}" alt="Logo JSH" class="w-100">
                            </span>
                        </a>
                    </div>
                    @yield('contents')
                </x-card>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('public/theme/plugins/jquery/jquery.js') }}"></script>
    <script src="{{ asset('public/theme/plugins/popper/popper.js') }}"></script>
    <script src="{{ asset('public/theme/js/bootstrap.js') }}"></script>
    <script src="{{ asset('public/theme/plugins/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('public/theme/js/menu.js') }}"></script>

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('public/theme/js/main.js') }}"></script>

    <!-- Page JS -->
    @stack('js')

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
