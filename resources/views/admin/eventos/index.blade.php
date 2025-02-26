@extends('layouts.app')

@section('content')
    <h1>Lista de Eventos</h1>
    <a href="{{ route('eventos.create') }}" class="btn btn-primary">Crear Nuevo Evento</a>
    <ul>
        @foreach($eventos as $evento)
            <li>
                <a href="{{ route('eventos.show', $evento->id) }}">{{ $evento->nombre }}</a> - {{ $evento->fecha }}
                <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
