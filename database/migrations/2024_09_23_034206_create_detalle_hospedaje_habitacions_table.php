<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('detalle_hospedaje_habitacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospedaje_habitacion_id');
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('cliente_hostals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_hospedaje_habitacions');
    }
};
