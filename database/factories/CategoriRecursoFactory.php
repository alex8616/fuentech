<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriRecursoFactory extends Factory
{
    public function definition(): array
    {
        $enumValues = ['Hostal', 'Restaurante', 'Otros'];

        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->paragraph(2),
            'pertenece' => $this->faker->randomElement($enumValues), 
        ];
    }
}
