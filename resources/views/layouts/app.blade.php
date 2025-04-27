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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
            let timeout;

            // Detectar actividad del usuario
            function resetTimeout() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    // Si no hay actividad, no se envía el ping
                    console.log('Usuario inactivo. No se enviará ping.');
                }, {{ config('session.lifetime') * 60 * 1000 }}); // Tiempo de inactividad permitido
            }

            // Enviar un ping al servidor para mantener la sesión activa
            function sendPing() {
                fetch('{{ route('session.ping') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        console.log('Sesión mantenida activa.');
                    }
                }).catch(error => {
                    console.error('Error al enviar el ping:', error);
                });
            }

            // Escuchar eventos de actividad del usuario
            ['mousemove', 'keydown', 'click', 'scroll'].forEach(event => {
                window.addEventListener(event, () => {
                    resetTimeout();
                    sendPing();
                });
            });

            // Inicializar el timeout
            resetTimeout();
        </script>
    </body>
</html>
