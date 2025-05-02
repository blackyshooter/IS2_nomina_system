{{-- filepath: c:\Users\ferch\Documents\GitHub\IS2_nomina_system\resources\views\welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Script para alternar entre modo claro y oscuro
        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Configuración inicial del tema
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        });
    </script>
</head>
<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <!-- Botón para alternar modo oscuro/claro -->
        <div class="absolute top-4 right-4">
            <button onclick="toggleDarkMode()" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 dark:hover:bg-gray-600">
                Alternar Modo
            </button>
        </div>

        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-4xl font-bold text-blue-600 dark:text-blue-400">Bienvenido</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">Gestiona tu nómina de manera eficiente y sencilla.</p>
        </header>

        <!-- Main Content -->
        <main class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 max-w-md w-full">
            @if (Route::has('login'))
                <div class="flex flex-col items-center space-y-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full text-center bg-blue-600 dark:bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center bg-blue-600 dark:bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="mt-8 text-center text-gray-500 dark:text-gray-400 text-sm">
            © {{ date('Y') }} Todos los derechos reservados.
        </footer>
    </div>
</body>
</html>