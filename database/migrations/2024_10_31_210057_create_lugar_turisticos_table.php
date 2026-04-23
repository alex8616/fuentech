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
        Schema::create('lugar_turisticos', function (Blueprint $table) {
            $table->id();
            $table->string('NombreLugar')->nullable();
            $table->string('UbicacionLugar')->nullable();
            $table->longtext('Detalle')->nullable();
            $table->enum('Estado', ['true', 'false'])->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lugar_turisticos');
    }
};
