@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <h2 class="mb-4">Iniciar Sesión</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="form-group mb-3">
            <label for="contraseña">Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Acceder</button>

        <a href="{{ route('register') }}" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
    </form>
</div>
@endsection
