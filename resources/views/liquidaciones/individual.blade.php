<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Liquidación Individual de Empleados') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-200 text-green-900 rounded-md shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 shadow-md sm:rounded-lg p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <th class="py-3 px-5 text-sm font-medium text-gray-700 dark:text-gray-300">#</th>
                        <th class="py-3 px-5 text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Completo</th>
                        <th class="py-3 px-5 text-sm font-medium text-gray-700 dark:text-gray-300">Salario Base (Gs.)</th>
                        <th class="py-3 px-5 text-sm font-medium text-gray-700 dark:text-gray-300">Hijos Menores de 18</th>
                        <th class="py-3 px-5 text-sm font-medium text-center text-gray-700 dark:text-gray-300">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empleados as $empleado)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <td class="py-4 px-5 text-gray-900 dark:text-gray-100 font-semibold">{{ $empleado->id_empleado }}</td>
                        <td class="py-4 px-5 text-gray-900 dark:text-gray-100">{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                        <td class="py-4 px-5 text-gray-900 dark:text-gray-100">{{ number_format($empleado->salario_base, 0, ',', '.') }}</td>
                        <td class="py-4 px-5 text-gray-900 dark:text-gray-100 text-center">{{ $empleado->hijos_menores_18_count }}</td>
                        <td class="py-4 px-5 text-center">
                            <a href="{{ route('liquidaciones.show', $empleado->id_empleado) }}" 
                               class="inline-block px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                                Liquidar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400 italic">No hay empleados para mostrar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-8">
                {{ $empleados->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
