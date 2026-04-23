<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePersonalsTable extends Migration
{

    public function up()
    {
        Schema::create('detalle_personals', function (Blueprint $table) {
            $table->id();
            
            $table->string('estado');
            $table->dateTime('fecha_ingreso')->nullable();
            $table->dateTime('hora_ingreso')->nullable();
            $table->dateTime('fecha_salida')->nullable();
            $table->dateTime('hora_salida')->nullable(); 
            $table->enum('HoraExtra', ['true', 'false'])->default('false');
            $table->string('RazonHoraExtra')->nullable();
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_personals');
    }
}
