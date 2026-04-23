<?php

namespace App\Imports;

use App\Models\Ingrediente;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IngredientesImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            Ingrediente::create([
                'NombreIngrediente' => $row['nombreingrediente'],
                'UnidadIngrediente' => $row['unidadingrediente'],
                'CostoIngrediente' => $row['costoingrediente'],
                'CantidadIngrediente' => $row['cantidadingrediente'],
                'ControlStock' => $row['controlstock'],
                'proveedor_id' => $row['proveedor_id'],
                'categoria_ingrediente_id' => $row['categoria_ingrediente_id'],
            ]);
        }
    }
}
