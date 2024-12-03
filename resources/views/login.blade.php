@extends('layouts.header') {{-- Encabezado de todas las paguinas --}}
@section('title', 'Login') {{-- Uso de variables en cada documento en este caso en Titulo  --}}
@section('Js')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection
@section('content')
    @if (session('error'))
        <div class="col-md-3 alert  alert-dismissible fade show alert_Error" id="" role="alert">
            <button type="button" class="btn-close btn-ms" data-bs-dismiss="alert"></button>
            <p class="mt-2"><i class="bi bi-exclamation-lg"></i> {{ session('error') }}</p>
        </div>
    @endif
    {{-- @if (Auth::user()->role == 'TEACHER') --}}
    <div class="container ">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 col-lg-4">
                <div class="">
                    <div class="card-body">
                        <div class="text-center">
                            <img width="40%" height="auto" src="{{ asset('img/ico.png') }}" alt="">
                        </div>
                        <h3 class="card-title text-center" id="modal_titulo">Iniciar sesión</h3>
                        <br>
                        <div id="modal_body">
                            <form method="post" action="{{ route('validarLogin') }}" class="mt-5">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="username" class="form-control input_all"
                                        placeholder="Correo Electronico" required />
                                </div>
                                <div class="input-group mt-4">
                                    <input type="password" id="modal-password1" name="password"
                                        class="form-control input_all" placeholder="Contraseña" required />
                                    <a type="button" id="togglePassword" class="btn color_btn">
                                        <i style="font-size: 21px;" class="bi bi-eye-slash"></i>
                                    </a>
                                </div>
                                <br>
                                <div class="row mt-3">
                                    <button type="submit" class="btn btn-google ms-3 mb-3">
                                        Entrar <img width="20px" height="auto"
                                            src="{{ asset('img/icons/flechaDere.png') }}">
                                    </button>
                                    {{-- <button type="button" class="btn btn-google ms-3 mb-3" onclick="formCodigo()">
                                        Iniciar con código <img width="25px" height="auto"
                                            src="{{ asset('img/icons/key.png') }}">
                                    </button> --}}
                                    {{-- <button type="button" class="btn btn-google ms-3 mb-3"
                                        onclick="location.href='{{ url('/login-google') }}'">
                                        <img width="18%" height="auto"
                                            src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png"
                                            alt="Google Logo">
                                    </button> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection {{-- Fin del contenido del body  --}}
