@extends('layouts.header')
@section('title', 'Editar Artículo')
@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md">
                <button onclick="goBack()" class="btn btn-warning mt-2">
                    <i class="bi bi-skip-backward"></i>
                    Regresar
                </button>
            </div>
            <div class="col-md-8">
                <h1>Editar Artículo</h1>
            </div>
        </div>
        <hr>
        <form action="{{ route('articulos.update', $articulo->idarticulo) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label"><strong>Nombre</strong></label>
                        <input type="text" class="form-control input_all" name="nombre" id="nombre"
                            value="{{ $articulo->nombre }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="codigo" class="form-label"><strong>Código</strong></label>
                        <input type="text" class="form-control input_all" name="codigo" id="codigo"
                            value="{{ $articulo->codigo }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="precio_venta" class="form-label"><strong>Precio de Venta</strong></label>
                        <input type="number" class="form-control input_all" name="precio_venta" id="precio_venta"
                            value="{{ $articulo->precio_venta }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="idcategoria" class="form-label"><strong>Categoría</strong></label>
                        <select class="form-control input_all" name="idcategoria" id="idcategoria" required>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->idcategoria }}"
                                    {{ $categoria->idcategoria == $articulo->idcategoria ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="descripcion" class="form-label"><strong>Descripción</strong></label>
                        <textarea class="form-control input_all" name="descripcion" id="descripcion">{{ $articulo->descripcion }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Artículo</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#stockModal">
                Ingresar stock
            </button>
        </form>
    </div>
    <!-- Modal de Bootstrap -->
    <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalLabel">Ingresar Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('stock.store', $articulo->idarticulo) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="cantidad" class="form-label"><strong>Cantidad</strong></label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
