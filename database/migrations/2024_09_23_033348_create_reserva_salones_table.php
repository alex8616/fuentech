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
        Schema::create('reserva_salones', function (Blueprint $table) {
            $table->id();
            $table->date('ingreso_salon')->nullable();
            $table->datetime('hora_ingreso_salon')->nullable();
            $table->datetime('hora_salida_salon')->nullable();
            $table->time('hora_ingreso')->nullable();
            $table->time('hora_salida')->nullable();
            $table->string('Codigosalon')->nullable();
            $table->string('ComentarioReserva')->nullable();
            $table->decimal('Precio_salon', 12, 2)->nullable();
            $table->decimal('PrecioRestante', 12, 2)->nullable();
            $table->decimal('Adelanto', 12, 2)->nullable();
            $table->decimal('Total', 12, 2)->nullable();
            $table->decimal('Totalsalon', 12, 2)->nullable();
            $table->decimal('TotalServicio', 12, 2)->nullable();
            $table->decimal('TotalConsumo', 12, 2)->nullable();
            $table->decimal('SubTotal', 12, 2)->nullable();
            $table->enum('Tarifa_salon', ['MEDIA', 'COMPLETA'])->default('COMPLETA');
            $table->enum('Estado', ['PENDIENTE', 'PROCESO', 'COMPLETO'])->default('PENDIENTE');
            $table->enum('EstadoReserva', ['false', 'true'])->default('false');
            $table->enum('Estadosalon', ['false', 'true'])->default('true');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('salones_id')->nullable();
            $table->foreign('salones_id')->references('id')->on('salones')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_reservas_id')->nullable();
            $table->foreign('cliente_reservas_id')->references('id')->on('cliente_reservas')->onDelete('cascade');
            $table->unsignedBigInteger('empresa_reservas_id')->nullable();
            $table->foreign('empresa_reservas_id')->references('id')->on('empresa_reservas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_salones');
    }
};
