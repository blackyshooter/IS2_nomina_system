<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('usuarios.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Crear Usuario</a>

            <div class="mt-6 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-green-500">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Correo</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $usuario->id }}</td>
                                <td class="px-4 py-2">{{ $usuario->nombre }}</td>
                                <td class="px-4 py-2">{{ $usuario->correo }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('usuarios.edit', $usuario) }}" class="text-blue-500">Editar</a> |
                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
