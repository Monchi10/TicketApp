<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Evento;
use App\Models\Pedido;
use App\Models\Entrada;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 🚀 Verifica si el usuario es administrador
        if (!$user->isAdmin()) {
            return redirect('/'); // 🔄 Redirige a la página de inicio si no es admin
        }

        // Total de dinero generado en ventas hoy
        $totalVentasHoy = Pedido::whereDate('created_at', Carbon::today())->sum('total');

        // Cantidad de entradas vendidas hoy
        $cantidadEntradasVendidasHoy = Entrada::whereDate('created_at', Carbon::today())->count();

        return view('dashboard', compact('user', 'totalVentasHoy', 'cantidadEntradasVendidasHoy'));

        $eventos = Evento::all(); // Esto ya lo usas para el carrusel
        $conciertos = Evento::where('categoria', 'Conciertos')->get();
    
        return view('welcome', compact('eventos', 'conciertos'));
    }
}