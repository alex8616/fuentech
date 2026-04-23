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
        Schema::create('descuento_consumos', function (Blueprint $table) {
            $table->id();
            $table->string('TipoDescuento');
            $table->dateTime('FechaDescuento');
            $table->decimal('MontoDescuento', 12, 2);
            $table->decimal('TotalDescuento', 12, 2);
            $table->unsignedBigInteger('consumo_id')->nullable();
            $table->foreign('consumo_id')->references('id')->on('consumos')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuento_consumos');
    }
};
