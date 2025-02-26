<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model {
    use HasFactory;

    protected $table = 'entradas';

    protected $fillable = [
        'pedido_id',
        'tipo_entrada_id',
        'codigo',
        'usada'
    ];

    public function pedido() {
        return $this->belongsTo(Pedido::class);
    }

    public function tipoEntrada() {
        return $this->belongsTo(TipoEntrada::class);
    }

    public function escaneos() {
        return $this->hasMany(Escaneo::class);
    }
}

