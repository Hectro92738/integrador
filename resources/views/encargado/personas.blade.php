@extends('layouts.header')
@section('title', 'Personas')
@section('Js')
@endsection
@section('content')
    <div class="container mt-3">
        <div class="grid">
            <div class="row">
                <div class="col-md">
                    <h1>Lista de Personas</h1>
                </div>
                <div class="col-md text-end mt-2">
                    <a href="{{ route('personas.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        Agregar nueva persona
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo de Persona</th>
                            <th>Tipo de Documento</th>
                            <th>Número de Documento</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personas as $persona)
                            <tr>
                                <td>{{ $persona->idpersona }}</td>
                                <td>{{ $persona->nombre }}</td>
                                <td>{{ $persona->tipo_persona }}</td>
                                <td>{{ $persona->tipo_documento }}</td>
                                <td>{{ $persona->num_documento }}</td>
                                <td>{{ $persona->direccion }}</td>
                                <td>{{ $persona->telefono }}</td>
                                <td>{{ $persona->email }}</td>
                                <td>
                                    <div class="gid">
                                        <div class="row">
                                            <div class="col-md-5 ms-1">
                                                <a href="{{ route('personas.edit', $persona->idpersona) }}"
                                                    class="btn btn-success" style="font-size: 12px">
                                                    Editar
                                                </a>
                                            </div>
                                            <div class="col-md-5 ms-1">
                                                <form action="{{ route('personas.destroy', $persona->idpersona) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" style="font-size: 12px"
                                                        onclick="return confirm('¿Estás seguro de eliminar a esta persona?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
