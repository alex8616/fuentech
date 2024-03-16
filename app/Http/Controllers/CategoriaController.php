<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SubCategoria;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function GetCategoria(){
        $categorias = Categoria::with(['subcategorias.cocina', 'cocina'])
                        ->withCount('productos')
                        ->get();
    
        return response()->json($categorias);
    }

    public function GetCategoriaSeleccionado($id){
        $categorias = Categoria::where('id',$id)->with(['subcategorias','cocina'] )->first();
        return response()->json($categorias);
    }

    public function GetSubCategoriaSeleccionado($id){
        $subcategorias = SubCategoria::where('id',$id)->with(['categoria','cocina'] )->first();
        return response()->json($subcategorias);
    }

    public function GetSubCategoria($id){
        $subcategorias = SubCategoria::where('categoria_id',$id)->get();
        return response()->json($subcategorias);
    }

    public function RegistrarCategoria(Request $request){
        $user = Auth::user(); 
        $categoria = Categoria::create([
            'Nombre_categoria' => $request->Nombre,
            'Estado' => "true",
            'AppComensal' => $request->AppComensal,
            'MenuOnline' => $request->MenuOnline,
            'CartaQR' => $request->CartaQR,
            'cocina_id' => $request->Cocina,
            'empresa_id' => $user->empresa_id,
        ]);
        return response()->json($categoria);
    }

    public function RegistrarSubCategoria(Request $request){
        $user = Auth::user(); 
        $subcategoria = SubCategoria::create([
            'Nombre_subcategoria' => $request->Nombre,
            'Estado' => true,
            'AppComensal' => $request->AppComensal,
            'MenuOnline' => $request->MenuOnline,
            'CartaQR' => $request->CartaQR,
            'cocina_id' => $request->Cocina,
            'categoria_id' => $request->Categoria,
        ]);
        return response()->json($subcategoria);
    }

    public function ActualizarCategoria(Request $request){
        $categoria = Categoria::where('id',$request->id)->first();
        $categoria->Nombre_categoria = $request->input("nombre");
        $categoria->AppComensal = $request->input("appcomensal");
        $categoria->MenuOnline = $request->input("menuonline");
        $categoria->CartaQR = $request->input("cartaqr");
        $categoria->cocina_id = $request->input("cocina_id");
        $categoria->save();
        return response()->json($categoria);
    }
}
