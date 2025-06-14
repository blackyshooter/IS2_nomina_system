<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Registrar Embargo Judicial
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
            <form method="POST" action="{{ route('embargos.store') }}">
                @csrf

                <!-- Empleado -->
                <div class="mb-4">
                    <label for="empleado_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Empleado
                    </label>
                    <select name="empleado_id" id="empleado_id" required class="mt-1 block w-full rounded-md">
                        <option value="">Seleccione un empleado</option>
                        @foreach ($empleados as $empleado)
                            <option value="{{ $empleado->id_empleado }}">
                                {{ $empleado->nombre }} {{ $empleado->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Monto Total -->
                <div class="mb-4">
                    <label for="monto_total" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Monto Total
                    </label>
                    <input type="number" name="monto_total" step="0.01" required class="mt-1 block w-full rounded-md">
                </div>

                <!-- Cuota Mensual -->
                <div class="mb-4">
                    <label for="cuota_mensual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Cuota Mensual
                    </label>
                    <input type="number" name="cuota_mensual" step="0.01" required class="mt-1 block w-full rounded-md">
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Guardar Embargo
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
