<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'MeAdote') }}</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />

    <meta name="user-id" content="{{ auth()->check() ? auth()->id() : '' }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192x192.png">
    <meta name="theme-color" content="teal">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ios support -->
    <link rel="apple-touch-icon" href="images/icons/icon-72x72.png" />
    <link rel="apple-touch-icon" href="images/icons/icon-96x96.png" />
    <link rel="apple-touch-icon" href="images/icons/icon-128x128.png" />
    <link rel="apple-touch-icon" href="images/icons/icon-144x144.png" />
    <link rel="apple-touch-icon" href="images/icons/icon-152x152.png" />
    <link rel="apple-touch-icon" href="images/icons/icon-192x192.png" />
    <link rel="apple-touch-icon" href="images/icons/icon-384x384.png" />
    <link rel="apple-touch-icon" href="images/icons/icon-512x512.png" />
    <meta name="apple-mobile-web-app-status-bar" content="#19598c" />
    <meta name="theme-color" content="#19598c" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <style>
        /* CSS para o efeito de carregamento */
        #loading {
            position: fixed;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        iframe {
            width: 150px;
            /* Ajuste conforme necessário */
            height: 150px;
        }
    </style>



</head>

<body class="font-sans antialiased">


    <div id="loading">
        <img src="{{ asset('images/loading.gif') }}" alt="Carregando...">
    </div>

    <x-banner />

    <div class="min-h-screen bg-gray-100">

        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif


        @if (session('success'))
            <div id="alert"
                class="fixed top-30 left-0 w-full bg-green-500 bg-opacity-90 text-white p-2 shadow-lg transition-opacity duration-300 text-center z-50">
                {{ session('success') }}
            </div>
        @endif


        @if (session('error'))
            <div id="alert"
                class="fixed top-30 left-0 w-full bg-red-500 bg-opacity-90 text-white p-2 shadow-lg transition-opacity duration-500 text-center z-50">
                {{ session('error') }}
            </div>
        @endif


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Rodapé -->


    {{-- Exibe o rodapé apenas se a seção "hideFooter" não estiver definida --}}
    @if (!$attributes->get('hideFooter'))
        <x-footer />
    @endif



    @stack('modals')

    @livewireScripts

    <script>
        // Esconder o efeito de carregamento após o carregamento completo da página
        window.addEventListener("load", function() {
            var loadingScreen = document.getElementById("loading");
            loadingScreen.style.display = "none";
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alert = document.getElementById('alert');
                if (alert) { // Verifica se o alerta existe
                    alert.classList.add('opacity-0');
                }
            }, 3000);

            setTimeout(function() {
                var alert = document.getElementById('alert');
                if (alert) { // Verifica se o alerta existe
                    alert.style.display = 'none';
                }
            }, 5000);
        });
    </script>


</body>


</html>
