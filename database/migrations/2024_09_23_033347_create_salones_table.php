<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salones', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_salon');
            $table->string('Detalle_salon');
            $table->string('Precio_salon');
            $table->string('imagen')->nullable();
            $table->enum('Estado_salon', ['DISPONIBLE', 'OCUPADO', 'LIMPIEZA'])->default('DISPONIBLE');
            $table->enum('Reserva_salon', ['SI', 'NO'])->default('NO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salones');
    }
};
