<?php

namespace App\Imports;

use App\Models\Producto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            Producto::create([
                'NombreProducto' => $row['nombreproducto'],
                'PrecioProducto' => $row['precioproducto'],
                'CostoProducto' => $row['costoproducto'],
                'CodigoProducto' => $row['codigoproducto'],
                'EstadoProducto' => $row['estadoproducto'],
                'DescripcionProducto' => $row['descripcionproducto'],
                'ControlStock' => $row['controlstock'],
                'MenuOnlineProducto' => $row['menuonlineproducto'],
                'ImagenProducto' => $row['imagenproducto'],
                'CantidadStock' => $row['cantidadstock'],
                'ComentarioStock' => $row['comentariostock'],
                'MinimoStock' => $row['minimostock'],
                'FavoritoProducto' => $row['favoritoproducto'],
                'modificadore_id' => $row['modificadore_id'],
                'proveedor_id' => $row['proveedor_id'],
                'categoria_id' => $row['categoria_id'],
                'sub_categoria_id' => $row['sub_categoria_id'],
                'empresa_id' => $row['empresa_id'],
            ]);
        }
    }
}
