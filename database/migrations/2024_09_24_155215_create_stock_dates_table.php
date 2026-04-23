<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('stock_dates', function (Blueprint $table) {
            $table->id();
            $table->Integer('Cantidad')->nullable();
            $table->Integer('StockMinimo')->nullable();            
            $table->string('NombreProducto')->nullable();

            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('ingrediente_id')->nullable();
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('consumo_id')->nullable();
            $table->foreign('consumo_id')->references('id')->on('consumos')->onDelete('cascade')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_dates');
    }
};
