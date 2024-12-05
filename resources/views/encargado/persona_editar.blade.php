@extends('layouts.header')
@section('title', 'Editar Persona')
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
                <h1>Editar Persona</h1>
            </div>
        </div>
        <hr>
        <form method="POST" action="{{ route('personas.update', $persona->idpersona) }}">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label"><strong>Nombre</strong></label>
                    <input type="text" name="nombre" id="nombre" class="form-control input_all"
                        value="{{ $persona->nombre }}" required>
                </div>

                <!-- Columna 1 -->
                <div class="col-md-6 mb-3">
                    <label for="tipo_persona" class="form-label"><strong>Tipo de Persona</strong></label>
                    <select name="tipo_persona" id="tipo_persona" class="form-control input_all" required>
                        <option value="Cliente" {{ $persona->tipo_persona == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="Proveedor" {{ $persona->tipo_persona == 'Proveedor' ? 'selected' : '' }}>Proveedor
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tipo_documento" class="form-label"><strong>Tipo de Documento</strong></label>
                    <input type="text" name="tipo_documento" id="tipo_documento" class="form-control input_all"
                        value="{{ $persona->tipo_documento }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="num_documento" class="form-label"><strong>Número de Documento</strong></label>
                    <input type="text" name="num_documento" id="num_documento" class="form-control input_all"
                        value="{{ $persona->num_documento }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="direccion" class="form-label"><strong>Dirección</strong></label>
                    <input type="text" name="direccion" id="direccion" class="form-control input_all"
                        value="{{ $persona->direccion }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label"><strong>Teléfono</strong></label>
                    <input type="text" name="telefono" id="telefono" class="form-control input_all"
                        value="{{ $persona->telefono }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label"><strong>Email</strong></label>
                    <input type="email" name="email" id="email" class="form-control input_all"
                        value="{{ $persona->email }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
