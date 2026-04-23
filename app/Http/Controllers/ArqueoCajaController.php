<?php

namespace App\Http\Controllers;

use App\Models\ArqueoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArqueoCajaController extends Controller
{
    public function RegistrarArqueoCaja(Request $request){
        //return response()->json($request);
        $registro = ArqueoCaja::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user();
        $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "true")->latest()->first();

        if ($user && $ActivoArqueo === null) {
            $arqueo = ArqueoCaja::create([
                'empresa_id' => $user->empresa_id,
                'user_id' => $user->id,
                'Fecha' => $request->FechaRegistro,
                'Hora' => $request->HoraRegistro,
                'MontoInicial' => $request->MontoIncial,
                'Segun_SistemaTotalIngreso' => 0.00,
                'Segun_SistemaIngresoEfectivo' => 0.00,
                'Segun_SistemaIngresoTarjeta' => 0.00,
                'Segun_SistemaIngresoDepositoQR' => 0.00,
                'Segun_SistemaTotalEgreso' => 0.00,
                'Segun_SistemaEgresoEfectivo' => 0.00,
                'Segun_SistemaEgresoTarjeta' => 0.00,
                'Segun_SistemaEgresoDepositoQR' => 0.00,
                'Segun_SistemaTotal' => $request->MontoIncial,
                'Segun_UsuarioEfectivo' => 0.00,
                'Segun_UsuarioTarjeta' =>  0.00,
                'Segun_UsuarioDepositoQR' =>  0.00,
                'Segun_UsuarioComentario' =>  0.00,
                'Segun_UsuarioTotal' =>  0.00,
                'Estado' => "Abierto",
                'Activo' => "true",
                'Diferencia' =>  0.00,
                'TotalMovimientoCajaIngreso' =>  0.00,
                'TotalVentaCajaIngreso' =>  0.00,
                'TotalGastosCajaEgreso' =>  0.00,
                'TotalMovimientoCajaEgreso' =>  0.00,
                'TotalCuentaProveedorEgresoEfectivo' =>  0.00,
                'TotalCuentaProveedorEgresoTarjeta' =>  0.00,
                'TotalCuentaProveedorEgresoDepositoQR' =>  0.00,
            ]);
            return response()->json($arqueo);
        } else {
            return response()->json("INICIADO SESSION");
        }
    }

    public function EvaluarArqueoCaja(Request $request){
        $user = Auth::user();
        $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();

        if ($user && $ActivoArqueo === null) {
            return response()->json("true");
        } else {
            return response()->json("false");
        }
    }

    public function FiltrarDatosArqueo(Request $request){
        $EstadoArqueo = $request->input('EstadoArqueo');
        $user = Auth::user();
        if ($user) {
            $arqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->when($EstadoArqueo !== 'TodoCaja', function ($query) use ($EstadoArqueo) {
                return $query->where('Estado', $EstadoArqueo);
            })
            ->get();
            return response()->json($arqueo);
        } else {
            return response()->json("INICIA SESSION");
        }
    }

    public function GetArqueoSeleccionado($id){
        $arqueo = ArqueoCaja::with('user')->where("id",$id)->get();
        return response()->json($arqueo);
    }

    public function CerrarArqueoCaja(Request $request){
        $user = Auth::user();
        if ($user) {
            $arqueocaja = ArqueoCaja::where("id",$request->idarqueo)->first();
            $arqueocaja->Segun_UsuarioComentario = $request->InputComentario;
            $arqueocaja->Segun_UsuarioEfectivo = $request->InputEfectivo;
            $arqueocaja->Segun_UsuarioTarjeta = $request->InputTarjeta;
            $arqueocaja->Segun_UsuarioDepositoQR = $request->InputDeposito;
            $arqueocaja->Diferencia = $request->diferencia;
            $arqueocaja->Estado = "Cerrado";
            $arqueocaja->Segun_UsuarioTotal = $request->total;
            $arqueocaja->user_id = $user->id;
            $arqueocaja->Activo = "false";
            $arqueocaja->save();
            return response()->json($arqueocaja);
        } else {
            return response()->json("INICIA SESSION");
        }
    }

    public function DeleteArqueoCaja(Request $request){
        $user = Auth::user();
        if ($user) {
            $arqueocaja = ArqueoCaja::where("id",$request->idarqueo)->first();
            $arqueocaja->Estado = "Eliminado";
            $arqueocaja->user_id = $user->id;
            $arqueocaja->save();
            return response()->json($arqueocaja);
        } else {
            return response()->json("INICIA SESSION");
        }
    }

}
