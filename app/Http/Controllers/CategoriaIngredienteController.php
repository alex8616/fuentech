<?php

namespace App\Http\Controllers;

use App\Models\CategoriaIngrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaIngredienteController extends Controller
{
    public function GetCategoriaIngrediente(){
        $categorias = CategoriaIngrediente::withCount('ingredientes')->get();
    
        return response()->json($categorias);
    }

    public function GetCategoriaSeleccionado($id){
        $categorias = CategoriaIngrediente::where('id',$id)->first();
        return response()->json($categorias);
    }

    public function RegistrarCategoria(Request $request){
        $user = Auth::user(); 
        $categoria = CategoriaIngrediente::create([
            'NombreCategoria' => $request->Nombre,
        ]);
        return response()->json($categoria);
    }

    public function ActualizarCategoria(Request $request){
        $categoria = CategoriaIngrediente::where('id',$request->id)->first();
        $categoria->NombreCategoria = $request->input("nombre");
        $categoria->save();
        return response()->json($categoria);
    }
}
