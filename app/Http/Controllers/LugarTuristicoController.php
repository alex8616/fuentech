<?php

namespace App\Http\Controllers;

use App\Models\LugarTuristico;
use Illuminate\Http\Request;

class LugarTuristicoController extends Controller
{
    public function GetLugares(){
        $lugares = LugarTuristico::where('Estado', 'true')->get();        
        return response()->json($lugares);
    }

    public function RegistrarLugaresTuristicos(Request $request){
        $lugar = LugarTuristico::create([
            'NombreLugar' => $request->Nombre_Lugar,
            'Detalle' => $request->contenidoEditor,
            'Estado' => "true",
            'UbicacionLugar' => $request->Coordenadas_Lugar,
        ]);

        return response()->json($lugar);
    }

    public function GetFullLugares(){
        $lugares = LugarTuristico::get();        
        return response()->json($lugares);
    }

    public function GetSeleccionadoLugares($id){
        $lugares = LugarTuristico::where('id',$id)->get();        
        return response()->json($lugares);
    }

    public function ActualizarLugaresTuristicos(Request $request){
        $lugar = LugarTuristico::where('id',$request->id)->first();
        $lugar->NombreLugar = $request->Nombre_Lugar_update;
        $lugar->Detalle = $request->contenidoEditor;
        $lugar->Estado = $request->Estado_Lugar_update;
        $lugar->UbicacionLugar = $request->Coordenadas_Lugar_update;
        $lugar->save();

        return response()->json($lugar);
    }
}
