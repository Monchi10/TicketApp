{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Venta de Entradas</title>
    <!-- Incluye Bootstrap CSS (puedes usar la versión que prefieras) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para íconos de redes sociales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                        <a class="nav-link" href="{{ route('tickets.user') }}">Mis Entradas</a>
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

    <footer class="bg-dark text-light pt-5 pb-3">
        <div class="container">
            <div class="row">
                <!-- Sección: Sobre la empresa -->
                <div class="col-md-4 text-center text-md-start mb-4">
                    <h5 class="fw-bold">TicketApp</h5>
                    <p class="small">Compra tus entradas de manera rápida y segura para los mejores eventos.</p>
                    <p class="small mb-0">© 2025 TicketApp. Todos los derechos reservados.</p>
                </div>
    
                <!-- Sección: Enlaces rápidos -->
                <div class="col-md-4 text-center mb-4">
                    <h5 class="fw-bold">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Términos y Condiciones</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Política de Privacidad</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Política de Cookies</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Ayuda</a></li>
                    </ul>
                </div>
    
                <!-- Sección: Redes Sociales -->
                <div class="col-md-4 text-center text-md-end">
                    <div class="d-flex align-items-center gap-2 justify-content-center justify-content-md-end">
                        <h5 class="fw-bold mb-0">Síguenos</h5>
                        <a href="https://www.instagram.com/agustingeloso9" class="text-light me-3">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>    
                    </div>
            
                </div>
            </div>
    
            <!-- Línea divisoria -->
            <hr class="border-light my-4">
    
            <!-- Sección: Última fila -->
            <div class="row">
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