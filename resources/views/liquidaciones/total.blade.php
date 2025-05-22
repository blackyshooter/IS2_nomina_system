<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Liquidar Todos los Empleados
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Mensajes flash --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('liquidaciones.liquidar-total') }}" class="mb-6 text-center">
            @csrf
            {{-- Envío del periodo (ejemplo: 2025-05) --}}
            <input type="hidden" name="periodo" value="{{ now()->format('Y-m') }}">
            <button
                type="submit"
                class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring
                focus:ring-blue-300 dark:focus:ring-blue-800 text-white font-semibold rounded-md transition"
            >
                Liquidar Todos
            </button>
        </form>

        <div class="overflow-x-auto rounded-lg shadow border border-gray-300 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Salario Base
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Hijos Menores 18
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Liquidaciones (Periodo - Concepto - Monto)
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($empleados as $empleado)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center">
                                {{ $empleado->id_empleado }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 text-center">
                                {{ $empleado->nombre }} {{ $empleado->apellido }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center">
                                {{ number_format($empleado->salario_base, 0, ',', '.') }} Gs.
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center">
                                {{ $empleado->hijos_menores_18_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 text-center">
                                @if($empleado->liquidacionDetalles->isEmpty())
                                    <em>No hay liquidaciones</em>
                                @else
                                    <ul class="list-disc list-inside text-left inline-block">
                                        @foreach($empleado->liquidacionDetalles as $detalle)
                                            <li>
                                                {{ $detalle->cabecera->periodo ?? 'N/D' }} - 
                                                Concepto {{ $detalle->concepto_id }} - 
                                                {{ number_format($detalle->monto, 2, ',', '.') }} Gs.
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
