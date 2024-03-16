<?php

namespace App\Http\Controllers;

use App\Models\Cocina;
use Illuminate\Http\Request;

class CocinaController extends Controller
{
    public function GetCocina(){
        $cocinas = Cocina::get();
        return response()->json($cocinas);
    }
}
