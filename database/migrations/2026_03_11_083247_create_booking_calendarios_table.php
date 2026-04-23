<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_calendario', function (Blueprint $table) {

            $table->id();

            $table->date('fecha');

            $table->unsignedBigInteger('tipo_habitacion_id');

            $table->integer('total')->default(0);

            $table->integer('reservadas')->default(0);

            $table->integer('bloqueadas')->default(0);

            $table->decimal('precio',10,2)->nullable();

            $table->boolean('cerrado')->default(false);

            $table->integer('min_noches')->default(1);

            $table->timestamps();

            $table->unique(['fecha','tipo_habitacion_id']);

            $table->foreign('tipo_habitacion_id')
                ->references('id')
                ->on('tipo_habitacions')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_calendario');
    }
};