<?php

namespace App\Http\Controllers;

use App\Models\GrupoHospedaje;
use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\DetalleHospedajeHabitacion;
use App\Models\HospedajeHabitacion;
use App\Models\Servicio;
use App\Models\DetalleServicio;
use App\Models\Caja;
use App\Models\DetalleCaja;
use App\Models\Producto;
use App\Models\DetalleConsumo;
use App\Models\StockDate;
use App\Models\ModificadorDetalleConsumo;
use App\Models\Consumo;
use App\Models\DescuentoConsumo;
use App\Models\Pagos;
use App\Models\ServicioConsumo;
use App\Models\Adelanto;
use App\Models\Auto;
use App\Models\Prestamo;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\CambiarEstadoTurnosTrait;
use App\Traits\GenerarCodigoHospedajeTrait;

class GrupoHospedajeController extends Controller
{
    
    public function RegistrarGrupoHospedaje(Request $request){
        $user = Auth::user();

        $fechaIngreso = Carbon::parse($request->EntradaGrupoInput);
        $fechaSalida = Carbon::parse($request->SalidaGrupoInput);
    
        //return response()->json([$request->EntradaReservaInput, $fechaIngreso, $fechaSalida]);
    
        if ($fechaIngreso->isSameDay($fechaSalida)) {
            $cantidadDias = 1;
        } else {
            $cantidadDias = $fechaIngreso->diffInDays($fechaSalida);
        }
        
        $grupohospedaje = GrupoHospedaje::create([
            'TourName' => $request->TourNameInput,
            'CantidadPersonas' => $request->CantidadPersonasInput,
            'ingreso_hospedaje' => $request->EntradaGrupoInput,
            'hora_ingreso_hospedaje' => '00:00:00',
            'salida_hospedaje' => $request->SalidaGrupoInput,
            'Comentario' => $request->ComentarioGrupoInput,
            'procedencia_hospedaje' => $request->ProcedenciaGrupoInput,
            'destino_hospedaje' => $request->DestinoGrupoInput,
            'dias_hospedarse' => $cantidadDias,
            'Precio_habitacion' => 0.00,
            'PrecioRestante' => 0.00,
            'Adelanto' => 0.00,
            'TotalHospedaje' => 0.00,
            'TotalServicio' => 0.00,
            'TotalConsumo' => 0.00,
            'SubTotal' => 0.00,
            'Total' => 0.00,
            'CambioBolivianos' => 0.00,
            'CambioDolar' => 0.00,
            'CodigoHospedaje' => $request->TourCodigoInput,
        ]);

        return response()->json($request);
    }

    
    public function FiltrarDatosGrupos(Request $request){
        //return response()->json($request);
        
        $ingreso = 0;
        $salida = 0; 
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $Habitacion = $request->input('Habitaciones');
        $ingresoSum = 0;
        $salidaSum = 0;

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioGrupo':
                $grupos = GrupoHospedaje::whereDay('ingreso_hospedaje', $dia)
                                ->whereMonth('ingreso_hospedaje', $mes)
                                ->whereYear('ingreso_hospedaje', $anio)
                                ->get();
            
                $countgrupos = $grupos->count();

            break;
            case 'MensualGrupo':
                $grupos = GrupoHospedaje::whereMonth('ingreso_hospedaje', $mes)
                                ->whereYear('ingreso_hospedaje', $anio)
                                ->get();
            
                $countgrupos = $grupos->count();

            break;
            case 'AnualGrupo':
                $grupos = GrupoHospedaje::whereYear('ingreso_hospedaje', $anio)
                                ->get();
            
                $countgrupos = $grupos->count();
            break;
            case 'RangoGrupo':
                $grupos = GrupoHospedaje::whereBetween('ingreso_hospedaje', [$fechaInicio, $fechaFin])
                                ->get();
            
                $countgrupos = $grupos->count();
            break;
        }

