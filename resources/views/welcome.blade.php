{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Texto de bienvenida y botones -->
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Bienvenido a la Venta de Entradas</h1>
            <p class="lead">Encuentra tus conciertos, teatros y eventos favoritos</p>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="row">
        <div class="col-md-12">
            <form action="#" method="GET">
                <div class="input-group mb-4 mt-2">
                    <input type="text" class="form-control" 
                           placeholder="Buscar espectáculos y más" 
                           aria-label="Buscar" name="query">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection