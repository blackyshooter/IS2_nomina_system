@extends('layouts.app')

@section('content')

<div class="container col-md-6">
    <h2 class="mb-4">Registro de Usuario</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="form-group mb-3">
            <label for="cedula">Cédula de Identidad</label>
            <input type="number" name="cedula" class="form-control" required value="{{ old('cedula') }}">
        </div>

        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
        </div>

        <div class="form-group mb-3">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" class="form-control" required value="{{ old('apellido') }}">
        </div>

        <div class="form-group mb-3">
            <label for="contraseña">Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Registrarse</button>
        <a href="{{ route('login') }}" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión</a>
    </form>
</div>
@endsection


