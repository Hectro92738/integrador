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
                    {{-- <th>Comprobante</th> --}}
                    <th>Total</th>
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
                        {{-- <td>{{ $ingreso->tipo_comprobante }} -
                            {{ $ingreso->serie_comprobante }}{{ $ingreso->num_comprobante }}</td> --}}
                        <td>${{ number_format($ingreso->total, 2) }}</td>
                        <td>
                            <div style="max-height: 200px; overflow-y: auto;" class="mt-2 contenedor_productos_venta">
                                @foreach ($ingreso->detalleingresos as $detalle)
                                    <div class="card mt-1">
                                        <div class="card-body">
                                            <strong>Artículo:</strong> {{ $detalle->articulo->nombre }} <br>
                                            <strong>Cantidad:</strong> {{ $detalle->cantidad }} <br>
                                            <strong>Precio:</strong> ${{ number_format($detalle->precio, 2) }} <br>
                                            <strong>Categoría:</strong> {{ $detalle->articulo->categoria->nombre }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
