<x-app-layout>
    <x-slot name="header">
        <h2>Detalle Empleado</h2>
    </x-slot>

    <div class="py-4">
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary mb-3">Volver</a>

        <table class="table table-bordered">
            <tr><th>Nombre</th><td>{{ $empleado->nombre }}</td></tr>
            <tr><th>Apellido</th><td>{{ $empleado->apellido }}</td></tr>
            <tr><th>Cédula</th><td>{{ $empleado->cedula }}</td></tr>
            <tr><th>Correo</th><td>{{ $empleado->correo }}</td></tr>
            <tr><th>Teléfono</th><td>{{ $empleado->telefono ?? '-' }}</td></tr>
            <tr><th>Fecha de Ingreso</th><td>{{ $empleado->fecha_ingreso->format('d/m/Y') }}</td></tr>
            <tr><th>Fecha de Nacimiento</th><td>{{ $empleado->fecha_nacimiento->format('d/m/Y') }}</td></tr>
        </table>
    </div>
</x-app-layout>
