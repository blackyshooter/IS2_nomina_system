<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Asignar Roles a Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('asignar_roles.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300">Usuario</label>
                    <select name="usuario_id" class="w-full mt-1 rounded-md" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300">Roles</label>
                    <select name="roles[]" multiple class="w-full mt-1 rounded-md" required>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Asignar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
