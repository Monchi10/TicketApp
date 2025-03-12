{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Venta de Entradas</title>
    <!-- Incluye Bootstrap CSS (puedes usar la versión que prefieras) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Aplica la fuente moderna al navbar y a los enlaces */
        .navbar, .navbar-nav .nav-link {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <!-- Logo o Nombre del Sitio -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                {{-- Puedes colocar aquí un logo si lo deseas --}}
                <img src="{{ asset('build/TicketApp.png') }}" alt="TicketApp" width="150px" height="150px">
            </a>

            <!-- Botón para colapsar en pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">&#9776;</span>
            </button>

            <!-- Enlaces de la navbar -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Enlaces de la izquierda -->
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('eventos.index') }}">Conciertos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('lugares.index') }}">Lugares</a>
                        </li>
                    </ul>
                @endif

                <!-- Enlaces de la derecha -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Mis Entradas</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Contenido de la página -->
    <main class="py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-light pt-4 pb-2">
        <div class="container">
        <div class="row align-items-center">
            <!-- Primera fila: Datos y enlaces -->
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <p class="mb-0">Derechos reservados © TicketApp 2025 Datos de la Empresa</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
            <p class="mb-0">
                El uso de este sitio web constituye la aceptación de los 
                <a href="#" class="text-decoration-underline text-light">Términos y Condiciones</a>, 
                de la <a href="#" class="text-decoration-underline text-light">Política de Privacidad</a>, 
                de la <a href="#" class="text-decoration-underline text-light">Política de Cookies</a> y 
                de la <a href="#" class="text-decoration-underline text-light">Política de Privacidad para Móviles</a>.
            </p>
            </div>
        </div>
        <!-- Segunda fila: Información adicional -->
        <div class="row mt-3">
            <div class="col text-center">
            <p class="small mb-0">Do Not Share My Personal Information / Your Privacy Choices</p>
            </div>
        </div>
        </div>
  </footer>
    <!-- Scripts de Bootstrap (JavaScript y dependencias) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>