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
        Schema::create('detalle_inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable();
            $table->string('cantidad')->nullable();
            $table->date('fecha')->nullable();
            $table->enum('tipo', ['salida', 'entrada'])->default('entrada')->nullable();
            $table->enum('estado', ['Buen Estado', 'Daniado', 'Desecho', 'Perdido'])->default('Buen Estado')->nullable();

            $table->unsignedBigInteger('inventarios_id')->nullable();
            $table->foreign('inventarios_id')->references('id')->on('inventarios')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_inventarios');
    }
};
