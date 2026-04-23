<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserva_salones_id')->nullable();
            $table->foreign('reserva_salones_id')->references('id')->on('reserva_salones')->onDelete('cascade');
            $table->unsignedBigInteger('hospedaje_habitacion_id')->nullable();
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('FechaRegistro_servicio')->nullable();
            $table->dateTime('FechaCierre')->nullable();
            $table->string('ServicioComentario')->nullable();
            $table->decimal('subTotalDesayuno', 12, 2)->nullable();
            $table->decimal('totalpagadoDesayuno', 12, 2)->nullable();
            $table->decimal('totalDesayuno', 12, 2)->nullable();
            $table->decimal('subTotalLavado', 12, 2)->nullable();
            $table->decimal('totalpagadoLavado', 12, 2)->nullable();
            $table->decimal('subTotalData', 12, 2)->nullable();
            $table->decimal('totalpagadoData', 12, 2)->nullable();
            $table->decimal('totalData', 12, 2)->nullable();
            $table->decimal('totalLavado', 12, 2)->nullable();
            $table->decimal('totalgeneral', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
