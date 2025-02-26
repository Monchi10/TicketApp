<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;

class ConcertController extends Controller
{
    public function index()
    {
        $concerts = Concert::all();
        return view('concerts.index', compact('concerts'));
    }

    public function create()
    {
        return view('concerts.create');
    }

    public function store(Request $request)
    {
        Concert::create($request->all());
        return redirect()->route('concerts.index');
    }
}

