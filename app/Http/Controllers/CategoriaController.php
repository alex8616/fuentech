<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SubCategoria;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $registro = Categoria::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

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
        $registro = SubCategoria::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

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
        $categoria->mayordeedad = $request->input("mayordeedad");
        $categoria->promosionesdiarias = $request->input("promociondia");
        $categoria->cocina_id = $request->input("cocina_id");
        $categoria->save();
        return response()->json($categoria);
    }

    public function actualizarEstado(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        if($request->menuOnline == 'true'){
            $categoria->MenuOnline = 'true';
            $categoria->save();
        }else{
            $categoria->MenuOnline = 'false';
            $categoria->save();
        }
        return response()->json(['success' => true]);
    }

    public function GetPorCategoriaMenuOnline(){
        $fullmenu = Categoria::where('menuOnline', 'true')
            ->with([
                'productos' => function ($query) {
                    $query->where('FavoritoProducto', 'true');
                },
                'subcategorias' => function ($query) {
                    $query->where('MenuOnline', 'true');
                },
                'subcategorias.productos' => function ($query) {
                    $query->where('FavoritoProducto', 'true');
                },
            ])
            ->get();
    
        return response()->json($fullmenu);
    }
    

}
