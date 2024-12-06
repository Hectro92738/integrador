<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\In_articulo;
use App\Models\In_categoria;
use App\Models\In_persona;


use App\Models\In_ingreso;
use App\Models\In_detalleingreso;


class ArticuloController extends Controller
{
    // Mostrar el formulario para crear un artículo
    public function create()
    {
        $categorias = In_categoria::all();  // Obtener todas las categorías
        $proveedores = In_persona::where('tipo_persona', 'proveedor')->get();  // Obtener personas de tipo proveedor
        return view('encargado.articulo_create', compact('categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        try {
            // inicia una transacción
            DB::beginTransaction();

            // insertar en la tabla `ingreso`
            $ingreso = In_ingreso::create([
                'idproveedor' => $request->proveedor,
                'idusuario' => Auth::user()->idusuario,
                'tipo_comprobante' => 'Factura', 
                'serie_comprobante' => '001',   
                'num_comprobante' => now()->timestamp, 
                'fecha' => now(),
                'impuesto' => 0, 
                'total' => 0,    
                'estado' => 'Activo', 
            ]);

            $total = 0; // Variable para calcular el total del ingreso

            // ecorrer los productos para guardar en `articulo` y `detalle_ingreso`
            foreach ($request->nombre as $index => $nombre) {
                // insertar en `articulo`
                $articulo = In_articulo::create([
                    'idcategoria' => $request->idcategoria[$index],
                    'codigo' => $request->codigo[$index],
                    'nombre' => $nombre,
                    'precio_venta' => $request->precio_venta[$index],
                    'stock' => $request->stock[$index],
                    'descripcion' => $request->descripcion[$index] ?? null,
                    'estado' => 1,
                ]);

                // insertar en `detalle_ingreso`
                $detalle = In_detalleingreso::create([
                    'idingreso' => $ingreso->idingreso,
                    'idarticulo' => $articulo->idarticulo,
                    'cantidad' => $request->stock[$index],
                    'precio' => $request->precio_venta[$index],
                ]);

                // Sumar al total
                $total += $detalle->cantidad * $detalle->precio;
            }

            // actualizar el total en la tabla `ingreso`
            $ingreso->update(['total' => $total]);

            DB::commit();

            return redirect()->route('inicio')->with('success', 'Artículos y detalles de ingreso guardados exitosamente.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    // Mostrar el formulario para editar un artículo
    public function edit($id)
    {
        $articulo = In_articulo::findOrFail($id);
        $categorias = In_categoria::all();  // Obtener todas las categorías
        return view('encargado.articulo_editar', compact('articulo', 'categorias'));
    }

    // Actualizar un artículo
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:articulo,codigo,' . $id . ',idarticulo',
            'precio_venta' => 'required|numeric',
            'stock' => 'required|integer',
            'idcategoria' => 'required|exists:categoria,idcategoria',
            'descripcion' => 'nullable|string',
        ]);

        $articulo = In_articulo::findOrFail($id);
        $articulo->update([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'precio_venta' => $request->precio_venta,
            'stock' => $request->stock,
            'idcategoria' => $request->idcategoria,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,  // Actualizar el estado si se cambia
        ]);

        return redirect()->route('inicio', $id)->with('success', 'Artículo actualizado exitosamente');
    }

    public function storeStock(Request $request, $idarticulo)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        try {
            // Iniciar la transacción
            DB::beginTransaction();

            // Obtener el artículo
            $articulo = In_articulo::findOrFail($idarticulo);

            // Obtener el proveedor asociado al artículo
            $detalleIngreso = $articulo->detalleingresos()->first();
            if (!$detalleIngreso || !$detalleIngreso->ingreso || !$detalleIngreso->ingreso->persona) {
                return redirect()->back()->with('error', 'No se encontró un proveedor relacionado con este artículo.');
            }

            $proveedor = $detalleIngreso->ingreso->persona;

            // Crear el registro en la tabla `ingreso`
            $ingreso = In_ingreso::create([
                'idproveedor' => $proveedor->idpersona, // Proveedor asociado
                'idusuario' => Auth::user()->idusuario,
                'tipo_comprobante' => 'Ingreso de Stock',
                'serie_comprobante' => 'STOCK',
                'num_comprobante' => now()->timestamp,
                'fecha' => now(),
                'impuesto' => 0,
                'total' => $request->cantidad * $articulo->precio_venta,
                'estado' => 'Activo',
            ]);

            // Crear el registro en la tabla `detalle_ingreso`
            In_detalleingreso::create([
                'idingreso' => $ingreso->idingreso,
                'idarticulo' => $articulo->idarticulo,
                'cantidad' => $request->cantidad,
                'precio' => $articulo->precio_venta,
            ]);

            // Actualizar el stock del artículo
            $articulo->increment('stock', $request->cantidad);

            // Confirmar la transacción
            DB::commit();

            return redirect()->back()->with('success', 'Stock ingresado correctamente.');
        } catch (\Exception $e) {
            // Revertir en caso de error
            DB::rollBack();

            return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }
}
