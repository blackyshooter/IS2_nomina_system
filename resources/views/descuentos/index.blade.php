@extends('layouts.app')

@section('content')
<h1>Administración de Descuentos</h1>

<table border="1">
    <thead>
        <tr>
            <th>Empleado</th>
            <th>Concepto</th>
            <th>Monto Mensual</th>
            <th>Monto Total</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($descuentos as $descuento)
        <tr>
            <td>{{ $descuento->empleado->nombre }} {{ $descuento->empleado->apellido }}</td>
            <td>{{ $descuento->concepto->descripcion }}</td>
            <td>${{ $descuento->monto_mensual }}</td>
            <td>${{ $descuento->monto_total }}</td>
            <td>{{ $descuento->fecha_inicio }}</td>
            <td>{{ $descuento->fecha_fin }}</td>
            <td>
                <a href="{{ route('descuentos.edit', $descuento->id) }}">Editar</a>
                <form action="{{ route('descuentos.destroy', $descuento->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection