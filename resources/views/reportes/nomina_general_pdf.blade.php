<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Nómina General</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="title">Reporte de Nómina General</div>

    @if($periodo)
        <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($periodo . '-01')->formatLocalized('%B %Y') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>C.I.</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cargo</th>
                <th class="text-right">Percepción</th>
                <th class="text-right">Deducción</th>
                <th class="text-right">Neto a Pagar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalHaberes = 0;
                $totalDebitos = 0;
                $totalNeto = 0;
            @endphp

            @foreach($reporteLiquidaciones as $datos)
                @php
                    $empleado = $datos['empleado'];
                    $haberes = $datos['total_haberes'] ?? 0;
                    $debitos = $datos['total_debitos'] ?? 0;
                    $neto = $datos['salario_neto'] ?? 0;
                    $totalHaberes += $haberes;
                    $totalDebitos += $debitos;
                    $totalNeto += $neto;
                @endphp
                <tr>
                    <td>{{ $empleado->cedula ?? '-' }}</td>
                    <td>{{ $empleado->nombre ?? '-' }}</td>
                    <td>{{ $empleado->apellido ?? '-' }}</td>
                    <td>{{ $empleado->cargoActual?->cargo?->nombre ?? ($empleado->cargo ?? '-') }}</td>
                    <td class="text-right">{{ number_format($haberes, 0, ',', '.') }} Gs</td>
                    <td class="text-right">{{ number_format($debitos, 0, ',', '.') }} Gs</td>
                    <td class="text-right">{{ number_format($neto, 0, ',', '.') }} Gs</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Total de empleados: {{ $reporteLiquidaciones->count() }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalHaberes, 0, ',', '.') }} Gs</strong></td>
                <td class="text-right"><strong>{{ number_format($totalDebitos, 0, ',', '.') }} Gs</strong></td>
                <td class="text-right"><strong>{{ number_format($totalNeto, 0, ',', '.') }} Gs</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
