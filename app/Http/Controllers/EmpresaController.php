<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
   
    public function vista(){
        return view('admin.index');
    }

    public function vista2(){
        return view('admin.index2');
    }

    public function vista3(){
        return view('admin.index3');
    }

    public function vista4(){
        return view('admin.index4');
    }

    public function vista1(){
        return view('admin.index1');
    }

    public function GetUserLogin(){
        $user = User::with('empresas')->get();
        return response()->json($user);
    }

    public function ConfigImpresora(){
        $user = Auth::user(); 

        if ($user) {
            $CountImpresora = Configuracion::where('empresa_id',$user->empresa_id)->count();
            $impresora = Configuracion::where('empresa_id',$user->empresa_id)->first();
            return view('admin.Configuracion.ConfiguracionImpresora',compact('CountImpresora','impresora'));
        } else {
            return response()->json("user No INICIADO SESSION");
        } 
        
    }

}
