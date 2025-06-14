<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Retención Sindical') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('retenciones.update', $retencion->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="empleado_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Empleado</label>
                        <select id="empleado_id" name="empleado_id" required
                            class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-gray-200">
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->id_empleado }}"
                                    {{ $retencion->empleado_id == $empleado->id_empleado ? 'selected' : '' }}>
                                    {{ $empleado->nombre }} {{ $empleado->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="monto_mensual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto Mensual</label>
                        <input type="number" step="0.01" name="monto_mensual" id="monto_mensual" value="{{ old('monto_mensual', $retencion->monto_mensual) }}"
                            class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="activo" id="activo" value="1" {{ $retencion->activo ? 'checked' : '' }}>
                        <label for="activo" class="text-sm text-gray-700 dark:text-gray-300">Activo</label>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('retenciones.index') }}" class="mr-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancelar</a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
