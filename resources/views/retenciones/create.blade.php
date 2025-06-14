<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Registrar Retención Sindical
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('retenciones.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="empleado_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Empleado
                        </label>
                        <select id="empleado_id" name="empleado_id" required
                            class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <option value="">Seleccione un empleado</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}">
                                    {{ $empleado->nombre }} {{ $empleado->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="monto_mensual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Monto Mensual
                        </label>
                        <input type="number" step="0.01" name="monto_mensual" id="monto_mensual" required
                            class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('retenciones.index') }}"
                           class="mr-4 text-gray-600 dark:text-gray-300 hover:underline">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                            Guardar Retención
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
