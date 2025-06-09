
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reporte de Nómina con Descuentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Generar Reporte de Nómina por Período</h3>

                    <form action="{{ route('nominas.index') }}" method="GET" class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-4">
                            <div>
                                <label for="periodo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona el Período (AAAA-MM):</label>
                                <input type="month" id="periodo" name="periodo" value="{{ old('periodo', $periodo ?? date('Y-m')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                                @error('periodo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="pt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Generar Reporte
                                </button>
                            </div>
                        </div>
                    </form>

                    @if ($periodo && $reporteLiquidaciones->isEmpty())
                        <p class="text-center text-lg text-red-500">No se pudo generar el reporte para el período seleccionado, o no hay datos para mostrar.</p>
                        <p class="text-center text-sm text-gray-500">Asegúrate de que tienes empleados, salarios base y, si aplica, ausencias/préstamos registrados para este período.</p>
                    @elseif ($reporteLiquidaciones->isNotEmpty())
                        <h4 class="text-xl font-semibold mb-4">Reporte de Nómina para el período: {{ $periodo }}</h4>
                        @foreach ($reporteLiquidaciones as $empleadoId => $detalles)
                            @php
                                $empleado = $detalles->first()->empleado;
                                $totalHaberes = $detalles['total_haberes'] ?? 0;
                                $totalDebitos = $detalles['total_debitos'] ?? 0;
                                $salarioNeto = $detalles['salario_neto'] ?? 0;

                                // Remove custom keys to only iterate actual details
                                $detalles = $detalles->except(['total_haberes', 'total_debitos', 'salario_neto']);
                            @endphp
                            <div class="mb-8 p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                                <h5 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">
                                    Empleado: {{ $empleado->nombre }} {{ $empleado->apellido }} (Cédula: {{ $empleado->cedula }})
                                </h5>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                        <thead class="bg-gray-200 dark:bg-gray-600">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Concepto</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($detalles as $detalle)
                                                <tr>
                                                    <td class="px-4 py-2 whitespace-nowrap">{{ $detalle->conceptoSalarial->descripcion }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap">{{ $detalle->conceptoSalarial->tipo_concepto == 'credito' ? 'Crédito' : 'Débito' }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-right">
                                                        {{ $detalle->conceptoSalarial->tipo_concepto == 'debito' ? '-' : '' }}${{ number_format(abs($detalle->monto), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gray-200 dark:bg-gray-700 font-bold">
                                                <td colspan="2" class="px-4 py-2 text-right text-sm">Total Haberes:</td>
                                                <td class="px-4 py-2 text-right text-sm">${{ number_format($totalHaberes, 2) }}</td>
                                            </tr>
                                            <tr class="bg-gray-200 dark:bg-gray-700 font-bold">
                                                <td colspan="2" class="px-4 py-2 text-right text-sm">Total Débitos:</td>
                                                <td class="px-4 py-2 text-right text-sm">${{ number_format($totalDebitos, 2) }}</td>
                                            </tr>
                                            <tr class="bg-blue-100 dark:bg-blue-900 font-bold text-blue-800 dark:text-blue-200">
                                                <td colspan="2" class="px-4 py-2 text-right text-lg">SALARIO NETO:</td>
                                                <td class="px-4 py-2 text-right text-lg">${{ number_format($salarioNeto, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-8 p-6 bg-blue-100 dark:bg-blue-900 rounded-lg shadow-lg text-blue-800 dark:text-blue-200">
                            <h4 class="text-2xl font-bold text-center">Monto Total de Liquidación del Período: ${{ number_format($liquidacionCabecera->monto_total ?? 0, 2) }}</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>