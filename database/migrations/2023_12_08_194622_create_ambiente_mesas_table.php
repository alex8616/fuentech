<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void{
        Schema::create('ambiente_mesas', function (Blueprint $table) {
            $table->id();
            $table->string('NombreMesas');
            $table->string('PosisionX');
            $table->string('PosisionY');
            $table->enum('estado', ['ocupado', 'libre'])->default('libre');
            $table->unsignedBigInteger('ambiente_id')->nullable();
            $table->foreign('ambiente_id')->references('id')->on('ambientes')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('ambiente_mesas');
    }
};
