<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    
    public function definition(): array
    {
        $enumValues = ['true', 'false'];

        return [
            'NombreProducto' => $this->faker->word,
            'PrecioProducto' => $this->faker->randomFloat(2, 10, 500),
            'CostoProducto' => $this->faker->randomFloat(2, 10, 500),
            'CodigoProducto' => $this->faker->word,
            'EstadoProducto' => $this->faker->boolean,
            'DescripcionProducto' => $this->faker->word,
            'ControlStock' => $this->faker->boolean,
            'FavoritoProducto' => $this->faker->randomElement($enumValues),
            'MenuOnlineProducto' => $this->faker->randomElement($enumValues),
            'ImagenProducto' => $this->faker->word,
            'CantidadStock' => $this->faker->numberBetween(1, 100),
            'ComentarioStock' => $this->faker->word,
            'MinimoStock' => $this->faker->numberBetween(1, 100),
            'proveedor_id' => $this->faker->numberBetween(1, 1),
            'categoria_id' => 1,
            'empresa_id' => 1,
        ];
    }
}
