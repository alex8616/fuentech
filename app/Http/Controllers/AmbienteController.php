<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AmbienteController extends Controller
{
    
    public function GetAmbiente()
    {
        $ambientes = Ambiente::get();
        return response()->json($ambientes);
    }

    public function GetAmbienteSeleccionado($ambiente){
        $ambiente = Ambiente::with('ambientemesas')->where('id',$ambiente)->get();
        return response()->json($ambiente);
    }

    public function Ambientes(){
        return view('admin.ambiente.ambientes');
    }

    public function RegistrarAmbiente(Request $request){
        $user = Auth::user(); 
        $ambiente = Ambiente::create([
            'NombreAmbiente' => $request->NombreAmbiente,
            'DescripcionAmbiente' => $request->DescripcionAmbiente,
            'empresa_id' => $user->empresa_id,
        ]);

        return response()->json($ambiente);
    }

    public function ActualizarAmbiente(Request $request){
        $ambiente = Ambiente::where('id', $request->id)->first();
        $ambiente->NombreAmbiente = $request->UpdateNombreAmbiente;
        $ambiente->DescripcionAmbiente = $request->UpdateDescripcionAmbiente;
        $ambiente->save();

        return response()->json($ambiente);
    }

    public function EliminarAmbiente(Request $request){
        $ambiente = Ambiente::find($request->id);

        if (!$ambiente) {
            return response()->json("Ambiente no encontrado.", 404);
        }
    
        if ($ambiente->ambientemesas()->exists()) {
            return response()->json("No se puede eliminar, tiene mesas registradas.", 400);
        } else {
            $ambiente->delete();
            return response()->json("Se eliminó exitosamente.", 200);
        }
    }
}