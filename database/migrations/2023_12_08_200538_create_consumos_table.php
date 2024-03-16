<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void{
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->string('CantidadPersonas');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('cliente_temporal_id')->nullable();
            $table->foreign('cliente_temporal_id')->references('id')->on('cliente_temporals')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('camarero_id')->nullable();
            $table->foreign('camarero_id')->references('id')->on('camareros')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('repartidor_id')->nullable();
            $table->foreign('repartidor_id')->references('id')->on('repartidores')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('ambiente_mesa_id')->nullable();
            $table->foreign('ambiente_mesa_id')->references('id')->on('ambiente_mesas')->onDelete('cascade')->nullable();
            $table->dateTime('fecha_venta')->nullable();
            $table->decimal('subTotal', 12, 2);
            $table->decimal('total', 12, 2);
            $table->string('Comentario')->nullable();
            $table->enum('ocupado', ['true', 'false'])->default('false');
            $table->enum('TipoConsumo', ['Mesa','Mostrador','Delivery'])->default('Mesa');
            $table->enum('EstadoDelivery', ['Preparacion','Entregar','Enviado','Completo'])->default('Preparacion')->nullable();
            $table->dateTime('FechaCierre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('consumos');
    }
};
