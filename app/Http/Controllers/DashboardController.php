<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Entrada;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total de dinero generado en ventas hoy
        $totalVentasHoy = Pedido::whereDate('created_at', Carbon::today())->sum('total');

        // Cantidad de entradas vendidas hoy
        $cantidadEntradasVendidasHoy = Entrada::whereDate('created_at', Carbon::today())->count();

        return view('dashboard', compact('user', 'totalVentasHoy', 'cantidadEntradasVendidasHoy'));
    }
}