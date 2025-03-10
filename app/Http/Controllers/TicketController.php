<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\TipoEntrada;
use App\Models\Pedido;
use App\Models\Entrada;
use App\Models\Escaneo;
use Illuminate\Support\Str;
use Carbon\Carbon;


class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Muestra el formulario de compra del evento
    public function showPurchaseForm(Evento $evento)
    {
        // Obtener solo los tipos de entrada con stock disponible
        $tiposEntrada = TipoEntrada::where('evento_id', $evento->id)
                            ->where('stock', '>', 0)
                            ->get();

        return view('tickets.purchase', compact('evento', 'tiposEntrada'));
    }

    // Procesa la compra, genera el pedido y las entradas individuales
    public function processPurchase(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre_comprador' => 'required|string|max:255',
            'email_comprador'  => 'required|email|max:255',
            'tipo_entrada_id'  => 'required|exists:tipos_entrada,id',
            'cantidad'         => 'required|integer|min:1',
        ]);

        // Obtener el tipo de entrada seleccionado
        $tipoEntrada = TipoEntrada::findOrFail($request->tipo_entrada_id);

        // Validar que haya stock suficiente
        if ($tipoEntrada->stock < $request->cantidad) {
            return redirect()->back()->withErrors(['cantidad' => 'No hay suficientes entradas disponibles.'])->withInput();
        }

        // Calcular el total
        $total = $tipoEntrada->precio * $request->cantidad;

        // Generar un código único para el pedido
        $codigoPedido = strtoupper(Str::random(10));

        // Crear el pedido
        $pedido = Pedido::create([
            'codigo'           => $codigoPedido,
            'nombre_comprador' => $request->nombre_comprador,
            'email_comprador'  => $request->email_comprador,
            'total'            => $total,
            'estado'           => 'pendiente',
        ]);

        // Generar una entrada para cada ticket comprado
        for ($i = 0; $i < $request->cantidad; $i++) {
            // Generar un código único para cada entrada (usado en el QR)
            $codigoEntrada = strtoupper(Str::random(12));
            

            Entrada::create([
                'pedido_id'       => $pedido->id,
                'tipo_entrada_id' => $tipoEntrada->id,
                'codigo'          => $codigoEntrada,
                'usada'           => false,
            ]);
        }

        // Descontar del stock del tipo de entrada
        $tipoEntrada->decrement('stock', $request->cantidad);

        // Redireccionamos a la vista de detalle del pedido
        return redirect()->route('tickets.detail', ['pedido' => $pedido->id])
                         ->with('success', 'Pedido realizado correctamente. Revisa tu correo para ver los QR.');
    }

    // Muestra el detalle del pedido con todas las entradas y sus QR
    public function showTicketDetail(Pedido $pedido)
    {
        // Cargar las relaciones necesarias (entradas, tipo de entrada y evento)
        $pedido->load('entradas.tipoEntrada.evento');
        return view('tickets.detail', compact('pedido'));
    }

    // Procesa el escaneo de una entrada
    public function scanTicket(Request $request, $codigo)
    {
        // dd($codigo);
        // Buscar la entrada por su código
        $entrada = Entrada::where('codigo', $codigo)->first();

        if (!$entrada) {
            return response()->json(['success' => false, 'message' => 'Entrada no encontrada.'], 404);
        }

        if ($entrada->usada) {
            return response()->json(['success' => false, 'message' => 'La entrada ya fue usada.'], 400);
        }

        // Registrar escaneo
        Escaneo::create([
            'entrada_id' => $entrada->id,
            'fecha_hora' => Carbon::now(),
            'ubicacion'  => $request->input('ubicacion', null),
        ]);

        // Marcar la entrada como usada
        $entrada->update(['usada' => true]);

        return response()->json(['success' => true, 'message' => 'Entrada escaneada y marcada como usada.']);
    }



    public function store(Request $request)
    {
        $request->validate([
            'nombre_comprador' => 'required|string|max:255',
            'email_comprador' => 'required|email|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        // Crear un código único para el pedido
        $codigoPedido = 'PED' . strtoupper(uniqid());

        $pedido = Pedido::create([
            'user_id'          => Auth::id(), // Guardamos el usuario autenticado
            'codigo'           => $codigoPedido,
            'nombre_comprador' => $request->nombre_comprador,
            'email_comprador'  => $request->email_comprador,
            'total'            => $request->total,
            'estado'           => 'pendiente',
        ]);

        return redirect()->route('tickets.user')->with('success', 'Pedido realizado con éxito.');
    }

}