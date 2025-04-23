@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Asignar rol a <strong>{{ $empleado->nombre ?? 'Empleado' }}</strong></h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('empleados.asignarRolStore', $empleado->id_empleado) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="rol_id" class="form-label">Rol</label>
            <select name="rol_id" id="rol_id" class="form-select @error('rol_id') is-invalid @enderror" required>
                <option value="">-- Seleccione un rol --</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->Nombre_rol ?? $rol->name }}</option>
                @endforeach
            </select>
            @error('rol_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
