<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteHostalFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'Nombre_cliente' => $this->faker->word,
            'Apellido_cliente' => $this->faker->word,
            'NombreCompleto_cliente' => $this->faker->word,
            'Documento_cliente' => $this->faker->word,
            'Nacionalidad_cliente' => $this->faker->word,
            'Profesion_cliente' => $this->faker->word,
            'FechaNacimiento_cliente' => $this->faker->word,
            'Edad_cliente' => $this->faker->word,
            'EstadoCivil_cliente' => $this->faker->word,
            'Celular_cliente' => $this->faker->word,
        ];
    }
}
