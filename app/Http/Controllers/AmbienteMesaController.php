<?php

namespace App\Http\Controllers;

use App\Models\AmbienteMesa;
use Illuminate\Http\Request;

class AmbienteMesaController extends Controller
{
    public function registrarMesa(Request $request){
        
        $mesa = AmbienteMesa::create([
            'NombreMesas' => $request->NombreMesas,
            'PosisionX' => $request->PosisionX,
            'PosisionY' => $request->PosisionY,
            'ambiente_id' => $request->ambienteId,
        ]);
        return response()->json($mesa);
    }

    public function GetMesaSeleccionado($mesa){
        $mesaselect = AmbienteMesa::where('id',$mesa)->get();
        return response()->json($mesaselect);
    }

    public function actualizarPosicion(Request $request){
        $mesaId = $request->input('mesaId');
        $nuevaPosX = $request->input('nuevaPosX');
        $nuevaPosY = $request->input('nuevaPosY');

        AmbienteMesa::where('id', $mesaId)->update([
            'PosisionX' => $nuevaPosX,
            'PosisionY' => $nuevaPosY,
        ]);

        return response()->json(['message' => 'Posición de la mesa actualizada con éxito']);
    }
 
}
