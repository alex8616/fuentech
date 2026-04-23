<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\ArqueoCaja;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MovimientoController extends Controller
{    

    public function GetMovimientosCajasCantidad() {
        $today = Carbon::now()->toDateString();
        $movimientos = Movimiento::with(['user','empresa'])->whereDate('created_at', $today)->count();
        $day = Carbon::now()->toDateString();
        $daymore = Carbon::now()->addDay()->toDateString();

        $data = [
            'day' => $day,
            'daymore' => $daymore,
            'count' => $movimientos,            
        ];

        return response()->json($data);
    }

    public function GetMovimientoCajaAll() {

        $today = \Carbon\Carbon::today();
        $movimientos = Movimiento::with(['user','empresa'])->whereDate('created_at', $today)
                         ->get();

        $count = $movimientos->count();
        
        $ingresos = round(Movimiento::where('tipo', "Ingreso")->sum('monto'), 2);
        $egresos = round(Movimiento::where('tipo', "Salida")->sum('monto'), 2);
        $total = $ingresos - $egresos;

        return response()->json([
            'movimientos' => $movimientos,
            'total' => $total,
            'count' => $count,
        ]);
    }

    public function GetMovimientoSeleccionado($id){
        $movimiento = Movimiento::with(['user','empresa'])->where('id',$id)->get();
        return response()->json($movimiento);
    }

    public function DeleteMovimientoSeleccionado($id){
        $movimiento = Movimiento::where('id',$id)->first();
        $movimiento->eliminado = "true";
        $movimiento->save();
        return response()->json($movimiento);
    }

    public function RegistrarMovimientoCaja(Request $request){
        //return response()->json($request);
        
        $registro = Movimiento::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user(); 

        $movimiento = Movimiento::create([
            'empresa_id' => $user->empresa_id,
            'user_id' => $user->id,
            'monto' => $request->Monto,
            'tipo' => $request->Tipo,
            'mediopago' => $request->Pago,
            'Comentario' => $request->Comentario,
            'fecharegistro' => Carbon::now(),
            'FechaCierre' => Carbon::now(),
        ]);

        if($movimiento->tipo == "Ingreso"){
            if($movimiento->mediopago == "Efectivo"){
                $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                $ActivoArqueo->Segun_SistemaIngresoEfectivo += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaIngresoEfectivo = number_format($ActivoArqueo->Segun_SistemaIngresoEfectivo, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotalIngreso += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotalIngreso = number_format($ActivoArqueo->Segun_SistemaTotalIngreso, 2, '.', '');
                $ActivoArqueo->TotalMovimientoCajaIngresoEfectivo += $movimiento->monto;
                $ActivoArqueo->TotalMovimientoCajaIngresoEfectivo = number_format($ActivoArqueo->TotalMovimientoCajaIngresoEfectivo, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotal += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');

                $ActivoArqueo->save();
            }
    
            if($movimiento->mediopago == "Tarjeta"){
                $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                $ActivoArqueo->Segun_SistemaIngresoTarjeta += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaIngresoTarjeta = number_format($ActivoArqueo->Segun_SistemaIngresoTarjeta, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotalIngreso += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotalIngreso = number_format($ActivoArqueo->Segun_SistemaTotalIngreso, 2, '.', '');
                $ActivoArqueo->TotalMovimientoCajaIngresoTarjeta += $movimiento->monto;
                $ActivoArqueo->TotalMovimientoCajaIngresoTarjeta = number_format($ActivoArqueo->TotalMovimientoCajaIngresoTarjeta, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotal += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                
                $ActivoArqueo->save();  
            }
    
            if($movimiento->mediopago == "Deposito/QR"){
                $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                $ActivoArqueo->Segun_SistemaIngresoDepositoQR += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaIngresoDepositoQR = number_format($ActivoArqueo->Segun_SistemaIngresoDepositoQR, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotalIngreso += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotalIngreso = number_format($ActivoArqueo->Segun_SistemaTotalIngreso, 2, '.', '');
                $ActivoArqueo->TotalMovimientoCajaIngresoDepositoQR += $movimiento->monto;
                $ActivoArqueo->TotalMovimientoCajaIngresoDepositoQR = number_format($ActivoArqueo->TotalMovimientoCajaIngresoDepositoQR, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotal += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                
                $ActivoArqueo->save();
            }
        }else{
            if($movimiento->mediopago == "Efectivo"){
                $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                $ActivoArqueo->Segun_SistemaEgresoEfectivo += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaEgresoEfectivo = number_format($ActivoArqueo->Segun_SistemaEgresoEfectivo, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotalEgreso += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                $ActivoArqueo->TotalMovimientoCajaEgresoEfectivo += $movimiento->monto;
                $ActivoArqueo->TotalMovimientoCajaEgresoEfectivo = number_format($ActivoArqueo->TotalMovimientoCajaEgresoEfectivo, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotal -= $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');

                $ActivoArqueo->save();
            }
    
            if($movimiento->mediopago == "Tarjeta"){
                $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                $ActivoArqueo->Segun_SistemaEgresoTarjeta += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaEgresoTarjeta = number_format($ActivoArqueo->Segun_SistemaEgresoTarjeta, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotalEgreso += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                $ActivoArqueo->TotalMovimientoCajaEgresoTarjeta += $movimiento->monto;
                $ActivoArqueo->TotalMovimientoCajaEgresoTarjeta = number_format($ActivoArqueo->TotalMovimientoCajaEgresoTarjeta, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotal -= $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                
                $ActivoArqueo->save();  
            }
    
            if($movimiento->mediopago == "Deposito/QR"){
                $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                $ActivoArqueo->Segun_SistemaEgresoDepositoQR += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaEgresoDepositoQR = number_format($ActivoArqueo->Segun_SistemaEgresoDepositoQR, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotalEgreso += $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                $ActivoArqueo->TotalMovimientoCajaEgresoDepositoQR += $movimiento->monto;
                $ActivoArqueo->TotalMovimientoCajaEgresoDepositoQR = number_format($ActivoArqueo->TotalMovimientoCajaEgresoDepositoQR, 2, '.', '');
                $ActivoArqueo->Segun_SistemaTotal -= $movimiento->monto;
                $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                
                $ActivoArqueo->save();
            }
        }

        return response()->json($ActivoArqueo);
    }
}

