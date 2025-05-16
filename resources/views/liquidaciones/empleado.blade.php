<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liquidación de {{ $empleado->nombre }} {{ $empleado->apellido }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow overflow-hidden sm:rounded-lg p-6">
            <p><strong>Salario Base:</strong> {{ number_format($empleado->salario_base, 2, ',', '.') }} Gs.</p>
            <p><strong>Bonificación por hijos:</strong> {{ number_format($liquidacion['bonificacion_hijos'], 2, ',', '.') }} Gs.</p>
            <p><strong>IPS (9% sobre imponibles):</strong> {{ number_format($liquidacion['ips'], 2, ',', '.') }} Gs.</p>
            <hr class="my-4">
            <h3 class="text-lg font-semibold mb-2">Conceptos individuales:</h3>
            <ul class="list-disc list-inside">
                @foreach ($liquidacion['conceptos'] as $concepto)
                    <li>
                        {{ $concepto->descripcion }} ({{ ucfirst($concepto->tipo_concepto) }}): {{ number_format($concepto->monto, 2, ',', '.') }} Gs.
                    </li>
                @endforeach
            </ul>
            <hr class="my-4">
            <p><strong>Total a pagar:</strong> {{ number_format($liquidacion['total'], 2, ',', '.') }} Gs.</p>
        </div>
    </div>
</x-app-layout>
