<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Empleado') }}
        </h2>
    </x-slot>

    <div class="container">
        <h2>Editar Empleado</h2>

        <form action="{{ route('empleados.update', $empleado->id_empleado) }}" method="POST">
            @csrf
            @method('PUT')

            <h4>Datos Personales</h4>
            <div class="form-group">
                <label>Cédula</label>
                <input type="text" value="{{ $empleado->cedula }}" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $empleado->persona->nombre }}" required>
            </div>

            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" class="form-control" value="{{ $empleado->persona->apellido }}" required>
            </div>

            <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $empleado->persona->fecha_nacimiento }}" required>
            </div>

            <h4>Datos Laborales</h4>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ $empleado->telefono }}" required>
            </div>

            <div class="form-group">
                <label>Sueldo Base</label>
                <input type="number" step="0.01" name="sueldo_base" class="form-control" value="{{ $empleado->sueldo_base }}" required>
            </div>

            <div class="form-group">
                <label>Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" class="form-control" value="{{ $empleado->fecha_ingreso }}" required>
            </div>

            <div class="form-group">
                <label>Cargo</label>
                <input type="text" name="cargo" class="form-control" value="{{ $empleado->cargo }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-app-layout>
