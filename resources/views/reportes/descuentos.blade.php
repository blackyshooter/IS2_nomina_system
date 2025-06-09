<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Descuentos</title>
</head>
<body>
    <h1>Reporte de Descuentos por Concepto</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Concepto</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($descuentos as $descuento)
                <tr>
                    <td>{{ $descuento->empleado->nombre }} {{ $descuento->empleado->apellido }}</td>
                    <td>{{ $descuento->concepto->descripcion }}</td>
                    <td>${{ $descuento->monto }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
