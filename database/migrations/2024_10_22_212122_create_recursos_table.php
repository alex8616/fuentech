<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('nombre')->nullable();
            $table->string('estado')->nullable();
            $table->string('clasificacion')->nullable();
            $table->string('marca')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('color')->nullable();
            $table->longtext('imagen')->nullable();
            $table->unsignedBigInteger('categori_recursos_id')->nullable();
            $table->foreign('categori_recursos_id')->references('id')->on('categori_recursos')->onDelete('cascade')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};

    