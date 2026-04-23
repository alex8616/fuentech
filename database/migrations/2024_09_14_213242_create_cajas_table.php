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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade')->nullable();
            
            $table->dateTime('fecha_registro');

            $table->decimal('caja_hostal_ingreso', 12, 2);

            $table->decimal('caja_hostal_egreso', 12, 2);

            $table->decimal('caja_restaurante_ingreso', 12, 2);

            $table->decimal('caja_restaurante_egreso', 12, 2);
            
            $table->decimal('caja_tarjetas_ingreso', 12, 2);

            $table->decimal('caja_depositos_ingreso', 12, 2);

            $table->decimal('caja_dolars_ingreso', 12, 2);
            
            $table->decimal('total', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
