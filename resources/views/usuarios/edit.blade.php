<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">✏️ Editar Usuario</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Modifica los datos del usuario en el sistema.</p>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                {{-- Nombre de Usuario --}}
                <div>
                    <label for="nombre_usuario" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">👤 Nombre de Usuario</label>
                    <input
                        type="text"
                        id="nombre_usuario"
                        name="nombre_usuario"
                        value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}"
                        required
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2 transition focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('nombre_usuario')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📧 Correo Electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $usuario->email) }}"
                        required
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2 transition focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        🔒 Contraseña <span class="text-xs text-gray-500 dark:text-gray-400">(Dejar vacío si no se cambia)</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2 transition focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Empleado --}}
                <div>
                    <label for="id_empleado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🏷️ Empleado</label>
                    <select
                        id="id_empleado"
                        name="id_empleado"
                        required
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2 transition focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="" disabled {{ old('id_empleado', $usuario->id_empleado) ? '' : 'selected' }}>-- Seleccionar Empleado --</option>
                        @foreach($empleados as $empleado)
                            <option
                                value="{{ $empleado->id_empleado }}"
                                {{ old('id_empleado', $usuario->id_empleado) == $empleado->id_empleado ? 'selected' : '' }}
                            >
                                {{ $empleado->nombre }} {{ $empleado->apellido }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_empleado')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botón de envío --}}
                <div class="md:col-span-2 flex justify-end pt-4">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow transition focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                        💾 Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
