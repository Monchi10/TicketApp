@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar Evento</h1>

        <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Evento</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $evento->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="artista" class="form-label">Artista</label>
                <input type="text" name="artista" id="artista" class="form-control" value="{{ old('artista', $evento->artista) }}" required>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $evento->fecha) }}" required>
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" name="hora" id="hora" class="form-control" value="{{ old('hora', $evento->hora) }}" required>
            </div>

            <div class="mb-3">
                <label for="lugar" class="form-label">Lugar</label>
                <input type="text" name="lugar" id="lugar" class="form-control" value="{{ old('lugar', $evento->lugar) }}" required>
            </div>

            <div class="mb-3">
                <label for="capacidad" class="form-label">Capacidad</label>
                <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad', $evento->capacidad) }}" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="activo" {{ $evento->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="finalizado" {{ $evento->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    <option value="cancelado" {{ $evento->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Evento</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
                @if ($evento->imagen)
                    <p class="mt-2">Imagen actual:</p>
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen del evento" class="img-thumbnail" width="200">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
