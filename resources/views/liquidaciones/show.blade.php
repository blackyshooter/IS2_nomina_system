<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liquidar Empleado: ') }} {{ $empleado->nombre }} {{ $empleado->apellido }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('liquidaciones.liquidar', $empleado->id_empleado) }}" method="POST">
            @csrf
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-4">

                @foreach($detalle['conceptos'] as $concepto)
                    <div class="flex justify-between items-center">
                        <label class="font-semibold">{{ $concepto['descripcion'] }}</label>
                        <input type="number" step="0.01" min="0" name="montos[{{ $concepto['concepto_id'] }}]" 
                               value="{{ old('montos.' . $concepto['concepto_id'], $concepto['monto']) }}"
                               class="border rounded px-3 py-1 w-32 text-right" required>
                    </div>
                @endforeach

                <div class="flex justify-between font-bold text-lg pt-4 border-t border-gray-300">
                    <span>Total a Pagar:</span>
                    <span>{{ number_format($detalle['total_neto'], 0, ',', '.') }} Gs.</span>
                </div>

                <div class="pt-6">
                    <button type="submit" 
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                        Confirmar Liquidación
                    </button>
                    <a href="{{ route('liquidaciones.individual') }}" 
                       class="ml-4 text-gray-600 hover:underline">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
