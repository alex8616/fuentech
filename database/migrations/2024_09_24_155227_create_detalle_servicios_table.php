<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('detalle_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('TipoServicio')->nullable();
            $table->dateTime('fecha_venta');
            $table->dateTime('fecha_cierre')->nullable();
            $table->string('comentario')->nullable();
            $table->string('eliminado')->nullable();
            $table->string('comentarioeliminado')->nullable();
            $table->Integer('cantidad');
            $table->decimal('precio', 12, 2);
            $table->decimal('total', 12, 2);
            $table->enum('lavado', ['Entregado', 'No Entregado'])->default('No Entregado');
            $table->enum('estado', ['true', 'false'])->default('false');
            $table->enum('pagado', ['true', 'false'])->default('false');
            $table->string('tipopago')->nullable();
            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_servicios');
    }
};
