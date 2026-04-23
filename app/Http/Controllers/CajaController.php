<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\LibroNovedade;
use App\Models\DetalleCaja;
use App\Models\ArticuloCaja;
use App\Models\CodigoCaja;
use App\Models\HospedajeHabitacion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{

    public function GetCajas(){
        $cajas = Caja::get();
        return response()->json($cajas);
    }

    public function RegistrarCaja(Request $request){
        $user = Auth::user();
        $fecha = Carbon::now()->format('Y/m/01');
        $cajaExistente = Caja::where('fecha_registro', $fecha)
                              ->where('empresa_id', $user->empresa_id)
                              ->first();
        
        if ($cajaExistente) {
            return response()->json([
                'error' => 'Ya existe una caja registrada con esa fecha.'
            ], 400);
        }
    
        $datoscaja = Caja::create([
            'fecha_registro' => $fecha,
            'caja_hostal_ingreso' => 0,
            'caja_hostal_egreso' => 0,
            'caja_restaurante_ingreso' => 0,
            'caja_restaurante_egreso' => 0,
            'caja_tarjetas_ingreso' => 0,
            'caja_depositos_ingreso' => 0,
            'caja_dolars_ingreso' => 0,
            'total' => 0,
            'user_id' => $user->id,
            'empresa_id' => $user->empresa_id,
        ]);
        
        return response()->json($datoscaja);
    }

    public function GetCajasSeleccionado($id){
        $caja = Caja::where('id',$id)->first();
        $idcaja = $caja->id;
        return view('admin.caja.VistaCajas',compact('idcaja'));
    }

    public function RegistrarNovedad(Request $request) {
        //return response()->json($request);

        $user = Auth::user();

        $controlesArray = json_decode($request->Controles, true);
        $llavesArray = json_decode($request->Llaves, true);
    
        $libroNovedad = new LibroNovedade();
        $libroNovedad->datadisplay = 2;
        $libroNovedad->caja_id = $request->idCaja;
        $libroNovedad->user_id = $user->id;
        $libroNovedad->controles = json_encode($controlesArray);
        $libroNovedad->llaves = json_encode($llavesArray);
        $libroNovedad->tanque_1 = $request->Tanque1;
        $libroNovedad->tanque_2 = $request->Tanque2;
        $libroNovedad->tanque_3 = $request->Tanque3;
        $libroNovedad->detalle = $request->Novedades;
        $libroNovedad->Fecha_registro = now();
        $libroNovedad->save();
        return response()->json(['success' => 'Novedad registrada con éxito']);
    }

    public function GetLibroNovedades(){
        $libronovedades = LibroNovedade::with('user')->orderBy('id', 'DESC')->get();
        return response()->json($libronovedades);
    }

    public function GetLibroNovedadesSelect($id){
        $libronovedade = LibroNovedade::with('user')->where('id', $id)->first();
        $user = Auth::user();
        if ($libronovedade && $libronovedade->user_id === $user->id) {
            return response()->json($libronovedade);
        } else {
            return response()->json(['message' => 'No autorizado o no encontrado'], 404);
        }
    }

    public function ActualizarNovedades(Request $request) {
        //return response()->json($request);

        $libroNovedad = LibroNovedade::where('id',$request->id)->first();
        $user = Auth::user();
        $controlesArray = json_decode($request->Controles, true);
        $llavesArray = json_decode($request->Llaves, true);
        $libroNovedad->caja_id = $request->idCaja;
        $libroNovedad->user_id = $user->id;
        $libroNovedad->controles = json_encode($controlesArray);
        $libroNovedad->llaves = json_encode($llavesArray);
        $libroNovedad->tanque_1 = $request->Tanque1;
        $libroNovedad->tanque_2 = $request->Tanque2;
        $libroNovedad->tanque_3 = $request->Tanque3;
        $libroNovedad->detalle = $request->Novedades;
        $libroNovedad->Fecha_registro = now();
        $libroNovedad->save();

        return response()->json($libroNovedad);
    }

    public function FiltrarDatosNovedades(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
            
        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioNovedad':
                $libronovedades = LibroNovedade::with('user')
                                ->whereDay('created_at', $dia)
                                ->whereMonth('created_at', $mes)
                                ->orderBy('id', 'DESC')
                                ->get();
            
            break;
            case 'MensualNovedad':
                $libronovedades = LibroNovedade::with('user')
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->orderBy('id', 'DESC')
                                ->get();
            
            break;
        }

        return response()->json([
            'libronovedades' => $libronovedades,
        ]);
    }

    public function FiltrarCajaHostal(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $id = $request->input('idCaja');        
        $fechaInicio = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
        switch ($tipoFiltro) {
            case 'DiarioCajaHostal':
                $cajahostals = DetalleCaja::where('caja_id', $id)
                                ->where('codigo_caja_id',1)
                                ->with(['caja','caja.user','articulocaja','codigocaja'])
                                ->whereDay('created_at', $dia)
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();

                $caja = Caja::where('id', $id)->first();
                $sumaIngreso = $caja->caja_hostal_ingreso;
                $sumaEgreso = $caja->caja_hostal_egreso;
                $totalHostal = round($sumaIngreso - $sumaEgreso, 2);
            break;
            case 'MensualidadCajaHostal':
                $cajahostals = DetalleCaja::where('caja_id', $id)
                                ->where('codigo_caja_id',1)
                                ->with(['caja','caja.user','articulocaja','codigocaja'])
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();
                
                $caja = Caja::where('id', $id)->first();
                $sumaIngreso = $caja->caja_hostal_ingreso;
                $sumaEgreso = $caja->caja_hostal_egreso;
                $totalHostal = round($sumaIngreso - $sumaEgreso, 2);
            break;
            case 'RangoCajaHostal':
                $cajahostals = DetalleCaja::where('caja_id', $id)
                                ->where('codigo_caja_id',1)
                                ->with(['caja','caja.user','articulocaja','codigocaja'])
                                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                ->get();                

                $caja = Caja::where('id', $id)->first();
                $sumaIngreso = $caja->caja_hostal_ingreso;
                $sumaEgreso = $caja->caja_hostal_egreso;
                $totalHostal = round($sumaIngreso - $sumaEgreso, 2);
            break;
        }

        return response()->json([
            'cajahostals' => $cajahostals,
            'IngresoHostal' => $sumaIngreso,
            'EgresoHostal' => $sumaEgreso,
            'TotalHostal' => $totalHostal,
        ]);
    }

    public function GetArticuloCaja(){
        $articulocaja = ArticuloCaja::get();
        return response()->json($articulocaja);
    }

    public function RegistrarDetalleHostal(Request $request){

        $registro = DetalleCaja::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user();
        $codigohostal = 1;
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
            'articulo_caja_id' => $request->articuloId,
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
        $caja->caja_hostal_ingreso = $IngresoSumatoria;
        $caja->caja_hostal_egreso = $EgresoSumatoria;
        $caja->save();

        return response()->json($detallecaja);

    }

    public function GetDetalleCajaSelect($id){
        $detallecaja = DetalleCaja::with(['caja','caja.user','articulocaja','codigocaja'])->where('id',$id)->first();
        
        if ($detallecaja && $detallecaja->ServicioPrestado) {
            $hospedaje = HospedajeHabitacion::with(['user',
                                    'habitacion',
                                    'detallehospedajes',
                                    'detallehospedajes.cliente',
                                    'servicios',
                                    'servicios.detalleservicio',
                                    'servicioconsumos',
                                    'servicioconsumos.consumo',
                                    'servicioconsumos.consumo.detalleconsumos',
                                    'servicioconsumos.consumo.detalleconsumos.producto',
                                    'adelantos',
                                    'autos',
                                    'prestamos',
                                    'pagoshospedaje',
                                    'reservas',
                                    'grupohospedaje',
                                    ])->where("id", $detallecaja->ServicioPrestado)->first();

            if ($hospedaje) {
                $detallecaja->hospedaje = $hospedaje;
            }
        }

        return response()->json($detallecaja);
    }

    public function CerrarCaja(Request $request){
        $user = Auth::user();

        $codigocajas = CodigoCaja::get();

        foreach ($codigocajas as $codigocaja) {
            DetalleCaja::create([
                'user_id' => $user->id,
                'caja_id' => $request->idCaja,
                'codigo_caja_id' => $codigocaja->id,
                'articulo_caja_id' => 200,
                'Fecha_registro' => now(),
                'Articulo_description' => "Caja Cerrada por ".$user->name. " " .now(),
            ]);
        }
        
    }

    public function GetDetalleCajaSelectEdit($id){
        $detallecaja = DetalleCaja::with(['caja', 'caja.user', 'articulocaja', 'codigocaja'])
            ->where('id', $id)
            ->first();

        $user = Auth::user();

        if ($detallecaja && $detallecaja->user_id === $user->id) {
            return response()->json($detallecaja);
        } else {
            return response()->json(['message' => 'No autorizado o no encontrado'], 404);
        }
    }


    public function ActualizarCajaHostal(Request $request) {
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
        $detallecaja->articulo_caja_id = $request->articuloId;
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
        $caja->caja_hostal_ingreso = $IngresoSumatoria;
        $caja->caja_hostal_egreso = $EgresoSumatoria;
        $caja->save();
    }

    public function EliminarCajaHostal(Request $request) {
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
        $caja->caja_hostal_ingreso = $IngresoSumatoria;
        $caja->caja_hostal_egreso = $EgresoSumatoria;
        $caja->save();
    }

    public function CajaChica($id){
        $caja = Caja::where('id',$id)->first();
        $idcaja = $caja->id;
        return view('admin.caja.CajaChica',compact('idcaja'));
    }
}
