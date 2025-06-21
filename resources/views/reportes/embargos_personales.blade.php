<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Embargos Personales</h2>
    </x-slot>

    <div class="py-6">
        <form method="GET" action="{{ route('reporte.embargos.generar') }}">
            <div class="flex space-x-4 mb-4">
                <div>
                    <label>Año:</label>
                    <select name="anio" class="form-select">
                        @for($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <x-primary-button>Generar</x-primary-button>
                <a href="{{ route('reporte.embargos.imprimir') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Vista de Impresión</a>
            </div>
        </form>

        @isset($embargos)
            <div class="overflow-auto">
                <table class="min-w-full bg-white shadow rounded">
                    <thead>
                        <tr>
                            <th>Monto Total</th>
                            <th>Cuota Mensual</th>
                            <th>Restante</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($embargos as $e)
                            <tr>
                                <td>{{ number_format($e->monto_total, 0, ',', '.') }} Gs</td>
                                <td>{{ number_format($e->cuota_mensual, 0, ',', '.') }} Gs</td>
                                <td>{{ number_format($e->monto_restante, 0, ',', '.') }} Gs</td>
                                <td>{{ $e->activo ? 'Activo' : 'Finalizado' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No se encontraron embargos personales registrados.</p>
        @endisset
    </div>
</x-app-layout>