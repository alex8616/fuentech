<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecursoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->paragraph(2),
            'precio' => $this->faker->randomFloat(2, 10, 500),
            'categori_recursos_id' => $this->faker->numberBetween(1, 50),
        ];
    }
}
