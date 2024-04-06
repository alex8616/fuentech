<?php

namespace App\Http\Controllers;

use App\Models\Modificadore;
use Illuminate\Http\Request;

class ModificadoreController extends Controller
{
    public function RegistrarModificadore(Request $request){
        $modificador = Modificadore::create([
            'NombreModificador' => $request->Nombre,
            'NombrePublicoModificador' => $request->NombrePublic,
            'LogicaPrecioModificador' => $request->Logica,
            'CantidadMinimaModificador' => $request->CantMin,
            'CantidadMaximaModificador' => $request->CantMax,
        ]);
        return response()->json($modificador);
    }

    public function GetModificadores(){
        $modificador = Modificadore::withCount('detallemodificador')->with(['detallemodificador.producto'])->get();
        return response()->json($modificador);
    }

    public function GetModificadorSeleccionado($modificador){
        $modificador = Modificadore::findOrFail($modificador);   
        return response()->json($modificador);
    }

    public function ActualizarModificador(Request $request){
        $modificador = Modificadore::where('id',$request->id)->first();
        $modificador->NombreModificador = $request->input("nombre");
        $modificador->NombrePublicoModificador = $request->input("nombrepublic");
        $modificador->LogicaPrecioModificador = $request->input("logica");
        $modificador->CantidadMinimaModificador = $request->input("cantmin");
        $modificador->CantidadMaximaModificador = $request->input("cantmax");
        $modificador->save();
        return response()->json($modificador);
    }
}
