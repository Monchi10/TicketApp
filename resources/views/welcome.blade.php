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
    <div class="row">
        <div class="col-md-12">
            <form action="#" method="GET">
                <div class="input-group mb-4 mt-2">
                    <input type="text" class="form-control" placeholder="Buscar espectáculos y más" aria-label="Buscar" name="query">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                    <p>{{ $evento->artista }} - {{ $evento->lugar }} ({{ $evento->fecha }})</p>
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
            @foreach($eventos as $eventos)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('storage/' . $eventos->imagen) }}" 
                             class="card-img-top" 
                             alt="{{ $eventos->nombre }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $eventos->nombre }}</h5>
                            <p class="card-text">
                                {{ $eventos->dia }} - {{ $eventos->fecha }} - {{ $eventos->hora }}
                            </p>
                            <p class="card-text">
                                {{ $eventos->lugar }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
</div>
@endsection
