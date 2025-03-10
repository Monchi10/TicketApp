<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['user_id', 'codigo', 'nombre_comprador', 'email_comprador', 'total', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }
}