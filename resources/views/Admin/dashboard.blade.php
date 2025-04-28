<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Agrega aquí tus enlaces a CSS o frameworks como Bootstrap -->
</head>
<body>
    <div class="container">
        <h1>Bienvenido al Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                <li><a href="{{ route('roles.index') }}">Roles</a></li>
                <li><a href="{{ route('asignar_roles.index') }}">Asignar Roles</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
