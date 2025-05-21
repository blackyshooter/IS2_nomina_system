<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Nuevo Empleado') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Registrar Nuevo Empleado</h2>

        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf

            <!-- Datos Personales -->
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Datos Personales</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cédula</label>
                    <input type="number" name="cedula" required class="input-form" value="{{ old('cedula') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" name="nombre" required class="input-form" value="{{ old('nombre') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                    <input type="text" name="apellido" required class="input-form" value="{{ old('apellido') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" required class="input-form" value="{{ old('fecha_nacimiento') }}">
                </div>
            </div>

            <!-- Datos Laborales -->
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mt-8 mb-4">Datos Laborales</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                    <input type="text" name="telefono" required class="input-form" value="{{ old('telefono') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sueldo Base</label>
                    <input type="number" step="0.01" name="sueldo_base" required class="input-form" value="{{ old('sueldo_base') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" required class="input-form" value="{{ old('fecha_ingreso') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo</label>
                    <input type="text" name="cargo" required class="input-form" value="{{ old('cargo') }}">
                </div>
            </div>

            <!-- Sección para Hijos -->
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mt-8 mb-4">Datos de Hijos</h4>
            <div id="hijos-container">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 hijo-item">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cédula del Hijo</label>
                        <input type="number" name="hijos[0][cedula]" class="input-form" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="hijos[0][nombre]" class="input-form" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                        <input type="text" name="hijos[0][apellido]" class="input-form" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Nacimiento</label>
                        <input type="date" name="hijos[0][fecha_nacimiento]" class="input-form" required>
                    </div>
                </div>
            </div>

            <button type="button" onclick="agregarHijo()" class="mt-4 px-3 py-2 bg-green-500 text-white rounded shadow hover:bg-green-600">Agregar Hijo</button>


            <button type="button" onclick="agregarHijo()" class="mt-4 px-3 py-2 bg-green-500 text-white rounded shadow hover:bg-green-600">Agregar Hijo</button>

            <!-- Botones -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('empleados.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-save">Guardar</button>
            </div>
        </form>
    </div>

    <script>
    let hijoIndex = 1;
    function agregarHijo() {
        let container = document.getElementById('hijos-container');
        let div = document.createElement('div');
        div.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-6', 'hijo-item');
        div.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cédula del Hijo</label>
                <input type="number" name="hijos[${hijoIndex}][cedula]" class="input-form" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input type="text" name="hijos[${hijoIndex}][nombre]" class="input-form" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                <input type="text" name="hijos[${hijoIndex}][apellido]" class="input-form" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Nacimiento</label>
                <input type="date" name="hijos[${hijoIndex}][fecha_nacimiento]" class="input-form" required>
            </div>
        `;
        container.appendChild(div);
        hijoIndex++;
    }
</script>
</x-app-layout>