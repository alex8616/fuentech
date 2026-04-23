<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('autos', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable();
            $table->string('placa')->unique();
            $table->string('marca')->nullable();
            $table->string('comentario')->nullable();
            $table->unsignedBigInteger('hospedaje_habitacion_id')->nullable();
            $table->foreign('hospedaje_habitacion_id')->references('id')->on('hospedaje_habitacions')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autos');
    }
};
