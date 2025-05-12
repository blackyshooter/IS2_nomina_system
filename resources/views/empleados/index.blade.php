<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Empleados') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Lista de Empleados</h2>

        <!-- Botón para agregar un nuevo empleado -->
        <div class="mb-4">
            <a href="{{ route('empleados.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700">
                Nuevo Empleado
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de empleados -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Cédula</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Sueldo</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Ingreso</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Salida</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Cargo</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleados as $empleado)
                        <tr class="border-t border-gray-300 dark:border-gray-700">
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->id_empleado }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->cedula }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->telefono }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->sueldo_base }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->fecha_ingreso }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->fecha_salida }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $empleado->cargo }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                <div class="flex space-x-2">
                                    <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-md shadow-md hover:bg-yellow-600">
                                        Editar
                                    </a>
                                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este empleado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md shadow-md hover:bg-red-700">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
