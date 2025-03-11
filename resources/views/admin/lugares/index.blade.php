@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Lugares Disponibles</h2>

    <a href="{{ route('lugares.create') }}" class="btn btn-primary mb-3">Crear Nuevo Lugar</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lugares as $lugar)
                <tr>
                    <td>{{ $lugar->nombre }}</td>
                    <td>
                        @if ($lugar->imagen)
                            <img src="{{ asset('storage/' . $lugar->imagen) }}" alt="Imagen" width="100">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('lugares.edit', $lugar->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('lugares.destroy', $lugar->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
