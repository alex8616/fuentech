<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void{
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('NombreProducto')->nullable();
            $table->decimal('PrecioProducto',10,2)->nullable();
            $table->decimal('CostoProducto',10,2)->nullable();
            $table->string('CodigoProducto')->nullable();
            $table->string('EstadoProducto')->nullable();
            $table->string('DescripcionProducto')->nullable();
            $table->string('ControlStock')->nullable();
            $table->enum('MenuOnlineProducto', ['true', 'false'])->default('false');
            $table->string('ImagenProducto')->nullable();

            $table->enum('FavoritoProducto', ['true', 'false'])->default('false')->nullable();

            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('sub_categoria_id')->nullable();
            $table->foreign('sub_categoria_id')->references('id')->on('sub_categorias')->onDelete('cascade')->nullable();

            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('productos');
    }
};
