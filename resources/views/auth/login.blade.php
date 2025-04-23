@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <h2 class="mb-4">Iniciar Sesión</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="text" name="login" placeholder="Correo o ID de usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
</form>

</div>
@endsection
