<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function GetIngredienteCategoria($categoria){
        $ingredientes = Ingrediente::where('categoria_ingrediente_id',$categoria)->get();
        return response()->json($ingredientes);
    }
}
