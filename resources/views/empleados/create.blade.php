<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-100 dark:text-gray-200">
            Nuevo Empleado
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-6">
        <form method="POST" action="{{ route('empleados.store') }}" class="bg-gray-900 dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
            @csrf

            <div>
                <label class="block text-gray-300 dark:text-gray-400 font-medium mb-1">Nombre</label>
                <input 
                    type="text" 
                    name="nombre" 
                    value="{{ old('nombre') }}" 
                    required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                >
                @error('nombre') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Apellido</label>
                <input 
                    type="text" 
                    name="apellido" 
                    value="{{ old('apellido') }}" 
                    required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                >
                @error('apellido') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Cédula</label>
                <input 
                    type="text" 
                    name="cedula" 
                    value="{{ old('cedula') }}" 
                    required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                >
                @error('cedula') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Correo</label>
                <input 
                    type="email" 
                    name="correo" 
                    value="{{ old('correo') }}" 
                    required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                >
                @error('correo') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Teléfono</label>
                <input 
                    type="text" 
                    name="telefono" 
                    value="{{ old('telefono') }}" 
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                >
                @error('telefono') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Fecha de Ingreso</label>
                <input 
                    type="date" 
                    name="fecha_ingreso" 
                    value="{{ old('fecha_ingreso') }}" 
                    required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                >
                @error('fecha_ingreso') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-1">Fecha de Nacimiento</label>
                <input 
                    type="date" 
                    name="fecha_nacimiento" 
                    value="{{ old('fecha_nacimiento') }}" 
                    required
                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                >
                @error('fecha_nacimiento') 
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Sección de hijos -->
            <div id="hijos-container" class="space-y-4">
                <h3 class="text-gray-200 text-lg font-semibold mb-2">Hijos (opcional)</h3>

                <button type="button" onclick="agregarHijo()" 
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md mb-2">
                    + Agregar hijo
                </button>

                @if(old('hijos'))
                    @foreach(old('hijos') as $index => $hijo)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-800 p-4 rounded-md">
                            <div>
                                <label class="block text-gray-300 font-medium mb-1">Nombre del hijo</label>
                                <input 
                                    type="text" 
                                    name="hijos[{{ $index }}][nombre]" 
                                    value="{{ $hijo['nombre'] }}" 
                                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                                >
                                @error("hijos.$index.nombre")
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-300 font-medium mb-1">Apellido del hijo</label>
                                <input 
                                    type="text" 
                                    name="hijos[{{ $index }}][apellido]" 
                                    value="{{ $hijo['apellido'] ?? '' }}" 
                                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                                >
                            </div>
                            <div>
                                <label class="block text-gray-300 font-medium mb-1">Fecha de nacimiento</label>
                                <input 
                                    type="date" 
                                    name="hijos[{{ $index }}][fecha_nacimiento]" 
                                    value="{{ $hijo['fecha_nacimiento'] }}" 
                                    class="w-full rounded-md bg-gray-700 text-gray-100 border border-gray-600 px-3 py-2"
                                >
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
                   class="inline-block px-5 py-2 border border-gray-600 rounded-md text-gray-400 hover:bg-gray-700 hover:text-white transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-md transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <!-- Script para agregar dinámicamente hijos -->
    <script>
        let contadorHijos = {{ old('hijos') ? count(old('hijos')) : 0 }};

        function agregarHijo() {
            const container = document.getElementById('hijos-container');

            const div = document.createElement('div');
            div.classList.add('grid', 'grid-cols-1', 'md:grid-cols-3', 'gap-4', 'bg-gray-800', 'p-4', 'rounded-md');

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
