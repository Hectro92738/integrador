@extends('layouts.header')
@section('title', 'Ingresos')
@section('content')
    <div class="container mt-3">
        <h1>Lista de Ingresos</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Comprobante</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $ingreso)
                    <tr>
                        <td>{{ $ingreso->idingreso }}</td>
                        <td>{{ $ingreso->persona->nombre }}</td>
                        <td>{{ $ingreso->usuario->nombre }}</td>
                        <td>{{ $ingreso->fecha }}</td>
                        <td>{{ $ingreso->tipo_comprobante }} - {{ $ingreso->serie_comprobante }}{{ $ingreso->num_comprobante }}</td>
                        <td>${{ number_format($ingreso->total, 2) }}</td>
                        <td>{{ $ingreso->estado }}</td>
                        <td>
                            <ul>
                                @foreach ($ingreso->detalleingresos as $detalle)
                                    <li>
                                        Artículo: {{ $detalle->articulo->nombre }} <br>
                                        Cantidad: {{ $detalle->cantidad }} <br>
                                        Precio: ${{ number_format($detalle->precio, 2) }} <br>
                                        Categoría: {{ $detalle->articulo->categoria->nombre }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
