<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200 leading-tight">
            Reporte de Nómina General
        </h2>
    </x-slot>

    <div class="py-6 px-6 max-w-7xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg">

        {{-- Botones principales --}}
        <div class="flex justify-between mb-4">
            <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">← Volver</a>
            <div class="space-x-2">
                <a href="{{ route('reporte.nomina.excel', request()->all()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    📊 Exportar en Excel  </a>
                <a href="{{ route('reporte.nomina.pdf', request()->all()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">📄 Exportar PDF</a>
                <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">🖨️ Imprimir Reporte</button>
            </div>
        </div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('reporte.nomina') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200">Filtrar por mes:</label>
                <input type="month" name="periodo" value="{{ request('periodo') }}" class="w-full px-3 py-2 rounded border">
            </div>
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200">Fecha inicio:</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="w-full px-3 py-2 rounded border">
            </div>
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200">Fecha fin:</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="w-full px-3 py-2 rounded border">
            </div>
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200">Salario mínimo:</label>
                <input type="number" name="salario_min" value="{{ request('salario_min') }}" class="w-full px-3 py-2 rounded border">
            </div>
            <div>
                <label class="block text-sm text-gray-700 dark:text-gray-200">Salario máximo:</label>
                <input type="number" name="salario_max" value="{{ request('salario_max') }}" class="w-full px-3 py-2 rounded border">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Generar</button>
            </div>
        </form>

        {{-- Tabla de resultados --}}
        @if($reporteLiquidaciones->count() > 0)
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-600 text-sm">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="border px-2 py-1">C.I.</th>
                            <th class="border px-2 py-1">Nombre</th>
                            <th class="border px-2 py-1">Apellido</th>
                            <th class="border px-2 py-1">Cargo</th>
                            <th class="border px-2 py-1 text-right">Percepción</th>
                            <th class="border px-2 py-1 text-right">Deducción</th>
                            <th class="border px-2 py-1 text-right">Neto a Pagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalHaberes = 0;
                            $totalDebitos = 0;
                            $totalNeto = 0;
                        @endphp

                        @foreach($reporteLiquidaciones as $datos)
                            @php
                                $empleado = $datos['empleado'];
                                $haberes = $datos['total_haberes'] ?? 0;
                                $debitos = $datos['total_debitos'] ?? 0;
                                $neto = $datos['salario_neto'] ?? 0;
                                $totalHaberes += $haberes;
                                $totalDebitos += $debitos;
                                $totalNeto += $neto;
                            @endphp
                            <tr>
                                <td class="border px-2 py-1">{{ $empleado->cedula ?? '-' }}</td>
                                <td class="border px-2 py-1">{{ $empleado->nombre ?? '-' }}</td>
                                <td class="border px-2 py-1">{{ $empleado->apellido ?? '-' }}</td>
                                <td class="border px-2 py-1">
                                    {{ $empleado->cargoActual?->cargo?->nombre ?? ($empleado->cargo ?? '-') }}
                                </td>
                                <td class="border px-2 py-1 text-right">{{ number_format($haberes, 0, ',', '.') }} Gs</td>
                                <td class="border px-2 py-1 text-right">{{ number_format($debitos, 0, ',', '.') }} Gs</td>
                                <td class="border px-2 py-1 text-right">{{ number_format($neto, 0, ',', '.') }} Gs</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="font-semibold bg-gray-100 dark:bg-gray-900">
                        <tr>
                            <td colspan="4" class="border px-2 py-2 text-right">Empleados: {{ $reporteLiquidaciones->count() }}</td>
                            <td class="border px-2 py-2 text-right">{{ number_format($totalHaberes, 0, ',', '.') }} Gs</td>
                            <td class="border px-2 py-2 text-right">{{ number_format($totalDebitos, 0, ',', '.') }} Gs</td>
                            <td class="border px-2 py-2 text-right">{{ number_format($totalNeto, 0, ',', '.') }} Gs</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="mt-6 text-gray-700 dark:text-gray-300">No hay resultados para el filtro seleccionado.</div>
        @endif
    </div>
</x-app-layout>
