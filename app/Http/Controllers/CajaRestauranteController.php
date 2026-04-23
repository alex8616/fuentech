<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Caja;
use App\Models\User;
use App\Models\LibroNovedade;
use App\Models\DetalleCaja;
use App\Models\ArticuloCaja;
use App\Models\CodigoCaja;
use App\Models\Consumo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CajaRestauranteController extends Controller
{
    public function RegistrarDetalleRestaurante(Request $request){

        $registro = DetalleCaja::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user();
        $codigohostal = 2;
        $ingreso = 0;
        $egreso = 0;
        $facturarecibo = "";
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $IngresoSumatoria = 0;
        $EgresoSumatoria = 0;

        if($request->tipoDeAccion == "Ingreso"){
            $ingreso = $request->monto;
        }else{
            $egreso = $request->monto;
        }

        if($request->facturarecibo != null){
            $facturarecibo = "Con_Factura";
        }else{
            $facturarecibo = "Sin_Factura";
        }

        $detallecaja = DetalleCaja::create([
            'user_id' => $user->id,
            'caja_id' => $request->idCaja,
            'codigo_caja_id' => $codigohostal,
            'articulo_caja_id' => $request->articuloIdRestaurante,
            'Articulo_description' => $request->detalle,
            'Ingreso' => $ingreso,
            'Egreso' => $egreso,
            'Fecha_registro' => now(),
            'Factura' => $facturarecibo,
            'NFactura' => $request->facturarecibo,            
        ]);

        $cajahostals = DetalleCaja::where('caja_id', $request->idCaja)->where('codigo_caja_id',$codigohostal)->where('Eliminado','false')->get();

        foreach ($cajahostals as $caja) {
            $ingresoAcumulado += $caja->Ingreso;
            $egresoAcumulado += $caja->Egreso;
            $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
            $caja->save();
        }

        $IngresoSumatoria = $cajahostals->sum('Ingreso');
        $EgresoSumatoria = $cajahostals->sum('Egreso');

        $caja = Caja::where('id',$request->idCaja)->first();
        $caja->caja_restaurante_ingreso = $IngresoSumatoria;
        $caja->caja_restaurante_egreso = $EgresoSumatoria;
        $caja->save();

        return response()->json($detallecaja);

    }

    public function FiltrarCajaRestaurante(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $id = $request->input('idCaja');        
        $fechaInicio = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
        switch ($tipoFiltro) {
            case 'DiarioCajaRestaurante':
                $cajarestaurantes = DetalleCaja::where('caja_id', $id)
                                ->where('codigo_caja_id',2)
                                ->with(['caja','caja.user','articulocaja','codigocaja'])
                                ->whereDay('created_at', $dia)
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();

                $caja = Caja::where('id', $id)->first();
                $sumaIngreso = $caja->caja_restaurante_ingreso;
                $sumaEgreso = $caja->caja_restaurante_egreso;
                $totalRestaurante = round($sumaIngreso - $sumaEgreso, 2);
            break;
            case 'MensualidadCajaRestaurante':
                $cajarestaurantes = DetalleCaja::where('caja_id', $id)
                                ->where('codigo_caja_id',2)
                                ->with(['caja','caja.user','articulocaja','codigocaja'])
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();
                
                $caja = Caja::where('id', $id)->first();
                $sumaIngreso = $caja->caja_restaurante_ingreso;
                $sumaEgreso = $caja->caja_restaurante_egreso;
                $totalRestaurante = round($sumaIngreso - $sumaEgreso, 2);
            break;
            case 'RangoCajaRestaurante':
                $cajarestaurantes = DetalleCaja::where('caja_id', $id)
                                ->where('codigo_caja_id',2)
                                ->with(['caja','caja.user','articulocaja','codigocaja'])
                                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                ->get();

                $caja = Caja::where('id', $id)->first();
                $sumaIngreso = $caja->caja_restaurante_ingreso;
                $sumaEgreso = $caja->caja_restaurante_egreso;
                $totalRestaurante = round($sumaIngreso - $sumaEgreso, 2);
            break;
        }

        return response()->json([
            'cajarestaurantes' => $cajarestaurantes,
            'IngresoRestaurante' => $sumaIngreso,
            'EgresoRestaurante' => $sumaEgreso,
            'TotalRestaurante' => $totalRestaurante,
        ]);
    }

    public function ActualizarCajaRestaurante(Request $request) {
        //return response()->json($request);
        $ingreso = 0;
        $egreso = 0;
        $facturarecibo = "";
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        
        if($request->facturarecibo != null){
            $facturarecibo = "Con_Factura";
        }else{
            $facturarecibo = "Sin_Factura";
        }

        if($request->tipoDeAccion == "Ingreso"){
            $ingreso = $request->monto;
        }else{
            $egreso = $request->monto;
        }

        $detallecaja = DetalleCaja::where('id',$request->iddetalle)->first();
        $detallecaja->articulo_caja_id = $request->articuloIdRestaurante;
        $detallecaja->Articulo_description = $request->detalle;
        $detallecaja->Factura = $facturarecibo;
        $detallecaja->NFactura = $request->facturarecibo;
        $detallecaja->Ingreso = $ingreso;
        $detallecaja->Egreso = $egreso;
        $detallecaja->save();

        $cajahostals = DetalleCaja::where('caja_id', $request->idCaja)->where('codigo_caja_id',$detallecaja->codigo_caja_id)->where('Eliminado','false')->get(); 

        foreach ($cajahostals as $caja) {
            $ingresoAcumulado += $caja->Ingreso;
            $egresoAcumulado += $caja->Egreso;
            $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
            $caja->save();
        }

        $IngresoSumatoria = $cajahostals->sum('Ingreso');
        $EgresoSumatoria = $cajahostals->sum('Egreso');

        $caja = Caja::where('id',$request->idCaja)->first();
        $caja->caja_restaurante_ingreso = $IngresoSumatoria;
        $caja->caja_restaurante_egreso = $EgresoSumatoria;
        $caja->save();
    }

    public function EliminarCajaRestaurante(Request $request) {
        //return response()->json($request);
        $ingreso = 0;
        $egreso = 0;
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        
        $detallecaja = DetalleCaja::where('id',$request->iddetalle)->first();
        $detallecaja->Eliminado = "true";
        $detallecaja->ComentarioEliminado = $request->ComentarioEliminado;
        $detallecaja->Sumatoria = "0.00";
        $detallecaja->save();

        $cajahostals = DetalleCaja::where('caja_id', $request->idCaja)->where('codigo_caja_id', $detallecaja->codigo_caja_id)->where('Eliminado','false')->get();    

        foreach ($cajahostals as $caja) {
            $ingresoAcumulado += $caja->Ingreso;
            $egresoAcumulado += $caja->Egreso;
            $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
            $caja->save();
        }

        $IngresoSumatoria = $cajahostals->sum('Ingreso');
        $EgresoSumatoria = $cajahostals->sum('Egreso');

        $caja = Caja::where('id',$request->idCaja)->first();
        $caja->caja_restaurante_ingreso = $IngresoSumatoria;
        $caja->caja_restaurante_egreso = $EgresoSumatoria;
        $caja->save();
    }

    public function GetDetalleCajaRestauranteSelect($id){
        $detallecaja = DetalleCaja::with(['caja', 'user', 'articulocaja', 'codigocaja'])
                                    ->where('id', $id)
                                    ->first();

        if ($detallecaja && $detallecaja->ServicioPrestado) {
            $consumo = Consumo::with(['cliente',
                                    'camarero',
                                    'ambientemesa',
                                    'detalleconsumos.producto',
                                    'detalleconsumos.producto.modificadore',
                                    'detalleconsumos.producto.modificadore.detallemodificador',
                                    'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                    'detalleconsumos.modificadordetalleconsumo',
                                    'descuentoconsumos',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                                    'pagosconsumos',
                                    ])->where("id", $detallecaja->ServicioPrestado)->first();

            if ($consumo) {
                $detallecaja->consumo = $consumo;
            }
        }

        return response()->json($detallecaja);
    }
    
}
