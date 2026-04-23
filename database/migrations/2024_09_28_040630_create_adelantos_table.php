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
        Schema::create('adelantos', function (Blueprint $table) {
            $table->id();
            $table->enum('TipoAdelanto', ['Efectivo', 'Tarjeta', 'Deposito/QR'])->default('Efectivo');
            $table->dateTime('FechaDeAdelanto');
            $table->decimal('TotalAdelanto', 12, 2);

            $table->string('TipoMoneda')->nullable();
            $table->decimal('MontoDolar', 12, 2)->nullable();

            $table->unsignedBigInteger('hospedaje_habitacion_id')->nullable();
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('grupo_hospedajes_id')->nullable();
            $table->foreign('grupo_hospedajes_id')->references('id')->on('grupo_hospedajes')->onDelete('cascade');
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
        Schema::dropIfExists('adelantos');
    }
};
