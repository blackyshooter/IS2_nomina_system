<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Resumen de Nómina</h2>
    </x-slot>

    <div class="py-4 px-6">
        <form method="GET" class="mb-4">
            <input type="text" name="buscar" placeholder="Buscar por nombre"
                class="border px-3 py-1 rounded" value="{{ request('buscar') }}">
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Buscar</button>
            <a href="{{ route('nomina.excel') }}" class="bg-green-500 text-white px-3 py-1 rounded ml-2">Exportar Excel</a>
            <a href="{{ route('nomina.pdf') }}" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Exportar PDF</a>
        </form>

        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Nombre</th>
                    <th class="border px-4 py-2">Sueldo Base</th>
                    <th class="border px-4 py-2">Bonificación</th>
                    <th class="border px-4 py-2">IPS</th>
                    <th class="border px-4 py-2">Salario Neto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $item['nombre'] }}</td>
                        <td class="border px-4 py-2">{{ number_format($item['sueldo_base'], 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ number_format($item['bonificacion'], 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ number_format($item['ips'], 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ number_format($item['salario_neto'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
