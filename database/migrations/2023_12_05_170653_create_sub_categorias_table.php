<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void{
        Schema::create('sub_categorias', function (Blueprint $table) {
            $table->id();

            $table->string('Nombre_subcategoria');
            $table->string('Estado')->nullable();
            $table->string('AppComensal')->nullable();
            $table->string('MenuOnline')->nullable();
            $table->string('CartaQR')->nullable();
            $table->unsignedBigInteger('cocina_id')->nullable();
            $table->foreign('cocina_id')->references('id')->on('cocinas')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('sub_categorias');
    }
};
