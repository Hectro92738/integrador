<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\In_articulo;
use App\Models\In_venta;
use App\Models\In_usuario;

class GestionController extends Controller
{
    public function obtenerVentas()
    {
        $ventas = In_venta::with(['persona', 'usuario', 'detalleventa'])->get();

        return response()->json($ventas);
    }

    public function ventasPorUsuario()
    {
        // Obtener ventas agrupadas por usuario con totales
        $usuariosVentas = In_usuario::with('venta')
            ->get()
            ->map(function ($usuario) {
                return [
                    'usuario' => $usuario->nombre,
                    'total_ventas' => $usuario->venta->sum('total')
                ];
            });

        return response()->json($usuariosVentas);
    }

    public function articulosMasVendidos()
{
    // Obtenemos los artículos más vendidos sumando la cantidad en detalle_venta
    $articulos = In_articulo::with('detalleventa')
        ->get()
        ->map(function ($articulo) {
            return [
                'articulo' => $articulo->nombre,
                'cantidad_vendida' => $articulo->detalleventa->sum('cantidad')
            ];
        })
        ->sortByDesc('cantidad_vendida') // Ordenamos por cantidad vendida
        ->take(10); // Tomamos los 10 más vendidos

    return response()->json($articulos);
}

}
