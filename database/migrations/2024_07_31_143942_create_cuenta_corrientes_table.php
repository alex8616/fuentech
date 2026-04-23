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
        Schema::create('cuenta_corrientes', function (Blueprint $table) {
            $table->id();
            $table->string('Tipo')->nullable();
            $table->string('Monto')->nullable();
            $table->string('MedioDePago')->nullable();
            $table->string('Comentario')->nullable();
            $table->string('Eliminado')->default("false");
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_corrientes');
    }
};
