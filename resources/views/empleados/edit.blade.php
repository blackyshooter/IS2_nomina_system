<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Empleado') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Editar Empleado</h2>

        <form action="{{ route('empleados.update', $empleado->id_empleado) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Datos Personales -->
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Datos Personales</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cédula</label>
                    <input type="text" value="{{ $empleado->cedula }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" disabled>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" name="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ $empleado->persona->nombre }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                    <input type="text" name="apellido" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ $empleado->persona->apellido }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ $empleado->persona->fecha_nacimiento }}" required>
                </div>
            </div>

            <!-- Datos Laborales -->
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mt-8 mb-4">Datos Laborales</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                    <input type="text" name="telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ $empleado->telefono }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sueldo Base</label>
                    <input type="number" step="0.01" name="sueldo_base" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ $empleado->sueldo_base }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ $empleado->fecha_ingreso }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo</label>
                    <input type="text" name="cargo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" value="{{ $empleado->cargo }}" required>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('empleados.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
