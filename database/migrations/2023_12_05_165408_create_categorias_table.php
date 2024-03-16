<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_categoria');
            $table->string('Estado')->nullable();
            $table->string('AppComensal')->nullable();
            $table->string('MenuOnline')->nullable();
            $table->string('CartaQR')->nullable();
            $table->unsignedBigInteger('cocina_id')->nullable();
            $table->foreign('cocina_id')->references('id')->on('cocinas')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
