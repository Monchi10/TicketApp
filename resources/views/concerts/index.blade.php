{{-- resources/views/concerts/index.blade.php --}}
@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Lista de Conciertos</h2>
        @foreach($concerts as $concert)
            <div class="concert">
                <h3>{{ $concert->name }}</h3>
                <p>Fecha: {{ $concert->date }}</p>
                <p>Entradas disponibles: {{ $concert->available_tickets }}</p>
                <a href="{{ route('tickets.create', $concert->id) }}">Comprar Entrada</a>
            </div>
        @endforeach
    </div>
@endsection