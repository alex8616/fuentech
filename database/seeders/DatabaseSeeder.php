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
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sucursal = Empresa::create([
            'NombreEmpresa' => 'SUCURSAL #2',
            'LogoEmpresa' => 'DIRECCION DE LA SUCURSAL #2',
        ]);

        $adminUser = User::create([
            'name' => 'Alejandro Ventura Fuentes',
            'email' => 'ale@tukos.com',
            'password' => bcrypt('8616833ab'),
            'empresa_id' => 1,
        ]);

        $ambiente = Ambiente::create([
            'NombreAmbiente' => 'Piso #1',
            'DescripcionAmbiente' => 'Piso #1',
            'empresa_id' => 1,
        ]);

        $categoria = Categoria::create([
            'Nombre_categoria' => 'Categoria 1',
            'Estado' => 'true',
            'CartaQR' => 'true',
            'empresa_id' => 1,
        ]);

        $subcategoria = SubCategoria::create([
            'Nombre_subcategoria' => 'Sub Categoria 1',
            'categoria_id' => 1,
        ]);

        $proveedor = Proveedore::create([
            'name' => 'Alejandro ventura',
            'documento' => '8616833ab',
            'empresa_id' => 1,
        ]);

        $producto = Producto::create([
            'NombreProducto' => 'Hamburguesas xxx',
            'PrecioProducto' => 500,
            'CostoProducto' => 300,
            'CodigoProducto' => 'HHB-001',
            'EstadoProducto' => 'true',
            'DescripcionProducto' => 'Hamburguesas xxx',
            'proveedor_id' => 1,
            'categoria_id' => 1,
            'sub_categoria_id' => 1,
            'empresa_id' => 1,
        ]);

        $producto = Producto::create([
            'NombreProducto' => 'Alitas Picantes',
            'PrecioProducto' => 250,
            'CostoProducto' => 100,
            'CodigoProducto' => 'AAA-002',
            'EstadoProducto' => 'true',
            'DescripcionProducto' => 'Alitas Picantes',
            'proveedor_id' => 1,
            'categoria_id' => 1,
            'sub_categoria_id' => 1,
            'empresa_id' => 1,
        ]);
    }
}
