<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('detalle_gastos', function (Blueprint $table) {
            $table->id();
            $table->Integer('cantidad');
            $table->decimal('precio', 12, 2);
            $table->decimal('total', 12, 2);
            $table->string('stock');
            $table->enum('eliminado', ['true','false'])->default('false');
            $table->unsignedBigInteger('gasto_id')->nullable();
            $table->foreign('gasto_id')->references('id')->on('gastos')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_gastos');
    }
};
