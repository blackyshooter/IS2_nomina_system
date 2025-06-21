<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Datos Personales del Empleado') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Información Detallada</h3>

                <table class="min-w-full table-auto">
                    <tr><td class="font-bold">Nombre:</td><td>{{ $empleado->nombre }}</td></tr>
                    <tr><td class="font-bold">Apellido:</td><td>{{ $empleado->apellido }}</td></tr>
                    <tr><td class="font-bold">Cédula de Identidad:</td><td>{{ $empleado->cedula }}</td></tr>
                    <tr><td class="font-bold">Correo Personal:</td><td>{{ $empleado->correo }}</td></tr>
                    <tr><td class="font-bold">Cargo:</td><td>{{ $empleado->cargo->nombre ?? 'Sin asignar' }}</td></tr>
                    <tr><td class="font-bold">Teléfono:</td><td>{{ $empleado->telefono }}</td></tr>
                    <tr><td class="font-bold">Usuario Asignado:</td><td>{{ $empleado->usuario->nombre ?? 'No asignado' }}</td></tr>
                    <tr><td class="font-bold">Correo Asignado:</td><td>{{ $empleado->usuario->correo ?? 'No asignado' }}</td></tr>
                    <tr><td class="font-bold">Salario Base:</td><td>{{ number_format($empleado->salario_base, 0, ',', '.') }} Gs</td></tr>
                    <tr><td class="font-bold">Antigüedad:</td><td>
                        @php
                            $ingreso = \Carbon\Carbon::parse($empleado->fecha_ingreso);
                            $diff = $ingreso->diff(now());
                            echo "{$diff->y} año(s), {$diff->m} mes(es)";
                        @endphp
                    </td></tr>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
