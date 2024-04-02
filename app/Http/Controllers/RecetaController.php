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
        $ingredientes = $request->ingredientes;
        return response()->json($ingredientes);
    
        foreach ($ingredientes as $ingrediente) {
            $producto = Producto::findOrFail($ingrediente['Id']);
    
            // Aquí puedes crear la receta y el detalle de receta para cada ingrediente
            $receta = Receta::create([
                'NombreReceta' => $producto->NombreProducto . ' ' . $ingrediente['nombreIngrediente'],
            ]);
    
            $detalleReceta = DetalleReceta::create([
                'fecha_registro' => now(),
                'cantidadneta' => $ingrediente['cantidadNeta'],
                'cantidadbruta' => $ingrediente['cantidadBruta'],
                'unidad' => $ingrediente['unidadNeta'],
                'receta_id' => $receta->id,
                'producto_id' => $ingrediente['Id'],
            ]);
        }
    
        return response()->json(['success' => true]);
    }
}
