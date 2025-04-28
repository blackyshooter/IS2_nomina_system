<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calcular Liquidación') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Buscar Empleado</h3>

                <!-- Mensaje de error -->
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="{{ route('liquidaciones.calcular') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="id_empleado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID del Empleado</label>
                        <input type="number" name="id" id="id_empleado" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 sm:text-sm"
                            placeholder="Ingrese el ID del empleado">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-md">
                            Calcular Liquidación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
