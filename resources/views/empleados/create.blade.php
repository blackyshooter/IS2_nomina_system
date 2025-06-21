<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-100 dark:text-gray-200">
            Nuevo Empleado
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-6">
        {{-- Mostrar todos los errores de validación --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 rounded text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('empleados.store') }}" class="bg-gray-900 dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
            @csrf

            <!-- Campos básicos empleado -->
            <div>
                <label class="block text-gray-300 font-medium mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('nombre')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('apellido')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Cédula</label>
                <input type="text" name="cedula" value="{{ old('cedula') }}" required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('cedula')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Correo</label>
                <input type="email" name="correo" value="{{ old('correo') }}" required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('correo')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}"
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('telefono')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('fecha_ingreso')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('fecha_nacimiento')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!--bloque de cargos-->
            <div class="mb-4">
                <label for="cargo" class="block text-gray-700 font-bold mb-2">Cargo:</label>
                <select name="cargo" id="cargo" class="border rounded px-3 py-2 w-full">
                    <option value="Administrador">Administrador</option>
                    <option value="Gerente/RRHH">Gerente/RRHH</option>
                    <option value="Asistente de RRHH">Asistente de RRHH</option>
                    <option value="Empleado">Empleado</option>
                </select>
            </div>

            <!-- Salario Base -->
            <div>
                <label class="block text-gray-300 font-medium mb-1">Salario Base</label>
                <input type="number" name="salario_base" value="{{ old('salario_base') }}" step="0.01" min="0" required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                @error('salario_base')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hijos -->
            <div id="hijos-container" class="space-y-4">
                <h3 class="text-gray-200 text-lg font-semibold mb-2">Hijos (opcional)</h3>

                <p class="text-sm text-gray-400 mb-2">Puede dejar en blanco esta sección si el empleado no tiene hijos.</p>

                <button type="button" onclick="agregarHijo()"
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md mb-2">+ Agregar hijo
                </button>

                @if(old('hijos'))
                    @foreach(old('hijos') as $index => $hijo)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-800 p-4 rounded-md border border-gray-600 relative">
                            <div>
                                <label class="block text-gray-300 font-medium mb-1">Nombre del hijo</label>
                                <input type="text" name="hijos[{{ $index }}][nombre]" value="{{ $hijo['nombre'] }}"
                                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                                    required>
                                @error("hijos.$index.nombre")
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-300 font-medium mb-1">Apellido del hijo</label>
                                <input type="text" name="hijos[{{ $index }}][apellido]" value="{{ $hijo['apellido'] ?? '' }}"
                                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-gray-300 font-medium mb-1">Fecha de nacimiento</label>
                                <input type="date" name="hijos[{{ $index }}][fecha_nacimiento]"
                                    value="{{ $hijo['fecha_nacimiento'] }}"
                                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                                    required>
                                @error("hijos.$index.fecha_nacimiento")
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('empleados.index') }}"
                    class="inline-block px-5 py-2 border border-gray-600 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition">Cancelar</a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-md transition">Guardar</button>
            </div>
        </form>
    </div>

    <script>
        let contadorHijos = {{ old('hijos') ? count(old('hijos')) : 0 }};

        function agregarHijo() {
            const container = document.getElementById('hijos-container');

            const div = document.createElement('div');
            div.classList.add('grid', 'grid-cols-1', 'md:grid-cols-3', 'gap-4', 'bg-gray-800', 'p-4', 'rounded-md', 'border', 'border-gray-600', 'relative');

            div.innerHTML = `
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Nombre del hijo</label>
                    <input type="text" name="hijos[${contadorHijos}][nombre]" class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Apellido del hijo</label>
                    <input type="text" name="hijos[${contadorHijos}][apellido]" class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Fecha de nacimiento</label>
                    <input type="date" name="hijos[${contadorHijos}][fecha_nacimiento]" class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2" required>
                </div>
            `;
            container.appendChild(div);
            contadorHijos++;
        }
    </script>
</x-app-layout>
