<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $query = $request->input('query');
    
        $eventos = Evento::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('artista', 'LIKE', "%{$query}%");
        }, function ($queryBuilder) {
            $queryBuilder->get(); // Si no hay búsqueda, trae todos los eventos
        })->get();
    
        return view('welcome', compact('eventos', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}