<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model {
    use HasFactory;

    protected $table = 'lugares'; // Definir el nombre correcto de la tabla
    protected $fillable = ['nombre', 'imagen'];

    public function posiciones() {
        return $this->hasMany(LugarPosicion::class, 'id_lugar');
    }
}