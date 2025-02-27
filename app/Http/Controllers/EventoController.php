<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\TipoEntrada;
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

        $capacidad = $request->capacidad;
        $totalStock = array_sum(array_column($request->tipos_entrada, 'stock'));
    
        if ($totalStock > $capacidad) {
            return redirect()->back()->withErrors(['stock' => 'La suma del stock de los tipos de entrada supera la capacidad del evento.'])->withInput();
        }
        
        // Guardar imagen si se ha subido
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('eventos', 'public');
        }

        // Crear evento
        $evento = Evento::create([
            'nombre' => $request->nombre,
            'artista' => $request->artista,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'lugar' => $request->lugar,
            'capacidad' => $request->capacidad,
            'imagen' => $imagenPath,
            'estado' => $request->estado,
        ]);


        if ($request->has('tipos_entrada')) {
            foreach ($request->tipos_entrada as $entrada) {
                TipoEntrada::create([
                    'evento_id' => $evento->id,
                    'nombre' => $entrada['nombre'],
                    'precio' => $entrada['precio'],
                    'stock' => $entrada['stock'],
                ]);
            }
        }
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
        $evento = Evento::with('tiposEntrada')->findOrFail($id);
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

        // Actualizar Tipos de Entrada
        $evento->tiposEntrada()->delete();

        if ($request->has('tipos_entrada')) {
            foreach ($request->tipos_entrada as $entrada) {
                TipoEntrada::create([
                    'evento_id' => $evento->id,
                    'nombre' => $entrada['nombre'],
                    'precio' => $entrada['precio'],
                    'stock' => $entrada['stock'],
                ]);
            }
        }

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }
    

    // Eliminar un evento
    public function destroy($id) {
        $evento = Evento::findOrFail($id);
        $evento->delete();

        return redirect()->route('eventos.index')->with('success', 'Evento eliminado con éxito');
    }
}

