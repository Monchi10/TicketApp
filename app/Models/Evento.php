<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model {
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'nombre',
        'artista',
        'fecha',
        'hora',
        'lugar',
        'capacidad',
        'imagen',
        'estado'
    ];


    public function tiposEntrada()
    {
        return $this->hasMany(TipoEntrada::class);
    }

    public function lugar()
    {
        return $this->belongsTo(Lugar::class);
    }
    
}