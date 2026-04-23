<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AmbienteMesaFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'NombreMesas' => "cuadrado",
            'PosisionX' => $this->faker->numberBetween(1, 100),
            'PosisionY' => $this->faker->numberBetween(1, 100),
            'ambiente_id' => 1,
            'estado' => "libre",
        ];
    }
}
