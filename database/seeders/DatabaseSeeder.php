<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ambiente;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\SubCategoria;
use App\Models\User;
use App\Models\AmbienteMesa;
use App\Models\Consumo;
use App\Models\DetalleConsumo;
use App\Models\Turno;
use App\Models\CodigoCaja;
use App\Models\ArticuloCaja;
use App\Models\Caja;
use App\Models\Habitacion;
use App\Models\ClienteHostal;
use App\Models\CategoriRecurso;
use App\Models\Recurso;
use App\Models\Salones;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        
        $sucursal = Empresa::create([
            'NombreEmpresa' => 'Tukos La Casa Real Bar',
            'LogoEmpresa' => 'Calle hoyos #29 frente a la facultad de medicina',
        ]);

        $adminUser = User::create([
            'name' => 'Alejandro Ventura Fuentes',
            'email' => 'ale@tukos.com',
            'password' => bcrypt('8616833ab'),
            'pin' => '1234',
            'empresa_id' => 1,
        ]);

        $codigo = CodigoCaja::create([
            'Nombre' => 'Hostal',
        ]);

        $codigo = CodigoCaja::create([
            'Nombre' => 'Restaurante',
        ]);

        $codigo = CodigoCaja::create([
            'Nombre' => 'Tarjeta',
        ]);

        $codigo = CodigoCaja::create([
            'Nombre' => 'Deposito/QR',
        ]);
        
        $codigo = CodigoCaja::create([
            'Nombre' => 'Dolar',
        ]);


        $caja = Caja::create([
            'user_id' => '1',
            'empresa_id' => '1',
            'fecha_registro' => '2025-01-01 00:00:00',
            'caja_hostal_ingreso' => 0.00,
            'caja_hostal_egreso' => 0.00,
            'caja_restaurante_ingreso' => 0.00,
            'caja_restaurante_egreso' => 0.00,
            'caja_tarjetas_ingreso' => 0.00,
            'caja_depositos_ingreso' => 0.00,
            'caja_dolars_ingreso' => 0.00,
            'total' => 0.00,
        ]);

        $turno = Turno::create([
            'Nombre' => 'Completo',
            'Inicio' => '00:00:00',
            'Fin' => '00:00:00',
            'Fecha' => '2024-09-01 00:00:00',
            'Estado' => 'true',
        ]);

    }
}
