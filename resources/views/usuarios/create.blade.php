<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">

            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        {{ __('¡Ups! Algo salió mal.') }}
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Nombre de Usuario</label>
                    <input type="text" name="nombre_usuario" class="w-full mt-1 rounded-md" value="{{ old('nombre_usuario') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Correo</label>
                    <input type="email" name="email" class="w-full mt-1 rounded-md" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Contraseña</label>
                    <input type="password" name="contraseña" class="w-full mt-1 rounded-md" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
                    <input type="password" name="contraseña_confirmation" class="w-full mt-1 rounded-md" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Crear</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
