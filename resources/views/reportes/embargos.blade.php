<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Embargos Judiciales</title>
</head>
<body>
    <h1>Reporte de Empleados con Embargos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>Concepto</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                @foreach ($empleado->conceptos as $descuento)
                    @if (str_contains(strtolower($descuento->concepto->descripcion), 'embargo'))
                        <tr>
                            <td>{{ $empleado->nombre }}</td>
                            <td>{{ $empleado->apellido }}</td>
                            <td>{{ $empleado->cedula }}</td>
                            <td>{{ $descuento->concepto->descripcion }}</td>
                            <td>${{ $descuento->monto }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
