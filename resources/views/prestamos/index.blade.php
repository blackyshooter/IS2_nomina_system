<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Préstamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Listado de Préstamos Registrados</h3>
                        {{-- ***************************************************************** --}}
                        {{-- ¡CAMBIO CRÍTICO AQUÍ! Limpiando el botón "Registrar Nuevo Préstamo" --}}
                        {{-- ***************************************************************** --}}
                        <a href="{{ route('prestamos.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Registrar Nuevo Préstamo
                        </a>
                        {{-- ***************************************************************** --}}
                        {{-- FIN DEL CAMBIO --}}
                        {{-- ***************************************************************** --}}
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($prestamos->isEmpty())
                        <p class="text-center text-lg">No hay préstamos registrados.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Empleado</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Monto Total</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Monto Cuota</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cuotas Restantes</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha Inicio Pago</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Activo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($prestamos as $prestamo)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            @if($prestamo->empleado)
                                                {{ $prestamo->empleado->nombre }} {{ $prestamo->empleado->apellido }}
                                            @else
                                                <span class="text-red-500">Empleado no encontrado</span>
                                            @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($prestamo->monto_total, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($prestamo->monto_cuota, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $prestamo->cuotas_restantes }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $prestamo->fecha_inicio_pago->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $prestamo->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $prestamo->activo ? 'Sí' : 'No' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('prestamos.edit', $prestamo) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600">Editar</a>
                                                <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este préstamo?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>