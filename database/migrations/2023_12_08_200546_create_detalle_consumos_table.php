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
        Schema::create('detalle_consumos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_venta');
            $table->string('comentario')->nullable();
            $table->string('eliminado')->nullable();
            $table->string('comentarioeliminado')->nullable();
            $table->Integer('cantidad');
            $table->decimal('precio', 12, 2);
            $table->decimal('total', 12, 2);
            $table->unsignedBigInteger('consumo_id')->nullable();
            $table->foreign('consumo_id')->references('id')->on('consumos')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_consumos');
    }
};
