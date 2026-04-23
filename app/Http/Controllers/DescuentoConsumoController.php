<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use App\Models\DescuentoConsumo;
use App\Models\Pagos;
use App\Models\ArqueoCaja;
use App\Models\DetalleCaja;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DescuentoConsumoController extends Controller
{
    public function RegistrarDescuento(Request $request){
        //return response()->json($request);
        
        $registro = DescuentoConsumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $consumo = Consumo::where('id',$request->id)->first();
        $total = $consumo->subTotal;
        if($request->porcentaje != 0){
            $totalDescuento = ($total * $request->porcentaje) / 100;
            $Descuento = DescuentoConsumo::create([
                'TipoDescuento' => 'porcentaje',
                'FechaDescuento' => now(),
                'MontoDescuento' => $request->porcentaje,
                'TotalDescuento' => $totalDescuento,
                'consumo_id' => $request->id,
            ]);
        }else{
            $Descuento = DescuentoConsumo::create([
                'TipoDescuento' => 'total',
                'FechaDescuento' => now(),
                'MontoDescuento' => $request->monto,
                'TotalDescuento' => $request->monto,
                'consumo_id' => $request->id,
            ]);            
        }

        $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$request->id)->get();
        $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
        $valorfinal = $consumo->subTotal - $SumDescuentoSubtotal;
        $dateconsumo = Consumo::where('id', $request->id)->update(['total' => $valorfinal]);
        //return response()->json($dateconsumo);
        return response()->json($Descuento);
    }

    public function GetDescuento($id){
        $descuento = DescuentoConsumo::where('consumo_id',$id)->get();
        return response()->json($descuento);
    }

    public function eliminarDescuento($id){
        try {
            $descuento = DescuentoConsumo::findOrFail($id);
            $consumo = Consumo::where('id',$descuento->consumo_id)->first();
            $consumo->total += $descuento->TotalDescuento;
            $consumo->save();
            $descuento->delete();
            return response()->json($consumo);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function guardarPagos(Request $request){
        //return response()->json($request);
        $registro = Pagos::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $id = $request->consumoId;
        $datos = $request->all();
        $pagos = $datos['pagos'];
        $totalsum = 0;
        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipo'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['monto'],
                'consumo_id' => $id,
            ]);
        }

        $consumo = Consumo::where('id', $id)->first();
        /*$consumo = Consumo::where('id', $id)->first();
        $consumo->ocupado = 'false';
        $consumo->FechaCierre = now();
        $consumo->save();*/
        return response()->json($consumo);
    }

    public function GetPagosDelivery($id){
        $consumo = Consumo::where('id', $id)->first();
        $pagos = Pagos::where('consumo_id', $id)->get();
        $total = $pagos->sum('TotalPago');
        return response()->json([
            'pagos' => $pagos,
            'total' => $total,
            'consumo' => $consumo
        ]);
    }

    public function deletePago($id) {
        $pago = Pagos::find($id);
        if ($pago) {
            $pago->delete();
            return response()->json(['message' => 'Pago eliminado con éxito']);
        } else {
            return response()->json(['error' => 'Pago no encontrado'], 404);
        }
    }

    public function EstadoEntregar($id) {
        $consumo = Consumo::find($id);
        if ($consumo) {
            $consumo->EstadoDelivery = "Entregar";
            $consumo->save();
            return response()->json(['message' => 'Estado cambiado éxitosamente']);
        } else {
            return response()->json(['error' => 'Consumo no encontrado'], 404);
        }
    }

    public function EstadoEnviar($id) {
        $consumo = Consumo::find($id);
        if ($consumo) {
            $consumo->EstadoDelivery = "Enviado";
            $consumo->save();
            return response()->json(['message' => 'Estado cambiado éxitosamente']);
        } else {
            return response()->json(['error' => 'Consumo no encontrado'], 404);
        }
    }

    /*public function EstadoCompleto($id) {
        $consumo = Consumo::find($id);
        if ($consumo) {
            $consumo->EstadoDelivery = "Completo";
            $consumo->save();

            $ActivoArqueo = ArqueoCaja::where("empresa_id",$consumo->empresa_id)->where("Estado", "Abierto")->latest()->first();
            $ActivoArqueo->Segun_SistemaIngresoEfectivo += $consumo->total;
            $ActivoArqueo->Segun_SistemaIngresoEfectivo = number_format($ActivoArqueo->Segun_SistemaIngresoEfectivo, 2, '.', '');
            $ActivoArqueo->Segun_SistemaTotalIngreso += $consumo->total;
            $ActivoArqueo->Segun_SistemaTotalIngreso = number_format($ActivoArqueo->Segun_SistemaTotalIngreso, 2, '.', '');
            $ActivoArqueo->TotalVentaCajaIngreso += $consumo->total;
            $ActivoArqueo->TotalVentaCajaIngreso = number_format($ActivoArqueo->TotalVentaCajaIngreso, 2, '.', '');
            $ActivoArqueo->Segun_SistemaTotal += $consumo->total;
            $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
            
            $ActivoArqueo->save();
            
            return response()->json(['message' => 'Estado cambiado éxitosamente']);
        } else {
            return response()->json(['error' => 'Consumo no encontrado'], 404);
        }        
    }*/

    public function EstadoCompleto($id) {
        $user = Auth::user();
        
        
        $consumo = Consumo::find($id);

        $enviarCajaDelivery = request()->query('EnviarCajaDelivery');
        
        
        foreach ($consumo->pagosconsumos as $pago) {
            $caja = Caja::latest()->first();
            $ingresoAcumulado = 0;
            $egresoAcumulado = 0;
            
            $idcaja = $caja->id;
            if($caja && $enviarCajaDelivery == "true"){
                if($pago->TipoPago == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $idcaja,
                        'codigo_caja_id' => config('global.GlobalRestaurante'),
                        'articulo_caja_id' => 23,
                        'Articulo_description' => "Consumo Delivery #" . $consumo->id . " - " . $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $pago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);
    
                    $caja->caja_restaurante_ingreso += $pago->TotalPago;
                    $caja->save();
    
                    $cajahostals = DetalleCaja::where('caja_id', $idcaja)->where('codigo_caja_id',config('global.GlobalRestaurante'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
    
                if($pago->TipoPago == "Tarjeta"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $idcaja,
                        'codigo_caja_id' => config('global.GlobalTarjeta'),
                        'articulo_caja_id' => 23,
                        'Articulo_description' => "Consumo Delivery #" . $consumo->id . " - " . $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $pago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);
    
                    $caja->caja_tarjetas_ingreso += $pago->TotalPago;
                    $caja->save();  
    
                    $cajahostals = DetalleCaja::where('caja_id', $idcaja)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
    
                if($pago->TipoPago == "Deposito/QR"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $idcaja,
                        'codigo_caja_id' => config('global.GlobalDeposito'),
                        'articulo_caja_id' => 23,
                        'Articulo_description' => "Consumo Delivery #" . $consumo->id . " - " . $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $pago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);
    
                    $caja->caja_depositos_ingreso += $pago->TotalPago;
                    $caja->save();
                    
                    $cajahostals = DetalleCaja::where('caja_id', $idcaja)->where('codigo_caja_id',config('global.GlobalDeposito'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
            }
        }

        $consumo->EstadoDelivery = "Completo";
        $consumo->save();
        
        return response()->json($consumo);

    }

}
