<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('artista');
            $table->date('fecha');
            $table->time('hora');
            $table->string('lugar_id');
            $table->integer('capacidad');
            $table->string('imagen')->nullable(); // URL o path de la imagen
            $table->enum('estado', ['activo', 'finalizado', 'cancelado'])->default('activo');
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
