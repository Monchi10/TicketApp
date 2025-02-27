{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Dashboard de Usuario</h1>
        <p>Bienvenido {{ Auth::user()->name }}, este es tu dashboard.</p>

        {{-- Solo mostrar los botones si el usuario NO está autenticado --}}
        @guest
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">
                Iniciar Sesión
            </a>
            <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">
                Registrarse
            </a>
        @endguest

        {{-- Opcional: Si quieres mostrar algo solo a usuarios logueados --}}
        @auth
            <p class="mt-4">Ya estás autenticado como {{ Auth::user()->name }}.</p>
        @endauth
    </div>
@endsection