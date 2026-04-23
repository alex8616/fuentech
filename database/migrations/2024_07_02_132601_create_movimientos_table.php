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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('monto', 12, 2);
            $table->enum('estado', ['Abierto', 'Cerrado'])->default('Abierto');
            $table->enum('eliminado', ['true', 'false'])->default('false');
            $table->string('mediopago')->nullable();
            $table->string('tipo')->nullable();
            $table->string('Comentario')->nullable();
            $table->dateTime('fecharegistro')->nullable();
            $table->dateTime('FechaCierre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
