<?php

namespace App\Http\Controllers;

use App\Models\Proveedore;
use Illuminate\Http\Request;

class ProveedoreController extends Controller
{
    public function GetProveedor(){
        $proveedores = Proveedore::get();
        return response()->json($proveedores);
    }
}
