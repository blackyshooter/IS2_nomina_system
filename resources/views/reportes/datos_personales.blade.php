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

                <table class="table-auto w-full mb-6 bg-white dark:bg-gray-800 rounded shadow">
                    <tbody class="text-gray-800 dark:text-gray-100">
                        <tr><td class="font-semibold">Nombre:</td><td>{{ $empleado->nombre }}</td></tr>
                        <tr><td class="font-semibold">Apellido:</td><td>{{ $empleado->apellido }}</td></tr>
                        <tr><td class="font-semibold">Cédula de Identidad:</td><td>{{ $empleado->cedula }}</td></tr>
                        <tr><td class="font-semibold">Correo Personal:</td><td>{{ $empleado->correo }}</td></tr>
                        <tr><td class="font-semibold">Cargo:</td><td>{{ $cargoActual }}</td></tr>
                        <tr><td class="font-semibold">Teléfono:</td><td>{{ $empleado->telefono }}</td></tr>
                        <tr><td class="font-semibold">Usuario Asignado:</td><td>{{ $usuarioAsignado->nombre_usuario ?? 'No asignado' }}</td></tr>
                        <tr><td class="font-semibold">Correo Asignado:</td><td>{{ $usuarioAsignado->email ?? 'No asignado' }}</td></tr>
                        <tr><td class="font-semibold">Salario Base:</td><td>{{ number_format($salarioBase, 0, ',', '.') }} Gs</td></tr>
                        <tr>
                            <td class="font-semibold">Antigüedad:</td>
                            <td>
                                @if($antiguedad)
                                    {{ $antiguedad->y }} año(s), {{ $antiguedad->m }} mes(es)
                                @else
                                    No disponible
                                @endif
                            </td>
                        </tr>
                    </tbody>
</table>
            </div>
        </div>
    </div>
    <h2 class="text-xl font-bold mt-6 mb-2 text-gray-800 dark:text-gray-200">📚 Historial de Cargos</h2>

    <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-left dark:text-gray-200">Cargo</th>
                <th class="border px-4 py-2 text-left dark:text-gray-200">Fecha Inicio</th>
                <th class="border px-4 py-2 text-left dark:text-gray-200">Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historial as $registro)
                <tr>
                    <td class="border px-4 py-2 dark:text-gray-100">{{ $registro->cargo->nombre }}</td>
                    <td class="border px-4 py-2 dark:text-gray-100">
                        {{ \Carbon\Carbon::parse($registro->fecha_inicio)->format('Y/m/d') }}
                    </td>
                    <td class="border px-4 py-2 dark:text-gray-100">
                        {{ $registro->fecha_fin ? \Carbon\Carbon::parse($registro->fecha_fin)->format('Y/m/d') : 'Actual' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
