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
        Schema::create('booking_reservas', function (Blueprint $table) {

            $table->id();

            $table->string('codigo_reserva')->unique();

            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();

            $table->date('fecha_ingreso');
            $table->date('fecha_salida');

            $table->integer('adultos');
            $table->integer('ninos')->default(0);

            $table->enum('estado',[
                'pendiente',
                'confirmada',
                'cancelada'
            ])->default('pendiente');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_reservas');
    }
};
