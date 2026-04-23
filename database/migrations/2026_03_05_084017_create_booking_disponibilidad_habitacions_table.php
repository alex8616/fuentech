<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_disponibilidad_habitaciones', function (Blueprint $table) {

            $table->id();

            $table->date('fecha');

            $table->unsignedBigInteger('tipo_habitacion_id')->nullable();

            $table->integer('total')->default(0);

            $table->integer('reservadas')->default(0);

            $table->integer('bloqueadas')->default(0);

            $table->timestamps();

            // índice único
            $table->unique(['fecha','tipo_habitacion_id'], 'booking_disp_unique');

            // clave foránea
            $table->foreign('tipo_habitacion_id')
                ->references('id')
                ->on('tipo_habitacions')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_disponibilidad_habitaciones');
    }
};