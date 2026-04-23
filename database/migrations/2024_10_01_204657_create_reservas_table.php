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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospedaje_habitacion_id')->nullable();
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('ingreso_reserva')->nullable();
            $table->date('salida_reserva')->nullable();
            $table->enum('EstadoReserva', ['Concluido', 'En Espera', 'Cancelado'])->default('En Espera');
            $table->string('ComentarioReserva')->nullable();
            $table->string('CategoriaHabitacion')->nullable();
            $table->string('CantidadPersonas')->nullable();
            $table->string('CodigoReserva')->nullable();
            $table->string('CanalReserva')->nullable();
            $table->string('ComisionReserva')->nullable();
            $table->string('LlegadoReserva')->nullable();
            $table->string('PrecioDolar')->nullable();
            $table->string('PrecioBolivianos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
