<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liquidación de ') . $empleado->persona->nombre . ' ' . $empleado->persona->apellido }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Detalles de la Liquidación</h3>

                <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Concepto</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700 dark:text-gray-300">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conceptos as $concepto)
                            <tr class="border-t border-gray-300 dark:border-gray-700">
                                <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $concepto['descripcion'] }}</td>
                                <td class="px-4 py-2 text-sm text-right text-gray-800 dark:text-gray-200">{{ number_format($concepto['monto'], 0, ',', '.') }} Gs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>