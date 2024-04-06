<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('modificadores', function (Blueprint $table) {
            $table->id();
            $table->string('NombreModificador')->nullable();
            $table->string('NombrePublicoModificador')->nullable();
            $table->string('LogicaPrecioModificador')->nullable();
            $table->integer('CantidadMinimaModificador')->nullable();
            $table->integer('CantidadMaximaModificador')->nullable();

            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modificadores');
    }
};
