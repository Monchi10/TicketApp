<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escaneo extends Model {
    use HasFactory;

    protected $table = 'escaneos';

    protected $fillable = [
        'entrada_id',
        'fecha_hora',
        'ubicacion'
    ];

    public function entrada() {
        return $this->belongsTo(Entrada::class);
    }
}

