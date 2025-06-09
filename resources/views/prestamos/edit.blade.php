
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Préstamo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('prestamos.update', $prestamo) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="empleado_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Empleado</label>
                            <select id="empleado_id" name="empleado_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">Seleccione un empleado</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id_empleado }}" {{ (old('empleado_id', $prestamo->empleado_id) == $empleado->id_empleado) ? 'selected' : '' }}>
                                        {{ $empleado->nombre }} {{ $empleado->apellido }} (Cédula: {{ $empleado->cedula }})
                                    </option>
                                @endforeach
                            </select>
                            @error('empleado_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="monto_total" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto Total del Préstamo</label>
                            <input type="number" step="0.01" id="monto_total" name="monto_total" value="{{ old('monto_total', $prestamo->monto_total) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('monto_total')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="monto_cuota" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto de la Cuota por Período</label>
                            <input type="number" step="0.01" id="monto_cuota" name="monto_cuota" value="{{ old('monto_cuota', $prestamo->monto_cuota) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('monto_cuota')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cuotas_restantes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cuotas Restantes</label>
                            <input type="number" id="cuotas_restantes" name="cuotas_restantes" value="{{ old('cuotas_restantes', $prestamo->cuotas_restantes) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('cuotas_restantes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fecha_inicio_pago" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Inicio de Pago</label>
                            <input type="date" id="fecha_inicio_pago" name="fecha_inicio_pago" value="{{ old('fecha_inicio_pago', $prestamo->fecha_inicio_pago->format('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('fecha_inicio_pago')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción (Opcional)</label>
                            <textarea id="descripcion" name="descripcion" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('descripcion', $prestamo->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $prestamo->activo) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            <label for="activo" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Préstamo Activo</label>
                            @error('activo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('prestamos.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Actualizar Préstamo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>