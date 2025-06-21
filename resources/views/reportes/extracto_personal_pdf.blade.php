<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Extracto Personal PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Extracto de Liquidación - {{ $empleado->nombre }} {{ $empleado->apellido }}</h2>
    <p>Mes: {{ $mesSeleccionado }} / Año: {{ $anioSeleccionado }}</p>

    @php
        $totalCredito = 0;
        $totalDebito = 0;
    @endphp

    <h3>Conceptos de Crédito</h3>
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Monto (Gs)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($liquidacion->detalles as $detalle)
                @if ($detalle->concepto && $detalle->concepto->tipo_concepto === 'credito')
                    <tr>
                        <td>{{ $detalle->concepto->descripcion }}</td>
                        <td>{{ number_format($detalle->monto, 0, ',', '.') }}</td>
                    </tr>
                    @php $totalCredito += $detalle->monto; @endphp
                @endif
            @endforeach
        </tbody>
    </table>

    <h3>Conceptos de Débito</h3>
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Monto (Gs)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($liquidacion->detalles as $detalle)
                @if ($detalle->concepto && $detalle->concepto->tipo_concepto === 'debito')
                    <tr>
                        <td>{{ $detalle->concepto->descripcion }}</td>
                        <td>{{ number_format($detalle->monto, 0, ',', '.') }}</td>
                    </tr>
                    @php $totalDebito += $detalle->monto; @endphp
                @endif
            @endforeach
        </tbody>
    </table>

    <h3>Resumen</h3>
    <table>
        <tr>
            <td class="total">Total Crédito</td>
            <td>{{ number_format($totalCredito, 0, ',', '.') }} Gs</td>
        </tr>
        <tr>
            <td class="total">Total Débito</td>
            <td>{{ number_format($totalDebito, 0, ',', '.') }} Gs</td>
        </tr>
        <tr>
            <td class="total">Salario Neto Percibido</td>
            <td>{{ number_format($totalCredito - $totalDebito, 0, ',', '.') }} Gs</td>
        </tr>
    </table>
</body>
</html>
