<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reporte de Empleados') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Reporte de Empleados</h2>

        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Empleado</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad de Hijos Menores de 18</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                    <tr class="border-t border-gray-300 dark:border-gray-700">
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->persona->nombre }} {{ $empleado->persona->apellido }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->hijos_menores }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
