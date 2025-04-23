@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Empleados</h2>

    <a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">Nuevo Empleado</a>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cargo</th>
                <th>Sueldo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td>{{ $empleado->cedula }}</td>
                <td>{{ $empleado->persona->nombre }}</td>
                <td>{{ $empleado->persona->apellido }}</td>
                <td>{{ $empleado->cargo }}</td>
                <td>{{ $empleado->sueldo_base }}</td>
                <td>
                    <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Deseas eliminar este empleado?')" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @if($empleado->usuario) {{-- Asegurate de tener relación con Usuario --}}
                <a href="{{ route('empleados.asignarRolForm', $empleado->id_empleado) }}" class="btn btn-sm btn-warning">Asignar Rol</a>
            @else
                <span class="text-muted">Sin usuario</span>
            @endif

            @endforeach
        </tbody>
    </table>
</div>
@endsection
