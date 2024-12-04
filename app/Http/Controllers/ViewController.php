<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\In_articulo;
use App\Models\In_persona;
use App\Models\In_venta;
use App\Models\In_detalleventa;

class ViewController extends Controller
{
    public function inicio()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Sesión inválida');
        }

        $articulos = In_articulo::with('categoria')->get();

        return view('auth.inicio', compact('articulos'));
    }

    public function vender()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Sesión inválida');
        }

        $articulos = In_articulo::with('categoria')
            ->where('stock', '>', 0)
            ->where('estado', '=', 1)
            ->get();

        $clientes = In_persona::where('tipo_persona', 'Cliente')->get();

        return view('auth.vender', compact('articulos', 'clientes'));
    }

    public function ventas()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Sesión inválida');
        }

        $iduser = Auth::user()->idusuario;

        $ventas = In_venta::with('persona')->where('idusuario', $iduser)->get();

        return view('auth.ventas', compact('ventas'));
    }

    public function gestionProductos()
    {
        // Verificar si el usuario NO está autenticado
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Sesión invalida');
        }
        return view('admin.gestionproducto');
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect('/')->with('error', 'Sesión invalida');
        } else {
            return redirect('/')->with('error', 'Sesión invalida');
        }
    }
    

}

