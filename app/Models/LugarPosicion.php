<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarPosicion extends Model {
    use HasFactory;

    protected $table = 'lugares_posiciones';
    protected $fillable = ['id_lugar', 'posicion', 'imagen'];


    public function lugar() {
        return $this->belongsTo(Lugar::class, 'id_lugar');
    }
}