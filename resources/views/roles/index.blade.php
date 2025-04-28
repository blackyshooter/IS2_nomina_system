<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Crear Rol</a>

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
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $rol->id }}</td>
                                <td class="px-4 py-2">{{ $rol->nombre }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('roles.edit', $rol) }}" class="text-blue-500">Editar</a> |
                                    <form action="{{ route('roles.destroy', $rol) }}" method="POST" class="inline">
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
