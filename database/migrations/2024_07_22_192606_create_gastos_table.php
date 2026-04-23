<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('FechaRegistro');
            $table->string('Importe');
            $table->string('MedioDePago');
            $table->string('TipoConprobante');
            $table->string('NumeroComprobante');
            $table->string('UsarArqueo');
            $table->string('Comentario');
            $table->enum('eliminado', ['true', 'false'])->default('false');

            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('categoria_gasto_id')->nullable();
            $table->foreign('categoria_gasto_id')->references('id')->on('categoria_gastos')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
