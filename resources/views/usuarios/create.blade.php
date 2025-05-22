<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 leading-tight">Nuevo Usuario</h2>
    </x-slot>

    <form method="POST" action="{{ route('usuarios.store') }}" class="max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
        @csrf

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-1">Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario') }}" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
            @error('nombre_usuario') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-1">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-1">Empleado</label>
            <select name="id_empleado" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
                <option value="">-- Seleccionar Empleado --</option>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id_empleado }}" {{ old('id_empleado') == $empleado->id_empleado ? 'selected' : '' }}>
                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                    </option>
                @endforeach
            </select>
            @error('id_empleado') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
            <a href="{{ route('usuarios.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
        </div>
    </form>
</x-app-layout>
