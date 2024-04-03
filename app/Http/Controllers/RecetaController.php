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
                'receta_id' => $receta->id,
                'ingrediente_id' => $ingrediente['ingredienteId'],
            ]);
        }
    
        return response()->json(['success' => true]);
    }
}
