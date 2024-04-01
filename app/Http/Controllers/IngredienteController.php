<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngredienteController extends Controller
{
    public function GetIngredienteCategoria($categoria){
        $ingredientes = Ingrediente::where('categoria_ingrediente_id',$categoria)->get();
        return response()->json($ingredientes);
    }

    public function GeIngredienteSeleccionado($ingrediente){
        $ingredientes = Ingrediente::where('id',$ingrediente)->with(['proveedor','categoriaingrediente'])->first();
        return response()->json($ingredientes);
    }

    public function ActualizarIngrediente(Request $request){
        $ingrediente = Ingrediente::with('categoriaingrediente','proveedor')->where('id',$request->id)->first();
        $ingrediente->NombreIngrediente = $request->input("nombre");
        $ingrediente->UnidadIngrediente = $request->input("unidad");
        $ingrediente->CostoIngrediente = $request->input("costo");
        $ingrediente->CantidadIngrediente = $request->input("merma");
        $ingrediente->ControlStock = $request->input("controlStock");
        $ingrediente->proveedor_id = $request->input("proveedor");
        $ingrediente->categoria_ingrediente_id = $request->input("categoria");
        $ingrediente->save();
        return response()->json($ingrediente);
    }

    public function RegistrarIngrediente(Request $request){
        $user = Auth::user(); 
    
        // Crear el producto
        $ingrediente = Ingrediente::create([
            'NombreIngrediente' => $request->Nombre,
            'UnidadIngrediente' => $request->Unidad,
            'CostoIngrediente' => $request->Costo,
            'CantidadIngrediente' => $request->Merma,
            'ControlStock' => $request->controlStock,
            'proveedor_id' => $request->proveedor,
            'categoria_ingrediente_id' => $request->Categoria,
        ]);
            
        return response()->json($ingrediente);
    }
}
