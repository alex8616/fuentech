<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConsumoFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'CantidadPersonas' => $this->faker->numberBetween(1, 10),
            'empresa_id' => 1,
            'user_id' => 1,
            'cliente_id' => NULL,
            'cliente_temporal_id' => null,
            'camarero_id' => NULL,
            'ambiente_mesa_id' => $this->faker->numberBetween(1, 70),
            'fecha_venta' => $fechaVenta = $this->faker->dateTimeBetween('-1 year', 'now'),
            'subTotal' => $this->faker->randomFloat(2, 10, 500),
            'total' => $this->faker->randomFloat(2, 20, 1000),
            'Comentario' => $this->faker->sentence,
            'ocupado' => "false",
            'TipoConsumo' => "Mesa",
            'FechaCierre' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'repartidor_id' => NULL, 
            'EstadoDelivery' => "Preparacion",
            'DeliveryComentario' => NULL,
            'DeliveryCosto' => NULL,
            'DeliveryTiempo' => NULL,
            'created_at' => $fechaVenta,
            'updated_at' => $fechaVenta,
        ];
    }
}
