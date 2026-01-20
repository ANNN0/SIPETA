<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIPETA') }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="{{ asset('images/logo/logo-sipeta-2.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css" />
    @stack('styles')
    @vite(['resources/sass/app.scss'])
</head>

<body class="gradient-bg">
    @yield('content')

    <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    {{-- Card Mouse Tracking Animation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.auth-logo-container');

            if (card) {
                const leftPanel = document.querySelector('.auth-left-panel');

                leftPanel.addEventListener('mousemove', function(e) {
                    const rect = card.getBoundingClientRect();
                    const cardCenterX = rect.left + rect.width / 2;
                    const cardCenterY = rect.top + rect.height / 2;

                    const deltaX = (e.clientX - cardCenterX) / 30;
                    const deltaY = (e.clientY - cardCenterY) / 30;

                    card.style.transform = `translate(${deltaX}px, ${deltaY}px)`;
                });

                leftPanel.addEventListener('mouseleave', function() {
                    card.style.transform = '';
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
