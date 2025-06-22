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
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            {{-- Menú adaptado por rol --}}
            @auth
            <nav class="bg-white dark:bg-gray-800 shadow mb-4">
                <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap gap-2">
                    {{-- ADMINISTRADOR --}}
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="text-blue-700">Dashboard</a>
                        <a href="{{ route('empleados.index') }}" class="text-blue-700">Empleados</a>
                        <a href="{{ route('usuarios.index') }}" class="text-blue-700">Usuarios</a>
                        <a href="{{ route('ausencias.index') }}" class="text-blue-700">Ausencias</a>
                        <a href="{{ route('prestamos.index') }}" class="text-blue-700">Préstamos</a>
                        <a href="{{ route('embargos.index') }}" class="text-blue-700">Embargos</a>
                        <a href="{{ route('retenciones.index') }}" class="text-blue-700">Retenciones</a>
                        <a href="{{ route('liquidaciones.individual') }}" class="text-blue-700">Liquidaciones</a>
                        <a href="{{ route('reporte.extracto') }}" class="text-blue-700">Reportes</a>
                    @endif

                    {{-- GERENTE --}}
                    @if(Auth::user()->role === 'gerente')
                        <a href="{{ route('empleados.index') }}" class="text-green-700">Empleados</a>
                        <a href="{{ route('nominas.index') }}" class="text-green-700">Nóminas</a>
                        <a href="{{ route('reporte.extracto') }}" class="text-green-700">Reportes</a>
                    @endif

                    {{-- ASISTENTE RRHH --}}
                    @if(Auth::user()->role === 'asistente')
                        <a href="{{ route('empleados.index') }}" class="text-orange-700">Empleados</a>
                        <a href="{{ route('ausencias.index') }}" class="text-orange-700">Ausencias</a>
                        <a href="{{ route('prestamos.index') }}" class="text-orange-700">Préstamos</a>
                        <a href="{{ route('embargos.index') }}" class="text-orange-700">Embargos</a>
                        <a href="{{ route('retenciones.index') }}" class="text-orange-700">Retenciones</a>
                        <a href="{{ route('liquidaciones.individual') }}" class="text-orange-700">Liquidaciones</a>
                    @endif

                    {{-- EMPLEADO --}}
                    @if(Auth::user()->role === 'empleado')
                        <a href="{{ route('profile.edit') }}" class="text-purple-700">Mi Perfil</a>
                        <a href="{{ route('liquidacion.empleado') }}" class="text-purple-700">Mi Liquidación</a>
                    @endif
                </div>
            </nav>
            @endauth

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
