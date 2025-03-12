@extends('layouts.app')

@section('content')
<div class="container">
    <h2><strong>{{ $evento->nombre }}- ({{ $evento->fecha }})</strong></h2>
    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="{{ $evento->nombre }}">
    <hr>
    <h4>Tipos de Entrada Disponibles</h4>
    @if($tiposEntrada->count() > 0)
        <form action="{{ route('tickets.process', $evento->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tipo_entrada_id" class="form-label">Selecciona el tipo de entrada:</label>
                <select name="tipo_entrada_id" id="tipo_entrada_id" class="form-select" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($tiposEntrada as $tipo)
                        <option value="{{ $tipo->id }}">
                            {{ $tipo->nombre }} - ${{ $tipo->precio }} (Disponibles: {{ $tipo->stock }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label for="nombre_comprador" class="form-label">Tu Nombre:</label>
                <input type="text" name="nombre_comprador" id="nombre_comprador" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email_comprador" class="form-label">Tu Email:</label>
                <input type="email" name="email_comprador" id="email_comprador" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Comprar Entradas</button>
        </form>
    @else
        <p>No hay entradas disponibles para este evento.</p>
    @endif
</div>
@endsection
