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
        Schema::create('detalle_reserva_salones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserva_salones_id')->nullable();
            $table->foreign('reserva_salones_id')->references('id')->on('reserva_salones')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_reserva_salones');
    }
};
