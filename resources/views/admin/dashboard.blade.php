{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')

        <h1>Dashboard de Administrador</h1>
        <p>Bienvenido {{ Auth::user()->name }}, aquí puedes gestionar todo.</p>
        <div class="container">
            <h2>Bienvenido, {{ Auth::user()->name }}</h2>
            @if(Auth::user()->isAdmin())
                 <a href="{{ route('eventos.create') }}">Crear Concierto</a>
            @endif
                <a href="{{ route('eventos.index') }}">Ver Conciertos</a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>     
@endsection
