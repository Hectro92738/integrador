<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\In_usuario;

class AuthController extends Controller
{
    public function validarLogin(Request $request)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'username' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Parametros son requeridos');
            }

            $user = In_usuario::where('email', $request->username)->first();


            if (!$user) {
                return redirect()->back()->with('error', 'Correo incorrecto');
            }

            if (Hash::check($request->password, $user->password)) {
                
                // Autenticar al usuario
                Auth::login($user);

                return redirect()->route('inicio');

            } else {
                return redirect()->back()->with('error', 'Contraseña incorrecta');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Ocurrió un error inesperado. Intenta nuevamente.');
        }
    }
}
