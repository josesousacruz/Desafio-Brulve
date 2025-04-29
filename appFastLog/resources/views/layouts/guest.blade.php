<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased relative overflow-hidden">

    {{-- Vídeo de fundo em tela cheia --}}
    <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover z-0">
        <source src="assets/videos/login-bg.mp4" type="video/mp4" />
        Seu navegador não suporta vídeo em background.
    </video>

    {{-- Overlay escura para legibilidade --}}
    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 z-10"></div>

    {{-- Conteúdo principal acima do vídeo --}}
    <div class="relative z-20 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <img style="width: 10rem" class="" src="/assets/img/logo.jpg" alt="">
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            </a>
        </div>
        
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-blue-900/70 backdrop-blur-md border border-blue-500 shadow-lg overflow-hidden sm:rounded-lg text-white">
            {{ $slot }}
        </div>
        
    </div>

</body>
</html>
