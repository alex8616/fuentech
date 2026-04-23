<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre')->nullable();
            $table->time('Inicio')->nullable();
            $table->time('Fin')->nullable();
            $table->dateTime('Fecha');
            $table->enum('Estado', ['true','false'])->default('false');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
