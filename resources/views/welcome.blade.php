{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1 class="display-4">Bienvenido a la Venta de Entradas</h1>
        <p class="lead">Encuentra tus conciertos, teatros y eventos favoritos</p>
        <hr class="my-4">
        <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">
            Iniciar Sesión
        </a>
        <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">
            Registrarse
        </a>
    </div>
@endsection

