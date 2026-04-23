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
        Schema::create('cuenta_corriente_proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('Tipo')->nullable();
            $table->string('Monto')->nullable();
            $table->string('MedioDePago')->nullable();
            $table->string('Comentario')->nullable();
            $table->string('Eliminado')->default("false");
            $table->string('Arqueo')->default("false");
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuenta_corriente_proveedors');
    }
};
