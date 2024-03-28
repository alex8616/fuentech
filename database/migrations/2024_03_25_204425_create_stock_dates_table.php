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
            $table->Integer('StockAnterior')->nullable();
            $table->Integer('StockActual')->nullable();
            $table->Integer('Diferencia')->nullable();
            $table->string('TipoStock')->nullable();
            $table->string('DetalleStock')->nullable();
            $table->string('NombreProducto')->nullable();
            $table->string('FechaStock')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_dates');
    }
};
