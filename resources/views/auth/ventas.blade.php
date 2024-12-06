@extends('layouts.header')
@section('title', 'Historial de Ventas')
@section('Js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
                        <td>{{ $venta->persona ? $venta->persona->nombre : 'Sin información' }}</td>
                        <td>
                            <a href="{{ url('/detalle-venta/' . $venta->idventa) }}" class="btn btn-primary btn-sm">
                                Ver Detalle</a>
                            <button class="btn btn-secondary btn-sm" id="descargarTicket"
                                data-id="{{ $venta->idventa }}">
                                Descargar Ticket
                            </button>
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '#descargarTicket', function() {
                var ventaId = $(this).data('id');
                $.ajax({
                    url: '{{ route('venta.ticket', ':id') }}'.replace(':id', ventaId),
                    type: 'GET',
                    success: function(response) {
                        if (response.status == 'success') {
                            creacionPDF(response);
                        } else {
                            alert('Hubo un error al generar el ticket.');
                        }
                    },
                    error: function() {
                        alert('Ocurrió un error al realizar la solicitud.');
                    }
                });
            });
        });

        function creacionPDF(response) {
            var venta = response.venta;

            // Crear una nueva instancia de jsPDF
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Establecer márgenes (izquierda, arriba, derecha, abajo)
            const margin = 10;
            const pageWidth = doc.internal.pageSize.width;
            const pageHeight = doc.internal.pageSize.height;

            // Establecer tamaño de fuente consistente
            const fontSize = 10; // Tamaño de fuente para todo el documento
            doc.setFont("helvetica", "normal");
            doc.setFontSize(fontSize); // Se aplica el tamaño de fuente a todo el documento

            // Cargar la imagen del logo desde la carpeta public de Laravel
            var logo = new Image();
            logo.src = "{{ asset('/img/ico.png') }}"; // Ruta relativa a la carpeta public

            logo.onload = function() {
                // Agregar logo al PDF (ajustar tamaño y posición)
                var logoWidth = 20; // Ancho del logo
                var logoHeight = 20; // Alto del logo
                doc.addImage(logo, 'PNG', margin, 10, logoWidth,
                logoHeight); // Se coloca el logo en la parte superior izquierda

                // Agregar contenido al PDF
                doc.text("Ticket de Venta", (pageWidth / 2), 20, null, null, "center");
                doc.text("Venta No: " + venta.idventa, (pageWidth / 2), 30, null, null, "center");
                doc.text("Fecha: " + venta.fecha_hora, (pageWidth / 2), 40, null, null, "center");
                doc.text("Cliente: " + (venta.persona ? venta.persona.nombre : 'Sin Información'), (pageWidth / 2), 50,
                    null, null, "center");
                doc.text("Vendedor: " + (venta.usuario ? venta.usuario.nombre : 'Sin Información'), (pageWidth / 2), 60,
                    null, null, "center");
                doc.text("Estado: " + venta.estado, (pageWidth / 2), 70, null, null, "center");

                // Detalles de los artículos en una tabla
                var yOffset = 90;
                var tableStartY = yOffset;
                var tableWidth = pageWidth - 2 * margin; // Ancho de la tabla
                var cellHeight = 10;
                var columnWidths = [tableWidth * 0.3, tableWidth * 0.3, tableWidth *
                0.3]; // Ajustar proporciones de las columnas

                // Dibujar encabezado de la tabla
                doc.text("Articulo", margin, tableStartY);
                doc.text("Cantidad", margin + columnWidths[0], tableStartY);
                doc.text("Precio", margin + columnWidths[0] + columnWidths[1], tableStartY);
                doc.text("Total", margin + columnWidths[0] + columnWidths[1] + columnWidths[2], tableStartY);

                // Dibujar líneas para el encabezado
                doc.line(margin, tableStartY + 2, pageWidth - margin, tableStartY + 2);

                yOffset += cellHeight;

                var subtotal = 0;

                // Agregar filas de la tabla
                venta.detalleventa.forEach(function(detalle) {
                    var articulo = detalle.articulo ? detalle.articulo.nombre : 'Desconocido';
                    var cantidad = detalle.cantidad;
                    var precio = parseFloat(detalle.precio);

                    var totalPorFila = cantidad * precio; // Calcula el total de cada fila
                    subtotal += totalPorFila;

                    // Escribir los valores de la fila
                    doc.text(articulo, margin, yOffset);
                    doc.text(cantidad.toString(), margin + columnWidths[0], yOffset, null, null, "right");
                    doc.text("$" + precio.toFixed(2), margin + columnWidths[0] + columnWidths[1], yOffset, null,
                        null, "right");
                    doc.text("$" + totalPorFila.toFixed(2), margin + columnWidths[0] + columnWidths[1] +
                        columnWidths[2], yOffset, null, null, "right");

                    // Línea de separación de la fila
                    doc.line(margin, yOffset + 2, pageWidth - margin, yOffset + 2);

                    yOffset += cellHeight;
                });

                // Calcular impuesto (IVA 16%) y total
                var impuesto = subtotal * 0.16;
                var total = subtotal + impuesto;

                // Agregar filas para subtotal, impuesto y total
                doc.text("Subtotal", margin, yOffset);
                doc.text("$" + subtotal.toFixed(2), margin + columnWidths[0] + columnWidths[1] + columnWidths[2],
                    yOffset, null, null, "right");
                yOffset += cellHeight;

                doc.text("Impuesto (IVA 16%)", margin, yOffset);
                doc.text("$" + impuesto.toFixed(2), margin + columnWidths[0] + columnWidths[1] + columnWidths[2],
                    yOffset, null, null, "right");
                yOffset += cellHeight;

                doc.text("Total", margin, yOffset);
                doc.text("$" + total.toFixed(2), margin + columnWidths[0] + columnWidths[1] + columnWidths[2], yOffset,
                    null, null, "right");

                // Asegurarse que el contenido se mantenga dentro del margen
                if (yOffset > pageHeight - margin) {
                    doc.addPage();
                    yOffset = margin;
                }

                // Descargar el PDF
                doc.save('ticket_venta_' + venta.idventa + '.pdf');
            };
        }
    </script>


@endsection