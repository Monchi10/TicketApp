{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="text-center text-primary">Dashboard de Usuario</h1>
        <p class="text-center">Bienvenido, <strong>{{ $user->name }}</strong>. Aquí puedes ver tu información.</p>

        @auth
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-success mb-3">
                    <div class="card-header bg-success text-white text-center">Total Ventas Hoy</div>
                    <div class="card-body text-center">
                        <h2 class="text-success">${{ number_format($totalVentasHoy, 2) }}</h2>
                        <p>en ingresos generados hoy</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-warning mb-3">
                    <div class="card-header bg-warning text-dark text-center">Entradas Vendidas Hoy</div>
                    <div class="card-body text-center">
                        <h2 class="text-warning">{{ $cantidadEntradasVendidasHoy }}</h2>
                        <p>entradas vendidas en las últimas 24 horas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta con los datos del usuario -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white text-center">Información de Usuario</div>
                    <div class="card-body text-center">
                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Rol:</strong> {{ $user->isAdmin() ? 'Administrador' : 'Usuario' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endauth

        @guest
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Iniciar Sesión</a>
            <a class="btn btn-success btn-lg" href="{{ route('register') }}">Registrarse</a>
        </div>
        @endguest
    </div>
</div>
@endsection
