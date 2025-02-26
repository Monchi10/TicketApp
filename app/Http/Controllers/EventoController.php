<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller {
    // Mostrar todos los eventos
    public function index() {
        $eventos = Evento::all();
        return view('admin.eventos.index', compact('eventos'));
    }

    // Mostrar el formulario para crear un evento
    public function create() {
        return view('admin.eventos.create');
    }

    // Guardar un nuevo evento en la base de datos
    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'artista' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'lugar' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:activo,finalizado,cancelado',
        ]);

        // Guardar imagen si se ha subido
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('eventos', 'public');
        }

        // Crear evento
        Evento::create([
            'nombre' => $request->nombre,
            'artista' => $request->artista,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'lugar' => $request->lugar,
            'capacidad' => $request->capacidad,
            'imagen' => $imagenPath,
            'estado' => $request->estado,
        ]);

        return redirect()->route('eventos.index')->with('success', 'Evento creado con éxito');
    }

    // Mostrar los detalles de un evento
    public function show($id) {
        $evento = Evento::findOrFail($id);
        return view('admin.eventos.show', compact('evento'));
    }

    // Mostrar el formulario de edición de un evento
    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        return view('admin.eventos.edit', compact('evento'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'artista' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'lugar' => 'required|string|max:255',
            'capacidad' => 'required|integer',
            'estado' => 'required|in:activo,finalizado,cancelado',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);
    
        $evento = Evento::findOrFail($id);
    
        $evento->update([
            'nombre' => $request->nombre,
            'artista' => $request->artista,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'lugar' => $request->lugar,
            'capacidad' => $request->capacidad,
            'estado' => $request->estado
        ]);
    
        if ($request->hasFile('imagen')) {
            // Guardar nueva imagen
            $imagenPath = $request->file('imagen')->store('eventos', 'public');
            $evento->imagen = $imagenPath;
            $evento->save();
        }
    
        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }
    

    // Eliminar un evento
    public function destroy($id) {
        $evento = Evento::findOrFail($id);
        $evento->delete();

        return redirect()->route('admin.eventos.index')->with('success', 'Evento eliminado con éxito');
    }
}

