<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reporte de Pago por Empleado
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="mb-4">
            <form method="GET" class="flex flex-wrap items-center gap-3 mb-4">
                <div>
                    <label for="busqueda" class="font-medium">Buscar (nombre o cédula):</label>
                    <input type="text" name="busqueda" value="{{ $busqueda }}" class="border rounded p-1" placeholder="Ej: Juan o 1234567">
                </div>
                <div>
                    <label for="periodo" class="font-medium">Periodo (YYYY-MM):</label>
                    <input type="month" name="periodo" value="{{ $periodo }}" required class="border rounded p-1">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    Buscar
                </button>
            </form>

        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Empleado</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Cedula</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Periodo</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Acción</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($empleados as $emp)
                        <tr>
                            <td class="px-4 py-2">{{ $emp->nombre }} {{ $emp->apellido }}</td>
                            <td class="px-4 py-2">{{ $emp->cedula }}</td>
                            <td class="px-4 py-2">{{ $emp->usuario->email ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $periodo }}</td>
                            <td>
                                @if($estados[$emp->id_empleado])
                                    <a href="{{ route('recibo.pago', [$emp->id_empleado, $periodo]) }}"
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                        Ver Recibo
                                    </a>
                                @else
                                    <span class="text-red-500 font-medium">No liquidado</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $empleados->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
