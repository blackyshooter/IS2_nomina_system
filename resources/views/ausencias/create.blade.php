
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Nueva Ausencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('ausencias.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="empleado_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Empleado</label>
                            <select id="empleado_id" name="empleado_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">Seleccione un empleado</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </option>
                                @endforeach
                            </select>
                            @error('empleado_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('fecha_inicio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @error('fecha_fin')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipo_ausencia" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Ausencia</label>
                            <select id="tipo_ausencia" name="tipo_ausencia" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">Seleccione un tipo</option>
                                <option value="justificada" {{ old('tipo_ausencia') == 'justificada' ? 'selected' : '' }}>Justificada (sin descuento)</option>
                                <option value="injustificada" {{ old('tipo_ausencia') == 'injustificada' ? 'selected' : '' }}>Injustificada (con descuento)</option>
                                <option value="vacaciones" {{ old('tipo_ausencia') == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                                <option value="enfermedad" {{ old('tipo_ausencia') == 'enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                            </select>
                            @error('tipo_ausencia')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observaciones (Opcional)</label>
                            <textarea id="observaciones" name="observaciones" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('ausencias.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Guardar Ausencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>