@extends('layouts.header')
@section('title', 'Historial de Ventas')
@section('Js')
    {{-- <script src="{{ asset('js/login.js') }}"></script> --}}
@endsection
@section('content')
    <div class="container mt-2">
        <h1>Historial de Ventas</h1>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Estado</th> 
                    <th>Cliente</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_hora)->translatedFormat('d / F / Y H:i') }}</td>
                        <td>${{ number_format($venta->impuesto, 2) }}</td>
                        <td>${{ number_format($venta->total, 2) }}</td>
                        <td>{{ $venta->estado }}</td>
                        <td>
                            <!-- Aquí mostramos el nombre del cliente desde la relación persona -->
                            {{ $venta->persona ? $venta->persona->nombre : 'Sin información' }}
                        </td>
                        <td>
                            <a href="{{ url('/detalle-venta/' . $venta->idventa) }}" class="btn btn-primary btn-sm">Ver Detalle</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay ventas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
