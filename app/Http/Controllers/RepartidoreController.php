<?php

namespace App\Http\Controllers;

use App\Models\Repartidore;
use Illuminate\Http\Request;

class RepartidoreController extends Controller
{
    public function GetRepartidor(){
        $repartidores = Repartidore::get();
        return response()->json($repartidores);
    }
}
