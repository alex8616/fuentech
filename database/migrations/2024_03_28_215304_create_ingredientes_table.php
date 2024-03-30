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
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id();
            $table->string('NombreIngrediente')->nullable();
            $table->string('UnidadIngrediente')->nullable();
            $table->string('CostoIngrediente')->nullable();
            $table->string('CantidadIngrediente')->nullable();
            $table->string('ControlStock')->nullable();

            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('categoria_ingrediente_id')->nullable();
            $table->foreign('categoria_ingrediente_id')->references('id')->on('categoria_ingredientes')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredientes');
    }
};
