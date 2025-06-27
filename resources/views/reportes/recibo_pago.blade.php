<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        .credito { color: green; }
        .debito { color: red; }
    </style>
</head>
<body>
    <h2>Recibo de Pago - {{ $empleado->nombre }} {{ $empleado->apellido }} ({{ ucfirst($periodoFormateado) }})</h2>
    <p><strong>Cargo:</strong> {{ $empleado->cargo ?? 'N/D' }}</p>
    <p><strong>Salario Base:</strong> {{ number_format($empleado->salario_base, 0, ',', '.') }} Gs</p>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Monto (Gs)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_credito = 0;
                $total_debito = 0;
            @endphp
            @foreach($detalles as $detalle)
                @php
                    $tipo = $detalle->concepto->tipo_concepto;
                    if ($tipo === 'credito') $total_credito += $detalle->monto;
                    else $total_debito += $detalle->monto;
                @endphp
                <tr>
                    <td>{{ $detalle->concepto->descripcion }}</td>
                    <td class="{{ $tipo }}">{{ ucfirst($tipo) }}</td>
                    <td>{{ number_format($detalle->monto, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="2"><strong>Total Créditos</strong></td><td>{{ number_format($total_credito, 0, ',', '.') }}</td></tr>
            <tr><td colspan="2"><strong>Total Débitos</strong></td><td>{{ number_format($total_debito, 0, ',', '.') }}</td></tr>
            <tr><td colspan="2"><strong>Total Neto</strong></td><td><strong>{{ number_format($total_credito - $total_debito, 0, ',', '.') }}</strong></td></tr>
        </tfoot>
    </table>
   <br><br>
        <p><strong>Fecha de emisión:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</p>

        <div style="margin-top: 60px;">
            <p>_____________________________</p>
            <p>Firma del Responsable</p>
        </div>

        <div style="position: absolute; bottom: 20px; right: 30px; font-size: 10px; color: gray;">
            <p>Generado automáticamente por el Sistema de Nómina</p>
        </div>
        <div style="position: absolute; bottom: 20px; left: 30px; font-size: 10px; color: gray;">
        <p>Recibo No. {{ $liquidacion->id_liquidacion }}</p>
</html>
