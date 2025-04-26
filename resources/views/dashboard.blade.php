<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard - Sistema de Nómina') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Bienvenido al Sistema de Nómina</h3>
                    <p class="mb-4">Selecciona una de las opciones para comenzar:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Empleados -->
                        <a href="{{ route('empleados.index') }}" class="block bg-blue-600 text-white text-center py-4 rounded-lg shadow-md hover:bg-blue-700">
                            Gestión de Empleados
                        </a>

                        <!-- Liquidaciones -->
                        <a href="{{ route('liquidaciones.index') }}" class="block bg-green-600 text-white text-center py-4 rounded-lg shadow-md hover:bg-green-700">
                            Gestión de Liquidaciones
                        </a>

                        <!-- Reportes -->
                        <a href="{{ route('reportes.index') }}" class="block bg-purple-600 text-white text-center py-4 rounded-lg shadow-md hover:bg-purple-700">
                            Generar Reportes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
