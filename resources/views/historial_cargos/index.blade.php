<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Historial de Cargos de Empleados
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <form method="GET" class="mb-4 flex items-center gap-3">
            <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por nombre o cédula"
                   class="border rounded px-2 py-1 w-64">
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                Buscar
            </button>
        </form>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Cédula</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Apellido</th>
                        <th class="px-4 py-2 text-left">Cargo</th>
                        <th class="px-4 py-2 text-left">Fecha Inicio</th>
                        <th class="px-4 py-2 text-left">Fecha Fin</th>
                        <th class="px-4 py-2 text-left">Salario Percibido</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($cargos as $registro)
                        <tr>
                            <td class="px-4 py-2">{{ $registro->empleado->cedula }}</td>
                            <td class="px-4 py-2">{{ $registro->empleado->nombre }}</td>
                            <td class="px-4 py-2">{{ $registro->empleado->apellido }}</td>
                            <td class="px-4 py-2">{{ $registro->empleado->cargo ?? '-' }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($registro->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                {{ $registro->fecha_fin ? \Carbon\Carbon::parse($registro->fecha_fin)->format('d/m/Y') : 'Actual' }}
                            </td>
                            <td class="px-4 py-2">{{ number_format($registro->empleado->salario_base, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-4 py-4 text-gray-500">
                                No se encontraron registros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $cargos->links() }}
        </div>
    </div>
</x-app-layout>
