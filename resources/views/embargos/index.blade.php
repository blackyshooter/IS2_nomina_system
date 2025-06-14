<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Embargos Judiciales') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Listado de Embargos</h3>
                        <a href="{{ route('embargos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Registrar Embargo
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($embargos->isEmpty())
                        <p class="text-center text-gray-600 dark:text-gray-400">No hay embargos registrados.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-xs uppercase">
                                    <tr>
                                        <th class="px-4 py-2">Empleado</th>
                                        <th class="px-4 py-2">Monto Total</th>
                                        <th class="px-4 py-2">Cuota Mensual</th>
                                        <th class="px-4 py-2">Monto Restante</th>
                                        <th class="px-4 py-2">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                    @foreach ($embargos as $embargo)
                                        <tr class="border-b dark:border-gray-600">
                                            <td class="px-4 py-2">
                                                {{ $embargo->empleado->nombre }} {{ $embargo->empleado->apellido }}
                                            </td>
                                            <td class="px-4 py-2">
                                                {{ number_format($embargo->monto_total, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2">
                                                {{ number_format($embargo->cuota_mensual, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2">
                                                {{ number_format($embargo->monto_restante, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2">
                                                {{ $embargo->activo ? 'Activo' : 'Inactivo' }}
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
