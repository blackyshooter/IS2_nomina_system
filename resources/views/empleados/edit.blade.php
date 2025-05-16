<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Editar Empleado</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 p-8 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <form method="POST" action="{{ route('empleados.update', $empleado->id_empleado) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Datos Básicos --}}
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $empleado->nombre) }}"
                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    required>
                @error('nombre') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Apellido</label>
                <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $empleado->apellido) }}"
                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2"
                    required>
                @error('apellido') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="cedula" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cédula</label>
                    <input type="text" name="cedula" id="cedula" value="{{ old('cedula', $empleado->cedula) }}"
                        class="w-full rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-100 px-4 py-2" required>
                    @error('cedula') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo</label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo', $empleado->correo) }}"
                        class="w-full rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-100 px-4 py-2" required>
                    @error('correo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $empleado->telefono) }}"
                        class="w-full rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-100 px-4 py-2">
                    @error('telefono') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                        value="{{ old('fecha_ingreso', $empleado->fecha_ingreso->format('Y-m-d')) }}"
                        class="w-full rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-100 px-4 py-2" required>
                    @error('fecha_ingreso') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento->format('Y-m-d')) }}"
                        class="w-full rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-100 px-4 py-2" required>
                    @error('fecha_nacimiento') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Sueldo Base --}}
            <div>
                <label for="sueldo_base" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sueldo Base</label>
                <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" value="{{ old('sueldo_base', $empleado->sueldo_base) }}"
                    class="w-full rounded-md border bg-gray-50 dark:bg-gray-700 dark:text-gray-100 px-4 py-2" required>
                @error('sueldo_base') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Hijos --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Hijos (Opcional)</h3>
                <div id="hijos-container" class="space-y-4">
                    @php $oldHijos = old('hijos', $empleado->hijos->toArray()); @endphp
                    @foreach ($oldHijos as $index => $hijo)
                        <div class="relative p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700">
                            <button type="button" onclick="this.parentNode.remove()"
                                class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                &times;
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                    <input type="text" name="hijos[{{ $index }}][nombre]" value="{{ $hijo['nombre'] ?? '' }}"
                                        class="w-full rounded-md border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                                    <input type="text" name="hijos[{{ $index }}][apellido]" value="{{ $hijo['apellido'] ?? '' }}"
                                        class="w-full rounded-md border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Nacimiento</label>
                                    <input type="date" name="hijos[{{ $index }}][fecha_nacimiento]" value="{{ $hijo['fecha_nacimiento'] ?? '' }}"
                                        class="w-full rounded-md border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="agregarHijo()"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500">
                    + Agregar Hijo
                </button>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('empleados.index') }}"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-100 rounded hover:bg-gray-400 dark:hover:bg-gray-500">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Actualizar
                </button>
            </div>
        </form>
    </div>

    <script>
        let hijoIndex = {{ count($oldHijos) }};

        function agregarHijo() {
            const container = document.getElementById('hijos-container');
            const div = document.createElement('div');
            div.className = "relative p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 mt-4";

            div.innerHTML = `
                <button type="button" onclick="this.parentNode.remove()" class="absolute top-2 right-2 text-red-500 hover:text-red-700">&times;</button>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="hijos[\${hijoIndex}][nombre]" class="w-full rounded-md border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                        <input type="text" name="hijos[\${hijoIndex}][apellido]" class="w-full rounded-md border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Nacimiento</label>
                        <input type="date" name="hijos[\${hijoIndex}][fecha_nacimiento]" class="w-full rounded-md border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2" />
                    </div>
                </div>
            `;

            container.appendChild(div);
            hijoIndex++;
        }
    </script>
</x-app-layout>
