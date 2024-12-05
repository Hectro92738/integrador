<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\In_persona;

class PersonasController extends Controller
{
    // Formulario para crear una nueva persona
    public function create()
    {
        return view('encargado.persona_create');
    }

    public function store(Request $request)
    {
        // Validar los campos de la persona
        $request->validate([
            'tipo_persona' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:50',
            'num_documento' => 'required|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        // Comprobar si el número de documento ya existe
        $existingPersonaByDoc = In_persona::where('num_documento', $request->num_documento)->first();
        if ($existingPersonaByDoc) {
            return redirect()->back()->with('error', 'El número de documento ya está registrado.');
        }

        // Comprobar si el correo electrónico ya existe
        $existingPersonaByEmail = In_persona::where('email', $request->email)->first();
        if ($existingPersonaByEmail) {
            return redirect()->back()->with('error', 'El correo electrónico ya está registrado.');
        }
        
        // Comprobar si el teléfono ya existe
        if (!empty($request->telefono)) {
            $existingPersonaByTelefono = In_persona::where('telefono', $request->telefono)->first();
            if ($existingPersonaByTelefono) {
                return redirect()->back()->with('error', 'El número de teléfono ya está registrado.');
            }
        }

        // Si no hay duplicados, crear la nueva persona
        In_persona::create($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('viewpersonas')->with('success', 'Persona actualizada con éxito.');
    }

    // Formulario para editar una persona
    public function edit($id)
    {
        $persona = In_persona::findOrFail($id);

        return view('encargado.persona_editar', compact('persona'));
    }

    // Actualizar los datos de una persona
    public function update(Request $request, $id)
    {
        // dd($id);
        // Validar los campos de la persona
        $request->validate([
            'tipo_persona' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:50',
            'num_documento' => 'required|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        // Comprobar si el número de teléfono ya existe (excluyendo el actual registro)
        $existingPersonaByPhone = In_persona::where('telefono', $request->telefono)
            ->where('idpersona', '!=', $id)
            ->first();

        if ($existingPersonaByPhone) {
            return redirect()->back()->with('error', 'El número de teléfono ya está registrado.');
        }

        // Comprobar si el correo electrónico ya existe (excluyendo el actual registro)
        $existingPersonaByEmail = In_persona::where('email', $request->email)
            ->where('idpersona', '!=', $id)
            ->first();
        if ($existingPersonaByEmail) {
            return redirect()->back()->with('error', 'El correo electrónico ya está registrado.');
        }

        // Buscar la persona a actualizar
        $persona = In_persona::findOrFail($id);

        // Actualizar los datos de la persona
        $persona->update($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('viewpersonas')->with('success', 'Persona actualizada con éxito.');
    }

    // Eliminar una persona
    public function destroy($id)
    {
        try {
            $persona = In_persona::findOrFail($id);
            $persona->delete();

            return redirect()->back()->with('success', 'Persona eliminada con éxito.');
        } catch (\Exception $e) {
            // Verifica si el error es una violación de clave foránea (codigo de error 23000)
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'No se puede eliminar esta persona porque tiene registros asociados.');
            }

            // Lanza la excepción si no es una violación de clave foránea
            return redirect()->back()->with('error', 'Hubo un problema al intentar eliminar la persona.');
        }
    }
}
