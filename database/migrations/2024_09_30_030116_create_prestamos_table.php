<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_objeto')->nullable();
            $table->string('TipoServicio')->nullable();
            $table->string('fecha_venta')->nullable();
            $table->string('fecha_cierre')->nullable();
            $table->string('comentario')->nullable();
            $table->enum('Devuelto', ['true', 'false'])->default('false');
            $table->unsignedBigInteger('hospedaje_habitacion_id')->nullable();
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
