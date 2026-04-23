<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function Usuarios(){
        return view('admin.user.usuarios');
    }

    public function register(Request $request){
        $user = Auth::user(); 
        $pinunido = $request->PinUser1.$request->PinUser2.$request->PinUser3.$request->PinUser4;
        $correounido = $request->CorreoUser.'@tukos.com';
        $user = User::create([
            'pin' => $pinunido, 
            'name' => $request->NameUser, 
            'email' => $correounido, 
            'password' => Hash::make($request->ContraseniaUser),
            'empresa_id' => $user->empresa_id, 
            'DirecionIpPrincipal' => $request->DireccionIp,
        ]);

        return response()->json($user);
    }

    public function GetUsuario(){
        $users = User::get();
        return response()->json($users);
    }

    public function GetSeleccionadoUsuario($id){
        $user = User::where('id',$id)->first();
        return response()->json($user);
    }

    public function ActualizarUsuario(Request $request){
        $user = User::where('id',$request->id)->first();
        $user->name = $request->nombre;
        $user->DirecionIpPrincipal = $request->direccion;
        $user->estado = $request->estado;
        $user->save();
        return response()->json($user);
    }
}

/*
 id: IdUpdate,
                    direccion: EditDireccionIp,
                    estado: EditEstado,
                    nombre: EditNombre,
*/