<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Conceptos Salariales</h2>
    </x-slot>

    <div class="p-6 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulario de creación -->
        <form method="POST" action="{{ route('conceptos.store') }}" class="bg-white shadow-md rounded px-6 py-4 space-y-4">
            @csrf
            <div>
                <label class="block font-semibold">Tipo de Concepto:</label>
                <select name="tipo_concepto" class="border rounded px-2 py-1 w-full" required>
                    <option value="">Seleccione...</option>
                    <option value="credito">Crédito</option>
                    <option value="debito">Débito</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold">Descripción:</label>
                <input type="text" name="descripcion" class="border rounded px-2 py-1 w-full" required>
            </div>
            <div class="flex gap-4">
                <label><input type="checkbox" name="fijo"> Fijo</label>
                <label><input type="checkbox" name="afecta_ips"> Afecta IPS</label>
                <label><input type="checkbox" name="afecta_aguinaldo"> Afecta Aguinaldo</label>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Agregar Concepto
            </button>
        </form>

        <!-- Tabla de conceptos existentes -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 mt-6 bg-white shadow rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Fijo</th>
                        <th class="px-4 py-2">IPS</th>
                        <th class="px-4 py-2">Aguinaldo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($conceptos as $c)
                        <tr>
                            <td class="px-4 py-2">{{ $c->descripcion }}</td>
                            <td class="px-4 py-2 capitalize">{{ $c->tipo_concepto }}</td>
                            <td class="px-4 py-2">{{ $c->fijo ? 'Sí' : 'No' }}</td>
                            <td class="px-4 py-2">{{ $c->afecta_ips ? 'Sí' : 'No' }}</td>
                            <td class="px-4 py-2">{{ $c->afecta_aguinaldo ? 'Sí' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-3 text-gray-500">No hay conceptos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
