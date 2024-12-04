@extends('layouts.header')
@section('title', 'detalle denta')
@section('Js')
    {{-- <script src="{{ asset('js/login.js') }}"></script> --}}
@endsection
@section('content')
    <div class="container mt-2">
        <h1>Detalle de Venta</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detalles as $detalle)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detalle->articulo->nombre ?? 'Artículo no disponible' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->precio, 2) }}</td>
                        <td>${{ number_format($detalle->descuento, 2) }}</td>
                        <td>${{ number_format(($detalle->precio - $detalle->descuento) * $detalle->cantidad, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay detalles para esta venta.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
