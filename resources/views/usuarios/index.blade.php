<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 leading-tight">
            Lista de Usuarios
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <div class="mb-4 flex justify-end">
            <a href="{{ route('usuarios.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Nuevo Usuario
            </a>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre de Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Empleado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $usuario->id_usuario }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $usuario->nombre_usuario }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $usuario->empleado ? $usuario->empleado->nombre . ' ' . $usuario->empleado->apellido : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Editar</a>
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
