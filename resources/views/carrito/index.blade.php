@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Carrito de Compras</h2>
    
    @if(session('cart') && count(session('cart')) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Tipo de Entrada</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $key => $item)
                    <tr>
                        <td>{{ $item['evento'] }}</td>
                        <td>{{ $item['tipo_entrada'] }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>${{ number_format($item['precio'], 2) }}</td>
                        <td>${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                        <td>
                            <form action="{{ route('carrito.eliminar', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('pedido.confirmar') }}" class="btn btn-success">Confirmar Pedido</a>
        </div>
    @else
        <p>Tu carrito está vacío.</p>
    @endif
</div>
@endsection
