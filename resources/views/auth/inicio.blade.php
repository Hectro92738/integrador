@extends('layouts.header')
@section('title', 'Inicio')
@section('Js')
    {{-- <script src="{{ asset('js/login.js') }}"></script> --}}
@endsection
@section('content')
    <div class="container mt-3">
        <div class="grid">
            <div class="row">
                <div class="col-md">
                    <h1>Artículos en existencia</h1>
                </div>
                <div class="col-md text-end mt-2">
                    @if (Auth::check())
                        @if (Auth::user()->rol->role == 'encargado' || Auth::user()->rol->role == 'admin')
                            <a href="{{ route('articulos.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i>
                                Agregar nuevo artículo
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    @if (Auth::user()->rol->role == 'encargado' || Auth::user()->rol->role == 'admin')
                        <th>Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $articulo)
                    <tr>
                        <td>00{{ $articulo->idarticulo }}</td>
                        <td>{{ $articulo->nombre }}</td>
                        <td>{{ $articulo->codigo }}</td>
                        <td>${{ $articulo->precio_venta }}</td>
                        <td class="{{ $articulo->stock == 0 ? 'bg-danger' : 'bg-success' }} text-white">
                            {{ $articulo->stock }}
                        </td>
                        <td>{{ $articulo->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td class="{{ $articulo->estado == 1 ? 'bg-success' : 'bg-danger' }} text-white">
                            {{ $articulo->estado == 1 ? 'Activo' : 'Inactivo' }}
                        </td>
                        @if (Auth::user()->rol->role == 'encargado' || Auth::user()->rol->role == 'admin')
                            <td>
                                <a href="{{ url('/status-articulo/' . $articulo->idarticulo) }}" class="btn ms-3">
                                    <i class="bi {{ $articulo->estado == 1 ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('articulos.edit', $articulo->idarticulo) }}" class="btn btn-success">
                                    Editar
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection