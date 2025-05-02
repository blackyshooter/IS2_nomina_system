<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Agregar Empleado</h2>
    </x-slot>

    <div class="py-6 px-4">
        <form method="POST" action="{{ route('empleados.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Datos personales -->
                <div>
                    <label for="nombre" class="block">Nombre</label>
                    <input type="text" name="nombre" class="w-full rounded" required>
                </div>
                <div>
                    <label for="apellido" class="block">Apellido</label>
                    <input type="text" name="apellido" class="w-full rounded" required>
                </div>
                <div>
                    <label for="cedula" class="block">Cédula</label>
                    <input type="text" name="cedula" class="w-full rounded" required>
                </div>
                <!-- Más campos aquí -->

                <!-- Sección de hijos -->
                <div class="col-span-2 mt-4">
                    <label for="hijos" class="block mb-2">Hijos (Nombre y Edad)</label>
                    <div id="hijos-container" class="space-y-2">
                        <div class="flex gap-2">
                            <input type="text" name="hijos[0][nombre]" placeholder="Nombre" class="rounded w-1/2" required>
                            <input type="number" name="hijos[0][edad]" placeholder="Edad" class="rounded w-1/2" required>
                        </div>
                    </div>
                    <button type="button" onclick="agregarHijo()" class="mt-2 px-4 py-1 bg-green-500 text-white rounded">
                        + Agregar otro hijo
                    </button>
                </div>
            </div>

            <button type="submit" class="mt-6 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Guardar Empleado
            </button>
        </form>
    </div>

    <script>
        let hijoIndex = 1;
        function agregarHijo() {
            const container = document.getElementById('hijos-container');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2');
            div.innerHTML = `
                <input type="text" name="hijos[${hijoIndex}][nombre]" placeholder="Nombre" class="rounded w-1/2" required>
                <input type="number" name="hijos[${hijoIndex}][edad]" placeholder="Edad" class="rounded w-1/2" required>
            `;
            container.appendChild(div);
            hijoIndex++;
        }
    </script>
</x-app-layout>
