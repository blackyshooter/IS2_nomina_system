<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard - Sistema de Nómina') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-bold mb-6 text-center">Bienvenido al Sistema de Nómina</h3>
                    <p class="mb-8 text-center text-lg text-gray-700 dark:text-gray-300">
                        Selecciona una de las opciones para comenzar:
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 overflow-visible">
                    <!-- Gestión de Empleados -->
                        <div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="block w-full bg-blue-600 text-white text-center py-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
        <i class="fas fa-users text-3xl mb-2"></i>
        <span class="block text-lg font-semibold">Gestión de Empleados</span>
    </button>

    <!-- Submenú -->
    <div x-show="open" @click.outside="open = false"
        class="absolute z-10 mt-2 w-full bg-white rounded shadow-lg p-4 text-left">
        <a href="{{ route('empleados.create') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">➕ Agregar Empleado</a>
        <a href="{{ route('empleados.index') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">📋 Listar Empleados</a>
    </div>
</div>

                        <!-- Gestión de Liquidaciones -->
                        <a href="{{ route('liquidaciones.index') }}" class="block bg-green-600 text-white text-center py-6 rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                            <i class="fas fa-file-invoice-dollar text-3xl mb-2"></i>
                            <span class="block text-lg font-semibold">Gestión de Liquidaciones</span>
                        </a>

                        <!-- Generar Reportes -->
                        <a href="{{ route('reportes.index') }}" class="block bg-purple-600 text-white text-center py-6 rounded-lg shadow-md hover:bg-purple-700 transition duration-300">
                            <i class="fas fa-chart-bar text-3xl mb-2"></i>
                            <span class="block text-lg font-semibold">Generar Reportes</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
