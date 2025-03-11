<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('lugares_posiciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lugar')->constrained('lugares')->onDelete('cascade');
            $table->string('posicion');
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('lugares_posiciones');
    }
};