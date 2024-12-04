@extends('layouts.header')
@section('title', 'Inicio')
@section('Js')
    {{-- <script src="{{ asset('js/login.js') }}"></script> --}}
@endsection
@section('content')

    <div class="container mt-2">
        <h2>Hacer Venta</h2>

        <form action="{{ route('insertVenta') }}" method="POST">
            @csrf
            <div class="row mt-3">
                <!-- Cliente -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="idcliente">Cliente</label>
                        <select name="idcliente" id="idcliente" class="form-control input_all" required>
                            <option value="">Seleccionar Cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->idpersona }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Usuario -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="idusuario">Vendedor</label>
                        <input type="text" name="idusuario" id="idusuario" value="{{ Auth::user()->nombre }}"
                            class="form-control input_all" disabled>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <!-- Tipo de Comprobante -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_comprobante">Tipo de Comprobante</label>
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control input_all" required>
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                            <option value="Recibo">Recibo</option>
                        </select>
                    </div>
                </div>
                <!-- Estado -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control input_all" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Seleccionar productos con checkboxes -->
            <div class="row mt-3">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="articulos">Seleccionar Productos</label><br>
                            <!-- Campo de búsqueda -->
                            <div class="row">
                                <div class="col-md">
                                    <input type="text" id="productSearch" class="form-control input_all"
                                        placeholder="Buscar productos..." onkeyup="filterProducts()">
                                </div>
                                <div class="col-md">
                                    <i class="bi bi-search"></i>
                                </div>
                            </div>
                        </div>
                        <div style="max-width: 900px; overflow-y: auto; max-height: 400px;" class="mt-2">
                            @foreach ($articulos as $articulo)
                                <div class="form-check producto-item mt-5">
                                    <input class="form-check-input" type="checkbox" name="articulos[]"
                                        value="{{ $articulo->idarticulo }}" id="articulo_{{ $articulo->idarticulo }}"
                                        onclick="updateTable()">
                                    <label class="form-check-label" for="articulo_{{ $articulo->idarticulo }}">
                                        {{ $articulo->nombre }} - ${{ number_format($articulo->precio_venta, 2) }}
                                    </label>

                                    <!-- Campo de cantidad como select -->
                                    <div class="mt-2">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="cantidad_{{ $articulo->idarticulo }}"
                                                    class="mt-3">Cantidad</label>
                                            </div>
                                            <div class="col-md">
                                                <select name="cantidad[{{ $articulo->idarticulo }}]"
                                                    id="cantidad_{{ $articulo->idarticulo }}"
                                                    class="form-control input_all cantidad" style="width: 50px"
                                                    onchange="updateTable()">
                                                    @for ($i = 1; $i <= $articulo->stock; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $i == 1 ? 'selected' : '' }}>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted mt-2">Selecciona uno o más productos.</small>
                    </div>

                    <!-- Columna para mostrar los productos seleccionados y calcular el total -->
                    <div class="col-md-6">
                        <h4>Productos Seleccionados</h4>
                        <table id="selectedProductsTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Productos seleccionados se mostrarán aquí -->
                            </tbody>
                        </table>
                        <h5>Subtotal: <span id="totalPrice">$0.00</span></h5>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <!-- Impuesto -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="impuesto">Impuesto (%)</label>
                        <input type="number" name="impuesto" id="impuesto" class="form-control input_all" required
                            disabled step="0.01" min="0" readonly>
                        <input type="hidden" name="impuesto" id="hidden_impuesto" value="">
                    </div>
                </div>
                <!-- Total -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" class="form-control input_all" required
                            disabled step="0.01" min="0" readonly>
                        <input type="hidden" name="total" id="hidden_total" value="">
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary mt-4">Registrar Venta</button>
        </form>

    </div>

    <script>
        // Función para actualizar la tabla de productos seleccionados
        function updateTable() {
            var table = document.getElementById("selectedProductsTable").getElementsByTagName('tbody')[0];
            var total = 0;

            // Limpiar la tabla antes de agregar nuevos datos
            table.innerHTML = "";

            // Obtener todos los productos seleccionados
            var checkboxes = document.querySelectorAll("input[name='articulos[]']:checked");

            checkboxes.forEach(function(checkbox) {
                var productId = checkbox.value;
                var productLabel = checkbox.nextElementSibling.innerText.split(" - ");
                var productName = productLabel[0];
                var productPrice = parseFloat(productLabel[1].replace('$', '').replace(',', ''));

                // Obtener la cantidad seleccionada
                var quantitySelect = document.getElementById("cantidad_" + productId);
                var quantity = parseInt(quantitySelect.value);

                // Calcular el total por producto
                var productTotal = productPrice * quantity;
                total += productTotal;

                // Crear una nueva fila en la tabla
                var row = table.insertRow();

                // Insertar celdas en la fila
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                // Rellenar las celdas con los datos del producto
                cell1.innerHTML = productName;
                cell2.innerHTML = quantity;
                cell3.innerHTML = "$" + productPrice.toFixed(2);
                cell4.innerHTML = "$" + productTotal.toFixed(2);
            });

            // Obtener el impuesto desde el input
            var impuesto = 16;
            var iva = total * impuesto / 100;
            var totalConImpuesto = total + iva;

            // Mostrar el total en el campo correspondiente
            document.getElementById("totalPrice").innerText = "$" + total.toFixed(2);

            document.getElementById("total").value = totalConImpuesto.toFixed(2);
            document.getElementById("impuesto").value = iva.toFixed(2);

            document.getElementById('hidden_impuesto').value = document.getElementById('impuesto').value;
            document.getElementById('hidden_total').value = document.getElementById('total').value;

        }


        // Función para filtrar productos en la búsqueda
        function filterProducts() {
            var input = document.getElementById('productSearch');
            var filter = input.value.toLowerCase();
            var items = document.getElementsByClassName('producto-item');

            for (var i = 0; i < items.length; i++) {
                var label = items[i].getElementsByTagName('label')[0];
                if (label.innerHTML.toLowerCase().indexOf(filter) > -1) {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }
    </script>



@endsection
