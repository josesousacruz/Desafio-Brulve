<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>FastLog</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vite - app.css + app.js (controlando toda a lógica) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["/assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files (manuais) -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="/assets/css/demo.css" /> <!-- Apenas para demo -->

</head>
@include('components.offcanvas')
<body data-page="@yield('page')">
    <div class="wrapper">
        <!-- Sidebar -->
        @include('components.sidebar')

        <div class="main-panel">
            @include('components.header')

            @component('components.container')
                @yield('content')
            @endcomponent

            @include('components.footer')
        </div>
    </div>

    <!-- Scripts específicos da página -->
    @yield('scripts')
</body>

</html>
