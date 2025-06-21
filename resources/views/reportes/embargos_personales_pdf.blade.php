<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Embargos Personales</title>
    <style> body { font-family: sans-serif; } </style>
</head>
<body>
    <h2>Embargos Judiciales - {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
    <table border="1" cellspacing="0" cellpadding="4" width="100%">
        <thead>
            <tr>
                <th>Monto Total</th>
                <th>Cuota Mensual</th>
                <th>Monto Restante</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($embargos as $e)
                <tr>
                    <td>{{ number_format($e->monto_total, 0, ',', '.') }} Gs</td>
                    <td>{{ number_format($e->cuota_mensual, 0, ',', '.') }} Gs</td>
                    <td>{{ number_format($e->monto_restante, 0, ',', '.') }} Gs</td>
                    <td>{{ $e->activo ? 'Activo' : 'Finalizado' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
