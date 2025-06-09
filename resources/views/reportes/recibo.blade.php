<!DOCTYPE html>
<html>
<head>
    <title>Recibo de Pago</title>
</head>
<body>
    <h1>Recibo de Pago</h1>
    <p>Empleado: {{ $empleado->nombre }} {{ $empleado->apellido }}</p>
    <p>Cédula: {{ $empleado->cedula }}</p>
    <h3>Descuentos Aplicados:</h3>
    <ul>
        @foreach ($descuentos as $descuento)
            <li>{{ $descuento->concepto->descripcion }}: ${{ $descuento->monto }}</li>
        @endforeach
    </ul>
</body>
</html>