        return response()->json([
            'grupos' => $grupos,
            'cantidadregistros' => $countgrupos,
        ]);
    }

    public function GetGrupoSeleccionado($id){
        $reservas = GrupoHospedaje::with(['hospedajes',
                                        'hospedajes.habitacion',
                                        'hospedajes.detallehospedajes',
                                        'hospedajes.detallehospedajes.cliente',
                                        'hospedajes.servicios',
                                        'hospedajes.servicioconsumos',
                                        'hospedajes.adelantos',
                                        'hospedajes.pagoshospedaje',
                                        'adelantos'
                                    ])
                                ->where('id',$id)
                                ->get();
                                
        return response()->json($reservas);
    }

    public function GetHabitacionesGrupoSeleccionado($id){
        $grupo = GrupoHospedaje::where('id',$id)->first();
        $hospedajes = HospedajeHabitacion::with('habitacion','detallehospedajes','detallehospedajes.cliente')->where('grupo_hospedajes_id',$id)->get();
        return response()->json($hospedajes);
    }

    public function RegistrarGrupoHabitaciones(Request $request){
        //return response()->json($request);
        $user = Auth::user();

        $grupo = GrupoHospedaje::with(['hospedajes',
                                    'hospedajes.habitacion',
                                    'hospedajes.detallehospedajes',
                                    'hospedajes.detallehospedajes.cliente',
                                    'hospedajes.servicios',
                                    'hospedajes.servicioconsumos',
                                    'hospedajes.adelantos',
                                    'hospedajes.pagoshospedaje',
                                    'adelantos'
                                ])->where('id',$request->IdGrupo)->first();
        $habitacionesSeleccionadas = $request->input('habitaciones');
        foreach ($habitacionesSeleccionadas as $habitacionId) {
            $hospedaje = HospedajeHabitacion::create([
                'user_id' => $user->id,
                'habitacion_id' => $habitacionId,
                'ingreso_hospedaje' => $grupo->ingreso_hospedaje,
                'salida_hospedaje' => $grupo->salida_hospedaje,
                'Precio_habitacion' => 0.00,
                'PrecioRestante' => 0.00,
                'Adelanto' => 0.00,
                'TotalHospedaje' => 0.00,
                'TotalServicio' => 0.00,
                'TotalConsumo' => 0.00,
                'SubTotal' => 0.00,
                'Total' => 0.00,
                'CambioBolivianos' => 0.00,
                'CambioDolar' => 0.00,
                'procedencia_hospedaje' => $grupo->procedencia_hospedaje,
                'destino_hospedaje' => $grupo->destino_hospedaje,
                'dias_hospedarse' => $grupo->dias_hospedarse,
                'EstadoReserva' => "true",
                'EstadoHospedaje' => "false",
                'grupo_hospedajes_id' => $request->IdGrupo
            ]);

            $servicio = Servicio::create([
                'hospedaje_habitacion_id' => $hospedaje->id,
                'user_id' => $user->id,
                'FechaRegistro_servicio' => $request->fechaIngreso,
                'FechaCierre' => null,
                'ServicioComentario' => "Servicios para la habitacion #".$habitacionId,
                'subTotalDesayuno' => 0,
                'totalpagadoDesayuno' => 0,
                'totalDesayuno' => 0,
                'subTotalLavado' => 0,
                'totalpagadoLavado' => 0,
                'totalLavado' => 0,
                'totalgeneral' => 0,
            ]);
    
            $servicioconsumo = ServicioConsumo::create([
                'hospedaje_habitacion_id' => $hospedaje->id,
                'user_id' => $user->id,
                'FechaRegistro_servicio' => $request->fechaIngreso,
                'FechaCierre' => null,
                'ServicioComentario' => "Servicios para la habitacion #".$habitacionId,
                'subTotal' => 0,
                'totalpagado' => 0,
                'total' => 0,
                'totalgeneral' => 0,
            ]);
        }

        return response()->json($grupo);
    }

    public function GetHabitacionesDisponibleGrupo($id){
        $hospedajes = HospedajeHabitacion::with('habitacion')->where('grupo_hospedajes_id', $id)->get();
        $habitacionesRegistradasIds = $hospedajes->pluck('habitacion_id')->toArray();
        $habitacionesDisponibles = Habitacion::whereNotIn('id', $habitacionesRegistradasIds)->get();
        return response()->json($habitacionesDisponibles);
    }

    public function GetHospedajeGrupo($id){
        $hospedaje = HospedajeHabitacion::with(['habitacion',
                                                'detallehospedajes',
                                                'detallehospedajes.cliente'])
                                        ->where('id', $id)
                                        ->get();
        return response()->json($hospedaje);
    }

    
    public function AgregarHospedajeClienteGrupo(Request $request){

        $hospedaje = HospedajeHabitacion::where('id',$request->IdHospedajeGrupo)->first();
        $hospedaje->save();

        $detallehospedaje = DetalleHospedajeHabitacion::create([
            'hospedaje_habitacion_id' => $request->IdHospedajeGrupo,
            'cliente_id' => $request->IdCliente    
        ]);

        return response()->json($hospedaje);
    }

    public function GetClienteHospedaje($id) {
        $hospedaje = HospedajeHabitacion::with(['detallehospedajes.cliente'])
                                        ->where('id', $id)
                                        ->first(); 
        
        return response()->json($hospedaje);
    }
    
    public function EliminarDetalleHospedajeClienteGrupo(Request $request) {
        $detalle = DetalleHospedajeHabitacion::find($request->DetalleHospedajeId);
        $hospedaje = HospedajeHabitacion::where('id',$detalle->hospedaje_habitacion_id)->first();
        
        $detalle->delete();
        return response()->json($hospedaje->grupo_hospedajes_id);
    }

    public function EliminarHospedajeClienteGrupo(Request $request) {
        $hospedaje = HospedajeHabitacion::with('detallehospedajes')->where('id',$request->HospedajeId)->first();
        $idgrupo = $hospedaje->grupo_hospedajes_id;
        $hospedaje->delete();
        return response()->json($idgrupo);
    }

    public function RegistrarAdelantoGrupo(Request $request) {
   
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;

        $grupo = GrupoHospedaje::where('id',$request->id)->first();

        if($request->tipomoneda == "Bs"){
            $newadelanto = Adelanto::create([
                'TipoAdelanto' => $request->tipo_pago,
                'FechaDeAdelanto' => now(),
                'TotalAdelanto' => $request->monto,
                'grupo_hospedajes_id' => $request->id
            ]);
        }else{
            $newadelanto = Adelanto::create([
                'TipoAdelanto' => $request->tipo_pago,
                'TipoMoneda' => $request->tipomoneda,
                'MontoDolar' =>  $request->monto,
                'FechaDeAdelanto' => now(),
                'TotalAdelanto' => $request->monto*7,
                'grupo_hospedajes_id' => $request->id
            ]); 
        }

        $adelantos = Adelanto::where('grupo_hospedajes_id', $grupo->id)->get();
        $valorsumado = $adelantos->sum('TotalAdelanto');

        $grupo->Adelanto = $valorsumado;
        $grupo->Total = $grupo->SubTotal-$valorsumado;
        $grupo->save();

        $caja = Caja::latest()->first();
        if($request->tipomoneda == "Bs"){        
            if($request->tipo_pago== "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalHostal'),
                    'articulo_caja_id' => 71,
                    'Articulo_description' => "Pago un adelanto de la reserva Codigo De reserva ".$grupo->CodigoHospedaje." de ".$request->monto." Bs.",
                    'Ingreso' => $request->monto,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $grupo->id,
                    'TipoServicioPrestado' => "GrupoReserva"
                ]);

                $caja->caja_hostal_ingreso += $request->InputTotalLavado;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalHostal'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->tipo_pago == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 71,
                    'Articulo_description' => "Pago un adelanto de la reserva Codigo De reserva ".$grupo->CodigoHospedaje." de ".$request->monto." Bs.",
                    'Ingreso' => $request->monto,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $grupo->id,
                    'TipoServicioPrestado' => "GrupoReserva"
                ]);

                $caja->caja_tarjetas_ingreso += $request->InputTotalLavado;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->tipo_pago == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 71,
                    'Articulo_description' => "Pago un adelanto de la reserva Codigo De reserva ".$grupo->CodigoHospedaje." de ".$request->monto." Bs.",
                    'Ingreso' => $request->monto,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $grupo->id,
                    'TipoServicioPrestado' => "GrupoReserva"
                ]);

                $caja->caja_depositos_ingreso += $request->InputTotalLavado;
                $caja->save();
                
                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }
        }else{
            $detallecaja = DetalleCaja::create([
                'user_id' => $user->id,
                'caja_id' => $caja->id,
                'codigo_caja_id' => config('global.GlobalDolar'),
                'articulo_caja_id' => 71,
                'Articulo_description' => "Pago un adelanto de la reserva Codigo De reserva ".$grupo->CodigoHospedaje." de ".$request->monto." ".$newadelanto->TipoMoneda,
                'Ingreso' => $newadelanto->MontoDolar,
                'Egreso' => "0.00",
                'Fecha_registro' => now(),
                'ServicioPrestado' => $grupo->id,
                'TipoServicioPrestado' => "GrupoReserva"
            ]);

            $caja->caja_dolars_ingreso += $newadelanto->MontoDolar;
            $caja->save();

            $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDolar'))->where('Eliminado','false')->get();

            foreach ($cajahostals as $caja) {
                $ingresoAcumulado += $caja->Ingreso;
                $egresoAcumulado += $caja->Egreso;
                $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                $caja->save();
            }
        }
        return response()->json($grupo);
    }

    public function ActualizarHospedajeGrupo(Request $request) {
        //return response()->json($request);
        if($request->Guia == "true"){
            $hospedaje = HospedajeHabitacion::where('id',$request->IdHospedajeGrupo)->first();
            $hospedaje->GuiaTuristica = "true";
            $hospedaje->Precio_habitacion = 0.00;
            $hospedaje->CategoriaHabitacion = "SIMPLE";
            $hospedaje->TotalHospedaje = 0.00;
            $hospedaje->save();
    
            $grupo = GrupoHospedaje::where('id', $hospedaje->grupo_hospedajes_id)->first();
            $hospedajegrupos = HospedajeHabitacion::where('grupo_hospedajes_id',$grupo->id)->get();
            $valorsumado = $hospedajegrupos->sum('Precio_habitacion');
            $grupo->SubTotal = $valorsumado;
            $grupo->TotalHospedaje = $valorsumado;
            $grupo->Total = $grupo->SubTotal;
            $grupo->save();
        }else{
            $hospedaje = HospedajeHabitacion::where('id',$request->IdHospedajeGrupo)->first();
            $hospedaje->Precio_habitacion = $request->PrecioHabitacionGrupo;
            $hospedaje->CategoriaHabitacion = $request->CategoriaHabitacionGrupo;
            $hospedaje->TotalHospedaje = $hospedaje->Precio_habitacion*$hospedaje->dias_hospedarse;
            $hospedaje->save();
    
            $grupo = GrupoHospedaje::where('id', $hospedaje->grupo_hospedajes_id)->first();
            $hospedajegrupos = HospedajeHabitacion::where('grupo_hospedajes_id',$grupo->id)->get();
            $valorsumado = $hospedajegrupos->sum('Precio_habitacion');
            $grupo->SubTotal = $valorsumado;
            $grupo->TotalHospedaje = $valorsumado;
            $grupo->Total = $grupo->SubTotal;
            $grupo->save();
        }
        
        return response()->json($hospedaje);
    }

    public function GetHabitacionOcupadaGrupo($id){
        $habitacion = Habitacion::where('id', $id)
            ->where("Estado_habitacion", "GRUPO")
            ->whereHas('hospedajehabitacion', function ($query) {
                $query->where('EstadoHospedajeGrupo', "true");
            })
            ->with([
                'hospedajehabitacion' => function ($query) {
                    $query->where('EstadoHospedajeGrupo', "true")
                        ->latest('id') 
                        ->limit(1);
                },
                'hospedajehabitacion.grupohospedaje',
                'hospedajehabitacion.detallehospedajes',
                'hospedajehabitacion.detallehospedajes.cliente',
                'hospedajehabitacion.autos',
                'hospedajehabitacion.reservas',
                'hospedajehabitacion.prestamos',
                'hospedajehabitacion.servicios',
                'hospedajehabitacion.servicios.detalleservicio',
                'hospedajehabitacion.servicioconsumos',
                'hospedajehabitacion.servicioconsumos.consumo.pagosconsumos',
                'hospedajehabitacion.servicioconsumos.consumo.detalleconsumos',
                'hospedajehabitacion.servicioconsumos.consumo.detalleconsumos.producto',
                'hospedajehabitacion.adelantos',
            ])
            ->first();

        return response()->json($habitacion);
    }


    public function CambiarEstadoGrupoInfo($id) {
        $grupo = GrupoHospedaje::with([
            'hospedajes' => function($query) {
                $query->where('EstadoHospedajeGrupo', "true");
            },
            'hospedajes.habitacion',
            'hospedajes.detallehospedajes',
            'hospedajes.detallehospedajes.cliente',
            'hospedajes.servicios',
            'hospedajes.servicioconsumos',
            'hospedajes.adelantos',
            'hospedajes.pagoshospedaje',
            'adelantos'
        ])->where('id', $id)->first();
    
        $categorias = $grupo->hospedajes->groupBy('CategoriaHabitacion')->map(function ($items, $categoria) {
            return $items->count();
        });
    
        $grupo->categoria_counts = $categorias;
        return response()->json($grupo);
    }

    public function CambiarEstadoGrupo($id){
        $grupo = GrupoHospedaje::where('id', $id)->first();
    
        $grupo->Estado = "true";
        $grupo->EstadoGrupo = "EN ESPERA";

        $grupo->save();
    
        $hospedajes = HospedajeHabitacion::where('grupo_hospedajes_id', $grupo->id)->get();
    
        foreach ($hospedajes as $hospedaje) {
            $hospedaje->EstadoHospedajeGrupo = "true";
            $hospedaje->EstadoHospedaje = "true";
            $hospedaje->save();
            $habitaciones = Habitacion::where('id', $hospedaje->habitacion_id)->get();
    
            foreach ($habitaciones as $habitacion) {
                $habitacion->Estado_habitacion = "GRUPO";
                $habitacion->save();
            }
        }
    
        return response()->json($grupo);
    }
    
    public function GetConsumoHabitacionGrupo($id){
        $grupo = GrupoHospedaje::where('id', $id)->first();
        $hospedajegrupos = HospedajeHabitacion::with(['habitacion', 'servicios', 'servicioconsumos'])->where('grupo_hospedajes_id',$grupo->id)->get();
        return response()->json($hospedajegrupos);
    }

    public function FinalizarGrupoHospedaje(Request $request){
        
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $caja = Caja::latest()->first();

        $registro = Pagos::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $grupo = GrupoHospedaje::where('id', $request->GrupoSelectId)->first();
        if($grupo->Total == 0){
            $grupo->EstadoGrupo = "CONCLUIDO";
            $grupo->Concluido = "SI";
            $grupo->Estado = "false";
            $grupo->save();

            $hospedajes = HospedajeHabitacion::where('grupo_hospedajes_id', $grupo->id)->get();

            foreach ($hospedajes as $hospedaje) {
                $hospedaje->EstadoHospedaje = "false";
                $hospedaje->EstadoHospedajeGrupo = "true";
                $hospedaje->save();
                $idhabitacion = $hospedaje->habitacion_id;

                $habitacion = Habitacion::where('id', $idhabitacion)->first();
                $habitacion->Estado_habitacion = "LIMPIEZA";
                $habitacion->save();
            }

            $detallecaja = DetalleCaja::create([
                'user_id' => $user->id,
                'caja_id' => $caja->id,
                'codigo_caja_id' => config('global.GlobalHostal'),
                'articulo_caja_id' => 71,
                'Articulo_description' => "Grupo de ".$grupo->TourName." codigo # " . $grupo->CodigoHospedaje." se quedaron ".$grupo->dias_hospedarse." no tenia ningun saldo a pagar.",
                'Ingreso' => "0.00",
                'Egreso' => "0.00",
                'Fecha_registro' => now(),
                'TipoServicioPrestado' => "GrupoReserva",
                'ServicioPrestado' => $grupo->id,
            ]);

        }else{
            $datos = $request->all();
            $pagos = $datos['pagos'];
            
            foreach ($pagos as $pago) {
                $CreatePago = Pagos::create([
                    'TipoPago' =>  $pago['tipo'],
                    'TipoMoneda' =>  $pago['moneda'],
                    'FechaDePago' => now(),
                    'TotalPago' => $pago['cantidad'],
                    'grupo_id' => $grupo->id,
                ]);
    
                if($CreatePago->TipoMoneda == "Bs"){
                    if($CreatePago->TipoPago == "Efectivo"){
                        $detallecaja = DetalleCaja::create([
                            'user_id' => $user->id,
                            'caja_id' => $caja->id,
                            'codigo_caja_id' => config('global.GlobalHostal'),
                            'articulo_caja_id' => 71,
                            'Articulo_description' => "Grupo de ".$grupo->TourName." codigo # " . $grupo->CodigoHospedaje." se quedaron ".$grupo->dias_hospedarse,
                            'Ingreso' => $CreatePago->TotalPago,
                            'Egreso' => "0.00",
                            'Fecha_registro' => now(),
                            'TipoServicioPrestado' => "GrupoReserva",
                            'ServicioPrestado' => $grupo->id,
                        ]);
        
                        $caja->caja_hostal_ingreso += $CreatePago->TotalPago;
                        $caja->save();
        
                        $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalHostal'))->where('Eliminado','false')->get();
        
                        foreach ($cajahostals as $caja) {
                            $ingresoAcumulado += $caja->Ingreso;
                            $egresoAcumulado += $caja->Egreso;
                            $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                            $caja->save();
                        }
                    }
        
                    if($CreatePago->TipoPago == "Tarjeta"){
                        $detallecaja = DetalleCaja::create([
                            'user_id' => $user->id,
                            'caja_id' => $caja->id,
                            'codigo_caja_id' => config('global.GlobalTarjeta'),
                            'articulo_caja_id' => 71,
                            'Articulo_description' => "Grupo de ".$grupo->TourName." codigo # " . $grupo->CodigoHospedaje." se quedaron ".$grupo->dias_hospedarse,
                            'Ingreso' => $CreatePago->TotalPago,
                            'Egreso' => "0.00",
                            'Fecha_registro' => now(),
                            'TipoServicioPrestado' => "GrupoReserva",
                            'ServicioPrestado' => $grupo->id,
                        ]);
        
                        $caja->caja_tarjetas_ingreso += $CreatePago->TotalPago;
                        $caja->save();  
        
                        $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();
        
                        foreach ($cajahostals as $caja) {
                            $ingresoAcumulado += $caja->Ingreso;
                            $egresoAcumulado += $caja->Egreso;
                            $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                            $caja->save();
                        }
                    }
        
                    if($CreatePago->TipoPago == "Deposito/QR"){
                        $detallecaja = DetalleCaja::create([
                            'user_id' => $user->id,
                            'caja_id' => $caja->id,
                            'codigo_caja_id' => config('global.GlobalDeposito'),
                            'articulo_caja_id' => 71,
                            'Articulo_description' => "Grupo de ".$grupo->TourName." codigo # " . $grupo->CodigoHospedaje." se quedaron ".$grupo->dias_hospedarse,
                            'Ingreso' => $CreatePago->TotalPago,
                            'Egreso' => "0.00",
                            'Fecha_registro' => now(),
                            'TipoServicioPrestado' => "GrupoReserva",
                            'ServicioPrestado' => $grupo->id,
                        ]);
        
                        $caja->caja_depositos_ingreso += $CreatePago->TotalPago;
                        $caja->save();
                        
                        $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();
        
                        foreach ($cajahostals as $caja) {
                            $ingresoAcumulado += $caja->Ingreso;
                            $egresoAcumulado += $caja->Egreso;
                            $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                            $caja->save();
                        }
                    }
                }else{
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalDolar'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Grupo de ".$grupo->TourName." codigo # " . $grupo->CodigoHospedaje." se quedaron ".$grupo->dias_hospedarse,
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'TipoServicioPrestado' => "GrupoReserva",
                        'ServicioPrestado' => $grupo->id,
                    ]);
    
                    $caja->caja_dolars_ingreso += $CreatePago->TotalPago;
                    $caja->save();
    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDolar'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }            
            }               
            
            $grupo->EstadoGrupo = "CONCLUIDO";
            $grupo->Concluido = "SI";
            $grupo->Estado = "false";
            $grupo->save();

            $hospedajes = HospedajeHabitacion::where('grupo_hospedajes_id', $grupo->id)->get();

            foreach ($hospedajes as $hospedaje) {
                $hospedaje->EstadoHospedaje = "false";
                $hospedaje->EstadoHospedajeGrupo = "true";
                $hospedaje->save();
                $idhabitacion = $hospedaje->habitacion_id;


                $habitacion = Habitacion::where('id', $idhabitacion)->first();
                $habitacion->Estado_habitacion = "LIMPIEZA";
                $habitacion->save();
            }

        }

        return response()->json($grupo);

    }
}
