<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use Illuminate\Http\Request;

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
        ]);

        // Guardar la imagen si se subió
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('lugares', 'public');
        }

        Lugar::create([
            'nombre' => $request->nombre,
            'imagen' => $imagenPath,
        ]);

        return redirect()->route('lugares.index')->with('success', 'Lugar creado con éxito');
    }

    // Mostrar formulario de edición
    public function edit(Lugar $lugar) {
        return view('admin.lugares.edit', compact('lugar'));
    }

    // Actualizar un lugar
    public function update(Request $request, Lugar $lugar) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('lugares', 'public');
            $lugar->imagen = $imagenPath;
        }

        $lugar->nombre = $request->nombre;
        $lugar->save();

        return redirect()->route('lugares.index')->with('success', 'Lugar actualizado con éxito');
    }

    // Eliminar un lugar
    public function destroy(Lugar $lugar) {
        $lugar->delete();
        return redirect()->route('lugares.index')->with('success', 'Lugar eliminado con éxito');
    }
}

