<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Nóminas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e6f0ff;
        }
        .navbar {
            margin-bottom: 0;
        }
        .header-title {
            background-color: #b3d9ff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">🏠 Inicio</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">

            <!-- Menú Consultas -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="consultasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    🔍 Consultas
                </a>
                <div class="dropdown-menu" aria-labelledby="consultasDropdown">
                    <a class="dropdown-item" href="#">Extracto personal</a>
                    <a class="dropdown-item" href="#">Datos personales</a>
                </div>
            </li>

            <!-- Menú RRHH -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="rrhhDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    👥 RRHH
                </a>
                <div class="dropdown-menu" aria-labelledby="rrhhDropdown">
                    <a class="dropdown-item" href="#">Registrar empleado</a>
                    <a class="dropdown-item" href="#">Listar empleado</a>
                    <a class="dropdown-item" href="#">Calcular nómina</a>
                    <a class="dropdown-item" href="#">Reportes</a>
                    <a class="dropdown-item" href="#">Configuración</a>
                </div>
            </li>
        </ul>

        <!-- Usuario y Logout -->
        <span class="navbar-text mr-3">
            {{ Auth::user()->nombre ?? 'Usuario' }}
        </span>
        <form action="{{ route('logout') }}" method="POST" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm">⏏ Salir</button>
        </form>
    </div>
</nav>

<div class="header-title">
    SISTEMA DE NÓMINAS
</div>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
