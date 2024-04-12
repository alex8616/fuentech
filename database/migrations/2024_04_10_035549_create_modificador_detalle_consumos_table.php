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
        Schema::create('modificador_detalle_consumos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_venta');
            $table->string('comentario')->nullable();
            $table->string('eliminado')->nullable();
            $table->string('comentarioeliminado')->nullable();
            $table->Integer('cantidad');
            $table->decimal('precio', 12, 2);
            $table->decimal('total', 12, 2);

            $table->unsignedBigInteger('detalle_modificadore_id')->nullable();
            $table->foreign('detalle_modificadore_id')->references('id')->on('detalle_modificadores')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('detalle_consumo_id')->nullable();
            $table->foreign('detalle_consumo_id')->references('id')->on('detalle_consumos')->onDelete('cascade')->nullable();
            $table->timestamps();
        }); 
    }

    public function down(): void
    {
        Schema::dropIfExists('modificador_detalle_consumos');
    }
};
