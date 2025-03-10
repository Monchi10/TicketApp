<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidosController extends Controller
{
    /**
     * Muestra el carrito de compras.
     */
    public function index()
    {
        return view('carrito.index');
    }

    /**
     * Elimina un item del carrito.
     */
    public function eliminar($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('carrito.index')->with('success', 'Entrada eliminada del carrito.');
    }

    /**
     * Confirma el pedido.
     */
    public function confirmarPedido()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        // Aquí se procesaría la creación del pedido en la base de datos

        session()->forget('cart'); // Vaciar el carrito tras la compra

        return redirect()->route('carrito.index')->with('success', 'Pedido confirmado correctamente.');
    }
}
