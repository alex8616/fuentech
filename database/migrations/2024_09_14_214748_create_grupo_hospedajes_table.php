<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupo_hospedajes', function (Blueprint $table) {
            $table->id();
            $table->string('TourName')->nullable();
            $table->string('CodigoHospedaje')->nullable();
            $table->string('CantidadPersonas')->nullable();
            $table->string('Comentario')->nullable();
            $table->datetime('ingreso_hospedaje')->nullable();
            $table->time('hora_ingreso_hospedaje')->nullable();
            $table->datetime('salida_hospedaje')->nullable();
            $table->string('procedencia_hospedaje')->nullable();
            $table->string('destino_hospedaje')->nullable();
            $table->string('dias_hospedarse')->nullable();
            $table->decimal('Precio_habitacion', 12, 2)->nullable();
            $table->decimal('PrecioRestante', 12, 2)->nullable();
            $table->decimal('Adelanto', 12, 2)->nullable();
            $table->decimal('Total', 12, 2)->nullable();
            $table->decimal('CambioBolivianos', 12, 2)->nullable();
            $table->decimal('CambioDolar', 12, 2)->nullable();
            $table->decimal('TotalHospedaje', 12, 2)->nullable();
            $table->decimal('TotalServicio', 12, 2)->nullable();
            $table->decimal('TotalConsumo', 12, 2)->nullable();
            $table->decimal('SubTotal', 12, 2)->nullable();
            $table->enum('Estado', ['false', 'true'])->default('false');
            $table->enum('Concluido', ['NO', 'SI'])->default('NO');
            $table->enum('EstadoGrupo', ['PENDIENTE', 'EN ESPERA', 'CONCLUIDO'])->default('PENDIENTE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_hospedajes');
    }
};
