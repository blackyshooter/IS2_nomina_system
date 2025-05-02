<!-- resources/views/admin/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel del Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Bienvenido, Administrador.
                </p>

                <div class="flex flex-col space-y-4">
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-1/3">
                        Agregar nuevo empleado
                    </a>
                    <a href="#" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-1/3">
                        Asignar usuario y contraseña
                    </a>
                    <a href="#" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 w-full sm:w-1/3">
                        Ver empleados registrados
                    </a>
                    <a href="#" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 w-full sm:w-1/3">
                        Calcular nómina
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
