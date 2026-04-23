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
        Schema::create('cliente_hostals', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_cliente');
            $table->string('Apellido_cliente');
            $table->string('NombreCompleto_cliente')->nullable();
            $table->string('Documento_cliente');
            $table->string('Nacionalidad_cliente');
            $table->string('Profesion_cliente')->nullable();
            $table->string('FechaNacimiento_cliente')->nullable();
            $table->string('Edad_cliente');
            $table->string('EstadoCivil_cliente');
            $table->string('Celular_cliente')->nullable();
            $table->string('imagenes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_hostals');
    }
};
