<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Empleado') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Formulario de Empleado</h2>

        <!-- Formulario para crear un empleado -->
        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Datos de la persona (nombre, apellido, cédula, fecha nacimiento) -->
                <div>
                    <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                    <input type="text" name="cedula" id="cedula" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <!-- Datos del empleado (teléfono, sueldo, cargo, fecha ingreso) -->
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="sueldo_base" class="block text-sm font-medium text-gray-700">Sueldo Base</label>
                    <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="cargo" class="block text-sm font-medium text-gray-700">Cargo</label>
                    <input type="text" name="cargo" id="cargo" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>

                <!-- Botón para abrir el modal de hijos -->
                <button type="button" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md" data-modal-toggle="hijosModal">
                    Agregar Hijos
                </button>

                <!-- Botón para enviar el formulario -->
                <button type="submit" class="mt-6 px-4 py-2 bg-blue-600 text-white rounded-md">Guardar Empleado</button>
            </div>

            <!-- Modal para agregar hijos -->
            <div id="hijosModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-md w-96">
                    <h3 class="text-lg font-semibold mb-4">Agregar Hijos</h3>

                    <div id="hijosList">
                        <!-- Aquí se agregarán los hijos dinámicamente -->
                    </div>

                    <div class="mt-4">
                        <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md" id="addHijo">
                            Agregar Hijo
                        </button>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md" data-modal-toggle="hijosModal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let hijoIndex = 0;
        document.getElementById('addHijo').addEventListener('click', function() {
            hijoIndex++;
            const hijoHTML = `
                <div class="mb-4" id="hijo-${hijoIndex}">
                    <h4 class="font-medium">Hijo ${hijoIndex}</h4>
                    <label for="hijo_nombre_${hijoIndex}" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="hijos[${hijoIndex}][nombre]" id="hijo_nombre_${hijoIndex}" class="mt-1 block w-full border-gray-300 rounded-md">

                    <label for="hijo_apellido_${hijoIndex}" class="block text-sm font-medium text-gray-700 mt-2">Apellido</label>
                    <input type="text" name="hijos[${hijoIndex}][apellido]" id="hijo_apellido_${hijoIndex}" class="mt-1 block w-full border-gray-300 rounded-md">

                    <label for="hijo_fecha_nacimiento_${hijoIndex}" class="block text-sm font-medium text-gray-700 mt-2">Fecha de Nacimiento</label>
                    <input type="date" name="hijos[${hijoIndex}][fecha_nacimiento]" id="hijo_fecha_nacimiento_${hijoIndex}" class="mt-1 block w-full border-gray-300 rounded-md">
                    
                    <button type="button" class="mt-2 px-4 py-2 bg-red-600 text-white rounded-md" onclick="removeHijo(${hijoIndex})">
                        Eliminar Hijo
                    </button>
                </div>
            `;
            document.getElementById('hijosList').insertAdjacentHTML('beforeend', hijoHTML);
        });

        function removeHijo(index) {
            document.getElementById(`hijo-${index}`).remove();
        }
    </script>
</x-app-layout>
