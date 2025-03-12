@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Mis Entradas</h2>

    @if ($pedidos->count() > 0)
        <div class="row">
            @foreach ($pedidos as $pedido)
                @foreach ($pedido->entradas as $entrada)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="{{ asset('storage/' . $entrada->tipoEntrada->evento->imagen) }}" class="card-img-top" alt="Evento">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $entrada->tipoEntrada->evento->nombre }}</h5>
                                <p><strong>Tipo:</strong> {{ $entrada->tipoEntrada->nombre }}</p>
                                <p><strong>Código:</strong> {{ $entrada->codigo }}</p>
                                <!-- Código QR -->
                                <div>
                                    {!! QrCode::size(200)->generate("127.0.0.1/consumirEntrada/".$entrada->codigo) !!}
                                </div>
                                <div>
                                    <!-- Botón de descarga -->
                                    <a href="{{ route('download.qr', $entrada->codigo) }}" class="btn btn-primary mt-2" download>
                                    Descargar QR
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @else
        <p class="text-center">No tienes entradas compradas.</p>
    @endif
</div>
@endsection