@extends('layouts.header')
@section('title', 'Gestión Productos')
@section('Js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div id="ventasChart" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
        <hr>
        <div class="grid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div id="usuariosChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div id="articulosChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // Gráfica de totales por fecha
            $.ajax({
                url: "{{ route('ventas.datos') }}",
                method: "GET",
                success: function(data) {
                    let fechas = [];
                    let totales = [];

                    data.forEach(function(venta) {
                        fechas.push(venta.fecha_hora);
                        totales.push(parseFloat(venta.total)); // Convertir a número
                    });

                    // Renderizar el gráfico
                    Highcharts.chart('ventasChart', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Total Ventas por Fecha'
                        },
                        xAxis: {
                            categories: fechas,
                            title: {
                                text: 'Fechas'
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Total Ventas'
                            },
                            allowDecimals: false
                        },
                        series: [{
                            name: 'Total Ventas',
                            data: totales,
                            color: '#36A2EB'
                        }],
                    });
                },
                error: function(error) {
                    console.error("Error al cargar los datos:", error);
                }
            });

            // Gráfica de ventas por usuario
            $.ajax({
                url: "{{ route('usuarios.ventas') }}",
                method: "GET",
                success: function(data) {
                    let usuarios = [];
                    let totales = [];

                    data.forEach(function(usuario) {
                        usuarios.push(usuario.usuario);
                        totales.push(usuario.total_ventas);
                    });

                    Highcharts.chart('usuariosChart', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Ventas por Usuario'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        accessibility: {
                            point: {
                                valueSuffix: '%'
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                }
                            }
                        },
                        series: [{
                            name: 'Usuarios',
                            colorByPoint: true,
                            data: usuarios.map((usuario, index) => ({
                                name: usuario,
                                y: totales[index]
                            }))
                        }]
                    });
                },
                error: function(error) {
                    console.error("Error al cargar los datos:", error);
                }
            });

            // Gráfica de artículos más vendidos
            $.ajax({
                url: "{{ route('articulos.vendidos') }}",
                method: "GET",
                success: function(data) {
                    let articulos = [];
                    let cantidades = [];

                    data.forEach(function(articulo) {
                        articulos.push(articulo.articulo);
                        cantidades.push(articulo.cantidad_vendida);
                    });

                    Highcharts.chart('articulosChart', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Artículos Más Vendidos'
                        },
                        xAxis: {
                            categories: articulos,
                            title: {
                                text: 'Artículos'
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Cantidad Vendida'
                            },
                            allowDecimals: false
                        },
                        series: [{
                            name: 'Cantidad Vendida',
                            data: cantidades,
                            color: '#4BC0C0'
                        }]
                    });
                },
                error: function(error) {
                    console.error("Error al cargar los datos:", error);
                }
            });

        });
    </script>
@endsection