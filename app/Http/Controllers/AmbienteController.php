<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
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
}