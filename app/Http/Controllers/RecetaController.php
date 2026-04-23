<?php

namespace App\Http\Controllers;

use App\Models\DetalleReceta;
use App\Models\Producto;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecetaController extends Controller
{
    public function RegistrarReceta(Request $request){
        //return response()->json($request);
        $registro = Receta::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

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
