<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\LugarPosicion;
use Illuminate\Http\Request;

class LugarPosicionController extends Controller {
    
    // Mostrar las posiciones de un lugar
    public function index($lugar_id) {
        $lugar = Lugar::findOrFail($lugar_id); // Obtén el lugar por ID
        $posiciones = LugarPosicion::where('lugar_id', $lugar_id)->get(); // Obtén las posiciones relacionadas con ese lugar
    
        return view('admin.lugares.posiciones', compact('lugar', 'posiciones'));     
    }
    

    // Mostrar formulario para agregar una posición
    public function create($lugar_id) {
        $lugar = Lugar::findOrFail($lugar_id);
        return view('admin.lugares_posiciones.create', compact('lugar'));
    }

    // Guardar una nueva posición
    public function store(Request $request, $lugar_id) {
        $request->validate([
            'posicion' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('lugares_posiciones', 'public');
        }

        LugarPosicion::create([
            'lugar_id' => $lugar_id,
            'posicion' => $request->posicion,
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('lugares.posiciones.index', $lugar_id)->with('success', 'Posición agregada exitosamente.');
    }

    // Eliminar una posición
    public function destroy($id) {
        $posicion = LugarPosicion::findOrFail($id);
        $lugar_id = $posicion->lugar_id;
        $posicion->delete();
        return redirect()->route('lugares.posiciones.index', $lugar_id)->with('success', 'Posición eliminada exitosamente.');
    }
}
