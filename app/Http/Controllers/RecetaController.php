<?php

namespace App\Http\Controllers;

use App\Models\DetalleReceta;
use App\Models\Producto;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecetaController extends Controller
{
    public function RegistrarReceta(Request $request){
        $ingredientes = $request->input('ingredientes');
        $Id = $request->Id;
        $existeReceta = Receta::where('producto_id', $Id)->exists();

        if($existeReceta == true){
            $receta = Receta::where('producto_id', $Id)->first();
        }else{
            $producto = Producto::findOrFail($request->Id);
            $receta = Receta::create([
                'NombreReceta' => "Receta #1 ".$producto->NombreProducto,
                'producto_id' => $request->Id
            ]);
        }

        foreach ($ingredientes as $ingrediente) {
            $detalleReceta = DetalleReceta::create([
                'fecha_registro' => now(),
                'cantidadneta' => $ingrediente['cantidadNeta'],
                'cantidadbruta' => $ingrediente['cantidadBruta'],
                'unidad' => $ingrediente['unidadNeta'],
                'costo' => $ingrediente['costoIngrediente'],
                'receta_id' => $receta->id,
                'ingrediente_id' => $ingrediente['ingredienteId'],
            ]);
        }
        $productos = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente')->where('id',$request->Id)->first();
        return response()->json($productos);
    }
}
