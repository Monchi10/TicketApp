{{-- resources/views/concerts/create.blade.php --}}
@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Crear Nuevo Concierto</h2>
        <form action="{{ route('concerts.store') }}" method="POST">
            @csrf
            <label>Nombre del Concierto:</label>
            <input type="text" name="name" required>
            <label>Fecha:</label>
            <input type="datetime-local" name="date" required>
            <label>Entradas Disponibles:</label>
            <input type="number" name="available_tickets" required>
            <button type="submit">Crear Concierto</button>
        </form>
    </div>
@endsection