<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('hospedaje_habitacions', function (Blueprint $table) {
            $table->id();
            $table->datetime('ingreso_hospedaje')->nullable();
            $table->time('hora_ingreso_hospedaje')->nullable();
            $table->datetime('salida_hospedaje')->nullable();
            $table->string('procedencia_hospedaje')->nullable();
            $table->string('CodigoHospedaje')->nullable();
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
            $table->string('CategoriaHabitacion')->nullable();
            $table->string('CamaraHotelera')->nullable();
            $table->enum('EstadoReserva', ['false', 'true'])->default('false');
            $table->enum('EstadoHospedaje', ['false', 'true'])->default('true');
            $table->enum('EstadoHospedajeGrupo', ['false', 'true'])->default('false');
            $table->enum('Reserva', ['false', 'true'])->default('false');
            $table->enum('GuiaTuristica', ['false', 'true'])->default('false');
            $table->enum('CortesiaHabitacion', ['false', 'true'])->default('false');
            $table->enum('TipoPago', ['Efectivo', 'Tarjeta', 'Deposito/QR'])->default('Efectivo');

            $table->enum('HospedajeDeuda', ['No', 'Si'])->default('No');
            $table->enum('HospedajePendiente', ['true', 'false'])->default('false');
            $table->datetime('FechaDeudaConcluida')->nullable();            

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('habitacion_id')->nullable();
            $table->foreign('habitacion_id')->references('id')->on('habitacions')->onDelete('cascade');
            $table->unsignedBigInteger('grupo_hospedajes_id')->nullable();
            $table->foreign('grupo_hospedajes_id')->references('id')->on('grupo_hospedajes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospedaje_habitacions');
    }
};
