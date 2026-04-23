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

    public function Restaurante(){
        return view('admin.Restaurante');
    }

    public function Gastos(){
        return view('admin.Gastos');
    }

    public function Clientes(){
        return view('admin.Clientes');
    }

    public function Productos(){
        return view('admin.Productos');
    }

    public function Ventas(){
        return view('admin.Ventas');
    }

    public function Proveedores(){
        return view('admin.Proveedores');
    }

    public function Indicadores(){
        return view('admin.Indicadores');
    }

    public function GetUserLogin(){
        $user = User::with('empresas')->get();
        return response()->json($user);
    }

    public function Kardex(){
        return view('admin.kardex.Kardex');
    }

    public function MenuDigital(){
        return view('admin.MenuOnline.online');
    }

}
