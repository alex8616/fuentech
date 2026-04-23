<?php

namespace App\Http\Controllers;

use App\Models\AmbienteMesa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AmbienteMesaController extends Controller
{
    public function registrarMesa(Request $request){
        $registro = AmbienteMesa::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

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
 
    public function actualizarNombreMesa(Request $request){
        $request->validate([
            'mesaId' => 'required|integer|exists:ambiente_mesas,id',
            'mesaName' => 'required|string|max:255',
        ]);
    
        try {
            $mesa = AmbienteMesa::findOrFail($request->input('mesaId'));
            $mesa->Name = $request->input('mesaName');
            $mesa->save();
    
            return response()->json(['message' => 'Nombre de la mesa actualizado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al actualizar el nombre de la mesa'], 500);
        }
    }
}
