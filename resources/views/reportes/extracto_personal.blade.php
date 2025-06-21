<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Extracto Personal</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; padding: 20px; background-color: #f9f9f9; }
        h2, h3 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background-color: #fff; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .total { font-weight: bold; }
        .volver {
            position: absolute;
            top: 20px;
            left: 20px;
            margin-top: 0;
        }

        .acciones {
            position: absolute;
            top: 20px;
            right: 20px;
            margin-top: 0;
        }
        .acciones button, .acciones a, .volver a {
            padding: 8px 16px;
            margin: 5px;
            border: none;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form { text-align: center; margin-bottom: 20px; }
        select { padding: 6px; margin: 0 10px; }
        .mensaje-error { color: red; font-weight: bold; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="volver">
        <a href="{{ route('dashboard') }}">← Volver</a>
    </div>

    <div class="acciones">
        <a href="{{ route('reporte.extracto.imprimir', ['mes' => $mesSeleccionado, 'anio' => $anioSeleccionado]) }}" target="_blank">
            Imprimir en PDF
        </a>
    </div>

    <h2>Extracto de Liquidación</h2>

    {{-- Formulario para seleccionar mes y año --}}
    <form action="{{ route('reporte.extracto') }}" method="GET">
        <label for="mes">Mes:</label>
        <select name="mes" id="mes" required>
            <option value="">-- Seleccionar --</option>
            @foreach([
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
                7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
            ] as $numero => $nombre)
                <option value="{{ sprintf('%02d', $numero) }}" {{ $mesSeleccionado == $numero ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>

        <label for="anio">Año:</label>
        <select name="anio" id="anio" required>
            <option value="">-- Seleccionar --</option>
            @for ($y = now()->year; $y >= 2020; $y--)
                <option value="{{ $y }}" {{ $anioSeleccionado == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <button type="submit">Generar</button>
    </form>

    {{-- Solo mostrar si se envió el formulario --}}
    @if (request()->has('mes') && request()->has('anio'))
        @if (isset($liquidacion))
            <h3>{{ \Carbon\Carbon::createFromDate(null, $mesSeleccionado, 1)->translatedFormat('F') }} / {{ $anioSeleccionado }}</h3>
            <h3>{{ $empleado->nombre }} {{ $empleado->apellido }}</h3>

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

            <div class="acciones">
                <a href="{{ route('reporte.extracto.imprimir', ['mes' => $mesSeleccionado, 'anio' => $anioSeleccionado]) }}" target="_blank">
                    Imprimir en PDF
                </a>
            </div>
        @else
            <p class="mensaje-error">⚠ No se encontró ninguna liquidación para el mes seleccionado.</p>
        @endif
    @endif
</body>
</html>
