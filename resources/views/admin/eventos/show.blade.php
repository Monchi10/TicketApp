@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ $evento->nombre }}</h1>

        <div class="card">
            <div class="card-body">
                @if ($evento->imagen)
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del evento" class="img-fluid mb-3">
                @endif

                <p><strong>Artista:</strong> {{ $evento->artista }}</p>
                <p><strong>Fecha:</strong> {{ $evento->fecha }}</p>
                <p><strong>Hora:</strong> {{ $evento->hora }}</p>
                <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
                <p><strong>Capacidad:</strong> {{ $evento->capacidad }}</p>
                <p><strong>Estado:</strong> 
                    <span class="badge 
                        {{ $evento->estado == 'activo' ? 'bg-success' : ($evento->estado == 'finalizado' ? 'bg-secondary' : 'bg-danger') }}">
                        {{ ucfirst($evento->estado) }}
                    </span>
                </p>

                <a href="{{ route('eventos.index') }}" class="btn btn-secondary mt-3">Volver</a>
            </div>
        </div>
    </div>
@endsection
