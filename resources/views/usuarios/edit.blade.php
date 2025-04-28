<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" name="nombre" value="{{ $usuario->nombre }}" class="w-full mt-1 rounded-md" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300">Correo</label>
                    <input type="email" name="correo" value="{{ $usuario->correo }}" class="w-full mt-1 rounded-md" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
