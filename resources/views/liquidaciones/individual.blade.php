<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liquidación Individual de Empleados') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="py-2 px-4">#</th>
                        <th class="py-2 px-4">Nombre Completo</th>
                        <th class="py-2 px-4">Salario Base (Gs.)</th>
                        <th class="py-2 px-4">Hijos Menores de 18</th>
                        <th class="py-2 px-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empleados as $empleado)
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4">{{ $empleado->id_empleado }}</td>
                        <td class="py-2 px-4">{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                        <td class="py-2 px-4">{{ number_format($empleado->salario_base, 0, ',', '.') }}</td>
                        <td class="py-2 px-4">{{ $empleado->hijos_menores_18_count }}</td>
                        <td class="py-2 px-4 text-center">
                            <a href="{{ route('liquidaciones.show', $empleado->id_empleado) }}" 
                               class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Liquidar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">No hay empleados para mostrar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $empleados->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
