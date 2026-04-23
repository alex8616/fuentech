<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\DetallePersonal;

class UserController extends Controller
{
    public function GetUser(){
        $users = User::get();
        return response()->json($users);
    }

    public function login(Request $request){
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($request->only('email', 'password'))) {
            // Autenticación exitosa
            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => Auth::user()
            ], 200);
        }

        // Autenticación fallida
        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]);
    }

    public function perfil($id){
        $user = User::findOrFail($id);

        return view('user.UserPerfil', compact('user'));
    }

    public function perfilasistencia(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $persona = $request->input('persona');

        switch ($tipoFiltro) {
            case 'MensualidadAsistencia':
                $asistencias = DetallePersonal::where('persona_id', $persona)
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();
            break;
        }
        return response()->json([
            'asistencias' => $asistencias
        ]);
    }

    /*
     // Asignar created_at y updated_at personalizados
            $Detalle->created_at = "2025-02-13 18:31:11";
            $Detalle->updated_at = "2025-02-13 18:31:11";

            $Detalle->save();
    */

}
