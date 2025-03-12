@extends('layouts.app')

@section('content')
<style>
    /* Ajusta la imagen para que no exceda una altura y se recorte proporcionalmente */
    .carousel-item img {
        width: 90%;
        max-height: 70vh;   /* Cambia el valor a la altura que prefieras */
        object-fit: cover;   /* Recorta la imagen para ajustarse al contenedor */
    }
    /* Da un fondo semitransparente a la leyenda para que se vea mejor */
    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.4); /* Fondo negro con 40% de opacidad */
        padding: 10px;
        border-radius: 5px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Bienvenido a la Venta de Entradas</h1>
            <p class="lead">Encuentra tus conciertos, teatros y eventos favoritos</p>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <form action="{{ route('eventos.index') }}" method="GET">
        <div class="input-group mb-4 mt-2">
            <input type="text" class="form-control" placeholder="Buscar por artista" 
                   aria-label="Buscar" name="query" value="{{ request('query') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                    Buscar
                </button>
            </div>
        </div>
    </form>

    @if(isset($eventos) && $eventos->count() > 0)
    <div id="eventoCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($eventos as $index => $evento)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <a href="{{ route('tickets.purchase', $evento->id) }}">
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="{{ $evento->nombre }}">
                </a>                
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $evento->nombre }}</h5>
                    <p>{{ $evento->artista }} - {{ $evento->lugar_nombre }} ({{ $evento->fecha }}) {{ $evento->lugar->nombre }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#eventoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
    @endif
</div>
<div>
    @if($eventos->count() > 0)
    <div class="container mt-5">
        <h2>Conciertos</h2>
        <div class="row">
            @foreach($eventos as $evento)
                <div class="col-md-3">
                    <div class="card">
                        <div class="container mt-5">
                            <a href="{{ route('tickets.purchase', $evento->id) }}">
                                <img src="{{ asset('storage/' . $evento->imagen) }}" 
                                     class="card-img-top" 
                                     alt="{{ $evento->nombre }}">
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $evento->nombre }}</h5>
                            <p class="card-text">
                                {{ $evento->lugar->nombre }}  
                            </p>
                            <p class="card-text">
                                {{ $evento->fecha }} 
                            </p>
                            <p class="card-text">
                                {{ $evento->hora }} 
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p class="text-center mt-3">No se encontraron resultados para "{{ request('query') }}"</p>
@endif
</div>
@endsection
