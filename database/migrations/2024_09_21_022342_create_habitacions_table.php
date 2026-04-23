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
        Schema::create('habitacions', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_habitacion');
            $table->string('Detalle_habitacion');
            $table->string('Precio_habitacion');
            $table->string('imagen')->nullable();
            $table->string('color_habitacion');
            $table->enum('Estado_habitacion', ['DISPONIBLE', 'OCUPADO', 'LIMPIEZA','MANTENIMIENTO','GRUPO'])->default('DISPONIBLE');
            $table->enum('Reserva_habitacion', ['SI', 'NO'])->default('NO');
            $table->enum('Grupo_habitacion', ['SI', 'NO'])->default('NO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacions');
    }
};
