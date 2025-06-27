<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuevo Concepto Salarial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('conceptos-salariales.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-2" for="tipo_concepto">Tipo de Concepto</label>
                            <input type="text" name="tipo_concepto" id="tipo_concepto" class="w-full rounded p-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2" for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="w-full rounded p-2" required>
                        </div>

                        <div class="mb-2 flex items-center">
                            <input type="checkbox" name="fijo" id="fijo" class="mr-2">
                            <label for="fijo">Fijo</label>
                        </div>

                        <div class="mb-2 flex items-center">
                            <input type="checkbox" name="afecta_ips" id="afecta_ips" class="mr-2">
                            <label for="afecta_ips">Afecta IPS</label>
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="afecta_aguinaldo" id="afecta_aguinaldo" class="mr-2">
                            <label for="afecta_aguinaldo">Afecta Aguinaldo</label>
                        </div>

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Guardar Concepto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
