<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('servicio_consumos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospedaje_habitacion_id')->nullable();
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade');
            $table->unsignedBigInteger('reserva_salones_id')->nullable();
            $table->foreign('reserva_salones_id')->references('id')->on('reserva_salones')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('FechaRegistro_servicio')->nullable();
            $table->dateTime('FechaCierre')->nullable();
            $table->string('ServicioComentario')->nullable();
            $table->decimal('subTotal', 12, 2);
            $table->decimal('totalpagado', 12, 2)->nullable();
            $table->decimal('total', 12, 2);
            $table->decimal('totalgeneral', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio_consumos');
    }
};
