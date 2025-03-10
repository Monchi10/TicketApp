@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Detalle de tu Pedido</h2>
    <p><strong>Código de Pedido:</strong> {{ $pedido->codigo }}</p>
    <p><strong>Nombre:</strong> {{ $pedido->nombre_comprador }}</p>
    <p><strong>Total:</strong> ${{ $pedido->total }}</p>
    
    <hr>
    
    <h3>Tus Entradas</h3>
    <div class="row">
        @foreach($pedido->entradas as $entrada)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Código de Entrada:</strong> {{ $entrada->codigo }}</p>
                        {{-- Generar el QR real usando simple-qrcode --}}
                        <div>
                            {!! QrCode::size(200)->generate("127.0.0.1/consumirEntrada/".$entrada->codigo) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <p>Presenta cada uno de estos códigos en el evento. Cada entrada se marcará como usada una vez escaneada.</p>
</div>
@endsection

