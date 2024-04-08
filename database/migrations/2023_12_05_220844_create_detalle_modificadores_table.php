<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('detalle_modificadores', function (Blueprint $table) {
            $table->id();
            $table->integer('CostoDetalleModificador')->nullable();
            $table->integer('MaximoDetalleModificador')->nullable();

            $table->unsignedBigInteger('modificadore_id')->nullable();
            $table->foreign('modificadore_id')->references('id')->on('modificadores')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_modificadores');
    }
};
