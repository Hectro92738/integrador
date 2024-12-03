<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/ico.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('title')</title>
    <meta name="theme-color" content="#F0F000">
    <!-- Reemplaza #RRGGBB con el color hexadecimal que desees -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- ------------------- --}}
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>

    @yield('Js')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</head>

<body>
    <script>
        var appData = {
            urlImg1: "{{ asset('img/icons/key.png') }}",
        };
    </script>
    @if (session('error'))
        <div class="col-md-3 alert  alert-dismissible fade show alert_Error" id="" role="alert">
            <button type="button" class="btn-close btn-ms" data-bs-dismiss="alert"></button>
            <p class="mt-2"><i class="bi bi-exclamation-lg"></i> {{ session('error') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="col-md-3 alert alert-dismissible fade show alert_Success" role="alert">
            <button type="button" class="btn-close btn-ms" data-bs-dismiss="alert"></button>
            <p class="mt-2"><i class="bi bi-check-circle"></i> {{ session('success') }}</p>
        </div>
    @endif

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/ico.png') }}" alt="Logo" width="40px">
                @if (Auth::check())
                    @if (Auth::user()->rol->role == 'admin')
                        Admin
                    @elseif (Auth::user()->rol->role == 'encargado')
                        Encargado
                    @else
                        User
                    @endif
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @if (Auth::check())
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('inicio') }}"><i class="bi bi-archive"></i>
                                Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('vender') }}"><i class="bi bi-bag"></i> Vender</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('ventas') }}"><i class="bi bi-list-check"></i>
                                Ventas</a>
                        </li>
                        @if (Auth::user()->rol->role == 'encargado' || Auth::user()->rol->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-sliders"></i>
                                    Ingresos
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="{{ route('gestionProductos') }}">
                                            <i class="bi bi-box-arrow-in-down"></i> Ingresar producto</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="{{ route('gestionProductos') }}">
                                            <i class="bi bi-person-down"></i> Personas</a>
                                    </li>
                                    @if (Auth::user()->rol->role == 'admin')
                                        <li class="nav-item">
                                            <a class="dropdown-item" href="{{ route('gestionProductos') }}">
                                                <i class="bi bi-person-fill-add"></i> Ingresar usuario
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item" href="{{ route('gestionProductos') }}">
                                                <i class="bi bi-card-checklist"></i> Gestion productos</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav me-5 mb-2 mb-lg-0 ms-5">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ Auth::user()->nombre }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link active" aria-current="page"
                                        href="{{ route('logout') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
    @yield('content')
    <footer>
        <br><br><br><br>
    </footer>
</body>

</html>
