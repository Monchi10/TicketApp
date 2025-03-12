<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEntrada extends Model {
    use HasFactory;

    protected $table = 'tipos_entrada';

    protected $fillable = [
        'evento_id',
        'lugar_posicion_id',
        'nombre',
        'precio',
        'stock'
    ];

    // Relación con Evento
    public function evento() {
        return $this->belongsTo(Evento::class);
    }

    public function LugarPosicion() {
        return $this->hasOne(LugarPosicion::class);
    }
}