@extends('layouts.header')
@section('title', 'Agregar Artículo')
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
                <h1>Agregar Nuevos Artículos</h1>
            </div>
        </div>
        <hr>
        <form action="{{ route('articulos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="proveedor"><strong>Proveedor</strong></label>
                <select name="proveedor" id="proveedor" class="form-control input_all">
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->idpersona }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div id="productos-container" class="row">
                <div class="card p-3">
                    <h5>Producto 1</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre[]" class="form-label"><strong>Nombre</strong></label>
                            <input type="text" class="form-control input_all" name="nombre[]" placeholder="-----" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="codigo[]" class="form-label"><strong>Código</strong></label>
                            <input type="text" class="form-control input_all" name="codigo[]" placeholder="-----" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="precio_venta[]" class="form-label"><strong>Precio</strong></label>
                            <input type="number" class="form-control input_all" name="precio_venta[]" placeholder="-----" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock[]" class="form-label"><strong>Stock</strong></label>
                            <input type="number" class="form-control input_all" name="stock[]" placeholder="-----" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="idcategoria[]" class="form-label"><strong>Categoría</strong></label>
                            <select class="form-control input_all" name="idcategoria[]" required>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->idcategoria }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="descripcion[]" class="form-label"><strong>Descripción</strong></label>
                            <textarea class="form-control input_all" name="descripcion[]"></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <button type="button" class="btn btn-success mt-3" id="agregar-producto">Agregar Nuevo artículo</button>
            <button type="submit" class="btn btn-primary mt-3">Guardar Artículos</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productosContainer = document.getElementById('productos-container');
            const btnAgregarProducto = document.getElementById('agregar-producto');
            let contadorProductos = 1;

            btnAgregarProducto.addEventListener('click', () => {
                const confirmacion = confirm("¿Estás seguro de que quieres agregar un nuevo producto?");
                if (!confirmacion) return;

                contadorProductos++;
                const nuevoProducto = document.createElement('div');
                nuevoProducto.classList.add('card', 'p-3');
                nuevoProducto.innerHTML = `
                   <h5>Producto ${contadorProductos}</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre[]" class="form-label">Nombre</label>
                            <input type="text" class="form-control input_all" name="nombre[]" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="codigo[]" class="form-label">Código</label>
                            <input type="text" class="form-control input_all" name="codigo[]" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="precio_venta[]" class="form-label">Precio de Venta</label>
                            <input type="number" class="form-control input_all" name="precio_venta[]" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock[]" class="form-label">Stock</label>
                            <input type="number" class="form-control input_all" name="stock[]" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="idcategoria[]" class="form-label">Categoría</label>
                            <select class="form-control input_all" name="idcategoria[]" required>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->idcategoria }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="descripcion[]" class="form-label">Descripción</label>
                            <textarea class="form-control input_all" name="descripcion[]"></textarea>
                        </div>
                    </div>
                `;
                productosContainer.appendChild(nuevoProducto);
            });
        });
    </script>
@endsection
