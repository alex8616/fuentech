<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->enum('TipoPago', ['Efectivo', 'Tarjeta', 'Deposito/QR'])->default('Efectivo');
            $table->string('TipoMoneda')->nullable();
            $table->dateTime('FechaDePago');
            $table->decimal('TotalPago', 12, 2);
            $table->unsignedBigInteger('hospedaje_habitacion_id')->nullable();
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade');
            $table->unsignedBigInteger('consumo_id')->nullable();
            $table->foreign('consumo_id')->references('id')->on('consumos')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('grupo_id')->nullable();
            $table->foreign('grupo_id')->references('id')->on('grupo_hospedajes')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('reserva_salones_id')->nullable();
            $table->foreign('reserva_salones_id')->references('id')->on('reserva_salones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
