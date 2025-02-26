<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model {
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'codigo',
        'nombre_comprador',
        'email_comprador',
        'total',
        'estado'
    ];

    public function entradas() {
        return $this->hasMany(Entrada::class);
    }
}