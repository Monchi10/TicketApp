@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Gestión de Posiciones para: {{ $lugar->nombre }}</h2>
    <a href="{{ route('lugares.index') }}" class="btn btn-secondary mb-3">Volver a Lugares</a>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Agregar Nueva Posición</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('lugares.posiciones.store', $lugar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="posicion" class="form-label">Posición</label>
                    <input type="text" name="posicion" id="posicion" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success">Agregar Posición</button>
            </form>
        </div>
    </div>

    <hr>

    <h4>Lista de Posiciones</h4>
    @if($posiciones->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Posición</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posiciones as $posicion)
                    <tr>
                        <td>{{ $posicion->id }}</td>
                        <td>{{ $posicion->posicion }}</td>
                        <td>
                            @if($posicion->imagen)
                                <img src="{{ asset('storage/' . $posicion->imagen) }}" alt="{{ $posicion->posicion }}" width="100">
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('lugares.posiciones.destroy', [$lugar->id, $posicion->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay posiciones registradas para este lugar.</p>
    @endif
</div>
@endsection
