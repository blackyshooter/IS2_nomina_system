@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Nuevo Empleado</h2>

    <form action="{{ route('empleados.store') }}" method="POST">
        @csrf

        <h4>Datos Personales</h4>
        <div class="form-group">
            <label>Cédula</label>
            <input type="number" name="cedula" class="form-control" value="{{ old('cedula') }}" required>
        </div>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
        </div>

        <div class="form-group">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
        </div>

        <h4>Datos Laborales</h4>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
        </div>

        <div class="form-group">
            <label>Sueldo Base</label>
            <input type="number" step="0.01" name="sueldo_base" class="form-control" value="{{ old('sueldo_base') }}" required>
        </div>

        <div class="form-group">
            <label>Fecha de Ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso') }}" required>
        </div>

        <div class="form-group">
            <label>Cargo</label>
            <input type="text" name="cargo" class="form-control" value="{{ old('cargo') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
