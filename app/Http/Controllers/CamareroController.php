<?php

namespace App\Http\Controllers;

use App\Models\Camarero;
use Illuminate\Http\Request;

class CamareroController extends Controller
{
    
    public function GetCamarero(){
        $camareros = Camarero::get();
        return response()->json($camareros);
    }
}
