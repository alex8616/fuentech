<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DetalleConsumoFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'fecha_venta' => $fechaVenta = $this->faker->dateTimeBetween('-1 year', 'now'),
            'comentario' => $this->faker->sentence,
            'cantidad' => $this->faker->numberBetween(1, 10),
            'precio' => $this->faker->randomFloat(2, 20, 150),
            'total' => $this->faker->randomFloat(2, 20, 1000),
            'consumo_id' => $this->faker->numberBetween(1, 1500),
            'producto_id' => $this->faker->numberBetween(1, 70),
            'eliminado' => "false",
            'comentarioeliminado' => NULL,
        ];
    }
}
