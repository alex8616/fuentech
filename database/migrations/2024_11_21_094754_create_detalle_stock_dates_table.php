<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void{
        Schema::create('detalle_stock_dates', function (Blueprint $table) {
            $table->id();
            $table->string('TipoStock')->nullable();
            $table->Integer('StockAnterior')->nullable();
            $table->Integer('StockActual')->nullable();
            $table->Integer('Diferencia')->nullable();
            $table->string('DetalleStock')->nullable();
            $table->string('FechaStock')->nullable();
            $table->string('EstadoStock')->nullable();
            $table->string('SolucionStock')->nullable();
            $table->string('FechaInicioSolucion')->nullable();
            $table->string('FechaFinSolucion')->nullable();
            $table->string('CantidadFaltante')->nullable();

            $table->enum('TipoServicio', ['Mesa','Mostrador','Delivery','Habitacion','Salon','ServicioPedido','Adonore','venta','Adquisicion Producto','Faltante','Sobrante'])->default('Adquisicion Producto');
            $table->string('IdTipoServicio')->nullable();

            $table->unsignedBigInteger('stock_dates_id')->nullable();
            $table->foreign('stock_dates_id')->references('id')->on('stock_dates')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('detalle_stock_dates');
    }
};
