<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_Completo');
            $table->string('Dni');
            $table->string('Cargo');
            $table->enum('Tiempo', ['COMPLETO', 'MEDIO'])->default('MEDIO');
            $table->enum('estado', ['true', 'false'])->default('true');
            $table->string('Pin')->nullable();
            $table->longtext('imagen')->nullable();
            $table->longtext('descriptores');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
