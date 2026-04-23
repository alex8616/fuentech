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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('Problema')->nullable();
            $table->string('Solucion')->nullable();
            $table->datetime('InicioProblema')->nullable();
            $table->datetime('FinalProblema')->nullable();
            $table->string('TiempoSolucion')->nullable();
            $table->enum('EstadoSolucion', ['false', 'true'])->default('false');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('habitacion_id')->nullable();
            $table->foreign('habitacion_id')->references('id')->on('habitacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
