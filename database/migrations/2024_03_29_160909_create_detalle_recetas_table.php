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
        Schema::create('detalle_recetas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_registro');
            $table->string('cantidadneta')->nullable();
            $table->string('cantidadbruta')->nullable();
            $table->string('unidad')->nullable();

            $table->unsignedBigInteger('receta_id')->nullable();
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_recetas');
    }
};
