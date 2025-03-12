<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\TipoEntrada;
use App\Models\Pedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class EntradaController extends Controller
{
    /**
     * Muestra la lista de todas las entradas.
     */
    public function index()
    {
        // Cargamos las relaciones para mostrar info de tipoEntrada y pedido
        $entradas = Entrada::with(['tipoEntrada', 'pedido'])->get();

        return view('admin.entradas.index', compact('entradas'));
    }

    /**
     * Muestra el formulario para crear una nueva entrada.
     */
    public function create()
    {
        // Para poblar el select de tipoEntrada
        $tiposEntradas = TipoEntrada::all();
        // Si quieres asignar un pedido específico, puedes obtenerlos también:
        // $pedidos = Pedido::all();

        return view('admin.entradas.create', compact('tiposEntradas'));
    }

    /**
     * Almacena una nueva entrada en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo_entrada_id' => 'required|exists:tipo_entradas,id',
            'codigo' => 'required|unique:entradas,codigo',
            'usada'  => 'required|boolean',
            // 'pedido_id' => 'nullable|exists:pedidos,id', // Si se asigna pedido de forma opcional
        ]);

        // Crear la entrada
        Entrada::create([
            'tipo_entrada_id' => $request->tipo_entrada_id,
            'pedido_id'       => $request->pedido_id, // o null si no se asigna todavía
            'codigo'          => $request->codigo,
            'usada'           => $request->usada,
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada creada correctamente');
    }

    /**
     * Muestra los detalles de una entrada específica.
     */
    public function show($id)
    {
        $entrada = Entrada::with(['tipoEntrada', 'pedido'])->findOrFail($id);
        return view('admin.entradas.show', compact('entrada'));
    }

    /**
     * Muestra el formulario para editar una entrada existente.
     */
    public function edit($id)
    {
        $entrada = Entrada::findOrFail($id);
        $tiposEntradas = TipoEntrada::all();
        // $pedidos = Pedido::all();

        return view('admin.entradas.edit', compact('entrada', 'tiposEntradas'));
    }

    /**
     * Actualiza la entrada en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $entrada = Entrada::findOrFail($id);

        $request->validate([
            'tipo_entrada_id' => 'required|exists:tipo_entradas,id',
            'codigo' => 'required|unique:entradas,codigo,' . $id, // ignorar el mismo ID
            'usada'  => 'required|boolean',
        ]);

        $entrada->update([
            'tipo_entrada_id' => $request->tipo_entrada_id,
            'pedido_id'       => $request->pedido_id,
            'codigo'          => $request->codigo,
            'usada'           => $request->usada,
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada correctamente');
    }

    public function generateQR($codigo)
    {
        // Genera el QR basado en el código de la entrada
        $qrCode = QrCode::format('png')->size(300)->generate($codigo);

        return response($qrCode)->header('Content-Type', 'image/png');
    }

    public function downloadQR($codigo)
    {
        // Generar QR como imagen PNG
        $qrCode = QrCode::format('png')->size(300)->generate("127.0.0.1/consumirEntrada/" . $codigo);

        // Nombre del archivo
        $fileName = 'QR_' . $codigo . '.png';

        // Guardar en almacenamiento temporal
        $filePath = storage_path('app/public/' . $fileName);
        file_put_contents($filePath, $qrCode);

        // Descargar archivo
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    /**
     * Elimina una entrada de la base de datos.
     */
    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->delete();

        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada correctamente');
    }
}
