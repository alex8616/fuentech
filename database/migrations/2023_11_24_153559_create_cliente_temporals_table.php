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
        Schema::create('cliente_temporals', function (Blueprint $table) {
            $table->id();
            $table->string('NombreCliente');
            $table->string('EmailCliente')->nullable();
            $table->string('TelefonoCliente')->nullable();
            $table->string('CalleCliente')->nullable();
            $table->string('NumeroCliente')->nullable();
            $table->string('PisoCliente')->nullable();
            $table->string('BarrioCliente')->nullable();
            $table->string('Comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_temporals');
    }
};
