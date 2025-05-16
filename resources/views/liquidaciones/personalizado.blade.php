<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liquidación Personalizada
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('liquidaciones.liquidarPersonalizado') }}" class="space-y-6 bg-white dark:bg-gray-900 p-6 rounded-lg shadow border border-gray-300 dark:border-gray-700">
            @csrf

            <div>
                <label for="empleado_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Empleado
                </label>
                <select
                    id="empleado_id"
                    name="empleado_id"
                    required
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 sm:text-sm"
                >
                    <option value="">--Seleccione--</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id_empleado }}">
                            {{ $empleado->nombre }} {{ $empleado->apellido }}
                        </option>
                    @endforeach
                </select>
            </div>

            <fieldset>
                <legend class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">
                    Montos por Concepto
                </legend>

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($conceptos as $concepto)
                        <div class="flex items-center space-x-4">
                            <label class="w-1/2 text-gray-700 dark:text-gray-300" for="monto_{{ $concepto->id_concepto }}">
                                {{ $concepto->descripcion }}
                            </label>
                            <input
                                id="monto_{{ $concepto->id_concepto }}"
                                type="number"
                                name="montos[{{ $concepto->id_concepto }}]"
                                step="0.01"
                                min="0"
                                value="0"
                                class="w-1/2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 sm:text-sm"
                            />
                        </div>
                    @endforeach
                </div>
            </fieldset>

            <div>
                <button
                    type="submit"
                    class="inline-flex justify-center px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-blue-800"
                >
                    Liquidar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
