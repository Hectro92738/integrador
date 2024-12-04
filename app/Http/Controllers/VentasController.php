<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\In_articulo;
use App\Models\In_venta;
use App\Models\In_detalleventa;

class VentasController extends Controller
{

    public function insertVenta(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idcliente' => 'required',
            'tipo_comprobante' => 'required',
            'estado' => 'required',
            'articulos' => 'required|array',
            'cantidad' => 'required|array',
            'total' => 'required',
            'impuesto' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Parametros son requeridos');
        }

        $articulos = $request->articulos;
        $cantidades = $request->cantidad;

        $productosSeleccionados = [];

        foreach ($articulos as $articuloId) {
            // Verifica si el artículo tiene una cantidad asociada
            if (isset($cantidades[$articuloId])) {
                $productosSeleccionados[$articuloId] = $cantidades[$articuloId];
            }
        }

        DB::beginTransaction();

        try {
            // Crear la venta en la tabla 'venta'
            $venta = new In_venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = Auth::user()->idusuario;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->num_comprobante = 'HR565';
            $venta->fecha_hora = now();
            $venta->impuesto = $request->impuesto;
            $venta->total = $request->total;
            $venta->estado = $request->estado;

            // Guardar la venta
            $venta->save();

            // Verificar que haya suficiente stock antes de insertar los productos
            foreach ($productosSeleccionados as $articuloId => $cantidad) {
                // Obtener el artículo y su stock disponible
                $articulo = In_articulo::find($articuloId);

                if ($articulo) {
                    if ($articulo->stock < $cantidad) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'No hay suficiente stock para el producto: ' . $articulo->nombre);
                    }
                }

                if ($articulo) {
                    if ($articulo->estado !=  1) {
                        DB::rollBack();
                        return redirect()->back()->with('error', $articulo->nombre . ' ha sido dado de baja');
                    }
                }
            }

            // Insertar los productos en la tabla de detalle de venta (detalle_venta)
            foreach ($productosSeleccionados as $articuloId => $cantidad) {
                // Obtener el artículo y su precio
                $articulo = In_articulo::find($articuloId);

                if ($articulo) {
                    // Insertar detalle de venta
                    $detalleVenta = new In_detalleventa();
                    $detalleVenta->idventa = $venta->idventa;
                    $detalleVenta->idarticulo = $articuloId;
                    $detalleVenta->cantidad = $cantidad;
                    $detalleVenta->precio = $articulo->precio_venta;
                    $detalleVenta->descuento = 0;
                    $detalleVenta->save();

                    // Descontar la cantidad del stock del artículo
                    $articulo->stock -= $cantidad;
                    $articulo->save();
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Venta registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un error al registrar la venta. Intenta nuevamente ' . $e);
        }
    }

    public function detalleVenta($id)
    {

        $detalles = In_detalleventa::with('articulo')->where('idventa', $id)->get();

        return view('auth.detalleventa', compact('detalles'));
    }

    public function statusArticulo($id)
    {
        $articulo = In_articulo::findOrFail($id);

        $articulo->estado = $articulo->estado == 1 ? 0 : 1;

        $articulo->save();

        return redirect()->back()->with('success', 'Estado del artículo actualizado');
    }
}
