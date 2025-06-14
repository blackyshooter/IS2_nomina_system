<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado de Retenciones Sindicales') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Registros de Retenciones</h3>
                    <a href="{{ route('retenciones.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nueva Retención</a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($retenciones->isEmpty())
                    <p class="text-gray-600">No se encontraron retenciones registradas.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                <tr>
                                    <th class="px-4 py-2 text-left">Empleado</th>
                                    <th class="px-4 py-2 text-left">Monto Mensual</th>
                                    <th class="px-4 py-2 text-left">Activo</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($retenciones as $retencion)
                                    <tr>
                                        <td class="px-4 py-2">
                                            @if ($retencion->empleado)
                                                {{ $retencion->empleado->nombre }} {{ $retencion->empleado->apellido }}
                                            @else
                                                <em>Empleado no encontrado</em>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">{{ number_format($retencion->monto_mensual, 0, ',', '.') }} Gs</td>
                                        <td class="px-4 py-2">
                                            @if ($retencion->activo)
                                                <span class="text-green-600 font-semibold">Sí</span>
                                            @else
                                                <span class="text-red-600 font-semibold">No</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 flex space-x-3">
                                            <a href="{{ route('retenciones.edit', $retencion->id) }}" class="text-blue-500 hover:underline">Editar</a>
                                            <form action="{{ route('retenciones.destroy', $retencion->id) }}" method="POST" onsubmit="return confirm('¿Eliminar retención?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-500 hover:underline">Eliminar</button>
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
</x-app-layout>
