<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use Illuminate\Http\Request;
use App\Models\LugarPosicion;

class LugarController extends Controller {
    // Mostrar todos los lugares
    public function index() {
        $lugares = Lugar::all();
        return view('admin.lugares.index', compact('lugares'));
    }

    // Mostrar formulario para crear un nuevo lugar
    public function create() {
        return view('admin.lugares.create');
    }

    // Guardar un nuevo lugar
    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posiciones' => 'nullable|array',
            'posiciones.*' => 'string|max:255', // Cada posición debe ser un string válido
        ]);
    
        // Guardar la imagen del lugar
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('lugares', 'public');
        }
    
        // Crear el lugar
        $lugar = Lugar::create([
            'nombre' => $request->nombre,
            'imagen' => $imagenPath,
        ]);
    
        // Guardar las posiciones asociadas si existen
        if ($request->has('posiciones')) {
            foreach ($request->posiciones as $posicion) {
                LugarPosicion::create([
                    'id_lugar' => $lugar->id,
                    'posicion' => $posicion,
                ]);
            }
        }
    
        return redirect()->route('lugares.index')->with('success', 'Lugar creado con éxito');
    }
    

    // Mostrar formulario de edición
    public function edit(Lugar $lugare) {
        $lugar = Lugar::findOrFail($lugare->id);

        // dd($lugar);
        return view('admin.lugares.edit', compact('lugar'));
    }

    // Actualizar un lugar
    public function update(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posiciones' => 'nullable|array',
            'posiciones.*' => 'string|max:255', // Cada posición debe ser un string válido
        ]);
    
        // Buscar el lugar que se desea actualizar
        $lugar = Lugar::findOrFail($id);
    
        // Si hay una nueva imagen, guardarla y actualizar la ruta en la base de datos
        $imagenPath = $lugar->imagen; // Mantener la imagen actual si no se sube una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($imagenPath) {
                Storage::disk('public')->delete($imagenPath);
            }
            // Guardar la nueva imagen
            $imagenPath = $request->file('imagen')->store('lugares', 'public');
        }
    
        // Actualizar los datos del lugar
        $lugar->update([
            'nombre' => $request->nombre,
            'imagen' => $imagenPath,
        ]);
    
        // Eliminar las posiciones existentes del lugar
        LugarPosicion::where('id_lugar', $lugar->id)->delete();
    
        // Guardar las nuevas posiciones asociadas, si existen
        if ($request->has('posiciones')) {
            foreach ($request->posiciones as $posicion) {
                LugarPosicion::create([
                    'id_lugar' => $lugar->id,
                    'posicion' => $posicion,
                ]);
            }
        }
    
        // Redirigir a la vista de lugares con un mensaje de éxito
        return redirect()->route('lugares.index')->with('success', 'Lugar actualizado con éxito');
    }
    

    // Eliminar un lugar
    public function destroy(Lugar $lugare) {
        // dd($lugare);
        $lugar = Lugar::findOrFail($lugare->id);
        // dd($lugar);
        $lugar->delete();
        return redirect()->route('lugares.index')->with('success', 'Lugar eliminado con éxito');
    }

    public function getPosiciones($lugarId)
    {
        $lugar = Lugar::findOrFail($lugarId);
        $posiciones = $lugar->posiciones; // Relación de posiciones asociadas al lugar

        return response()->json($posiciones);
    }

}