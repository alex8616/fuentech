<?php

namespace App\Http\Controllers;

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
use DateTime;

class ReservaController extends Controller
{
    use GenerarCodigoHospedajeTrait;

    public function ReservarHabitacionHospedaje(Request $request){
        //return response()->json($request);

        $user = Auth::user();
        $valorhabitacion = null;

        $fechaEntrada = Carbon::parse($request->EntradaReserva)->format('Y-m-d');
        $fechaSalida = Carbon::parse($request->SalidaReserva)->format('Y-m-d');

        $hospedaje = HospedajeHabitacion::create([
            'user_id' => $user->id,
            'habitacion_id' => $valorhabitacion,
            'ingreso_hospedaje' => $fechaEntrada,
            'salida_hospedaje' => $fechaSalida,
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
            'EstadoReserva' => "true",
            'EstadoHospedaje' => "false",
            'CodigoHospedaje' => $this->generarCodigoHospedajeUnico(),
            'Reserva' => 'true' 
        ]);

        $servicio = Servicio::create([
            'hospedaje_habitacion_id' => $hospedaje->id,
            'user_id' => $user->id,
            'FechaRegistro_servicio' => $request->fechaIngreso,
            'FechaCierre' => null,
            'ServicioComentario' => "Servicios para la habitacion #",
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
            'ServicioComentario' => "Servicios para la habitacion #",
            'subTotal' => 0,
            'totalpagado' => 0,
            'total' => 0,
            'totalgeneral' => 0,
        ]);

        $reserva = Reserva::create([
            'user_id' => $user->id,
            'hospedaje_habitacion_id' => $hospedaje->id,
            'ingreso_reserva' => $fechaEntrada,
            'salida_reserva' => $fechaSalida,
            'ComentarioReserva' => $request->ComentarioReserva,
            'CantidadPersonas' => $request->CantidadPersonas,
            'CodigoReserva' => $request->CodigoReserva,
            'CategoriaHabitacion' => $request->CategoriaHabitacion,
            'CanalReserva' => $request->CanalDeReserva,
            'ComisionReserva' => $request->ComisionDolar,
            'PrecioDolar' => $request->PrecioDolar,
            'PrecioBolivianos' => $request->PrecioBolivianos,
        ]);

        $adelantos = $request->Adelantos;

        /*
        if (!empty($adelantos)) {
            foreach ($adelantos as $adelanto) {
                $adelanto = Adelanto::create([
                    'TipoAdelanto' => $adelanto['TipoPago'],
                    'FechaDeAdelanto' => now(),
                    'TotalAdelanto' => $adelanto['MontoPago'],
                    'hospedaje_habitacion_id' => $hospedaje->id,
                ]);

                $caja = Caja::latest()->first();
                $ingresoAcumulado = 0;
                $egresoAcumulado = 0;
                
                if($adelanto->TipoAdelanto == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalHostal'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Reserva de habitacion codigo de reserva " . $hospedaje->CodigoHospedaje." Dejo un adelanto",
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);
    
                    $caja->caja_hostal_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();
    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalHostal'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
    
                if($adelanto->TipoAdelanto == "Tarjeta"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalTarjeta'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Reserva de habitacion codigo de reserva " . $hospedaje->CodigoHospedaje." Dejo un adelanto",
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);
    
                    $caja->caja_tarjetas_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();  
    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
    
                if($adelanto->TipoAdelanto == "Deposito/QR"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalDeposito'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Reserva de habitacion codigo de reserva " . $hospedaje->CodigoHospedaje." Dejo un adelanto",
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);
    
                    $caja->caja_depositos_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();
                    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalDeposito'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
            }

            $hospedaje = HospedajeHabitacion::where('id',$hospedaje->id)->first();

            $sumadelanto = Adelanto::where('hospedaje_habitacion_id', $hospedaje->id)->sum('TotalAdelanto');
            $hospedaje->Adelanto = $sumadelanto;
            $hospedaje->save();

        }
        */

        return response()->json($hospedaje);
    }

    public function ReservarHabitaciones(){
        $reservas = Reserva::with('hospedajehabitacion')->get();
        return response()->json($reservas);
    }

    public function FiltrarDatosReservas(Request $request){
        //return response()->json($request);
        
        $ingreso = 0;
        $salida = 0;
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $semana = $request->input('semana');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoReserva = $request->input('TipoReserva');
        $Habitacion = $request->input('Habitaciones');
        $ingresoSum = 0;
        $salidaSum = 0;

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioReserva':
                $reservas = Reserva::with(['hospedajehabitacion'])
                                ->whereDay('ingreso_reserva', $dia)
                                ->whereMonth('ingreso_reserva', $mes)
                                ->whereYear('ingreso_reserva', $anio)
                                ->when($TipoReserva !== 'TodoReserva', function ($query) use ($TipoReserva) {
                                    return $query->where('EstadoReserva', $TipoReserva);
                                })
                                ->when($Habitacion !== 'TodoHabitaciones', function ($query) use ($Habitacion) {
                                    return $query->whereHas('hospedajehabitacion', function ($q) use ($Habitacion) {
                                        $q->where('habitacion_id', $Habitacion);
                                    });
                                })
                                ->get();
            
                $countreservas = $reservas->count();

            break;
            case 'SemanalReserva':
                $anio = substr($semana, 0, 4);
                $numeroSemana = substr($semana, 6, 2);
            
                $fechaInicioSemana = (new DateTime())->setISODate($anio, $numeroSemana)->setTime(0, 0, 0);
                $fechaFinSemana = (clone $fechaInicioSemana)->modify('+6 days')->setTime(23, 59, 59);
            
                $reservas = Reserva::with(['hospedajehabitacion'])
                    ->whereBetween('ingreso_reserva', [$fechaInicioSemana, $fechaFinSemana])
                    ->when($TipoReserva !== 'TodoReserva', function ($query) use ($TipoReserva) {
                        return $query->where('EstadoReserva', $TipoReserva);
                    })
                    ->when($Habitacion !== 'TodoHabitaciones', function ($query) use ($Habitacion) {
                        return $query->whereHas('hospedajehabitacion', function ($q) use ($Habitacion) {
                            $q->where('habitacion_id', $Habitacion);
                        });
                    })
                    ->get();
            
                $countreservas = $reservas->count();
            break;
            case 'MensualReserva':
                $reservas = Reserva::with(['hospedajehabitacion'])
                                ->whereMonth('ingreso_reserva', $mes)
                                ->whereYear('ingreso_reserva', $anio)
                                ->when($TipoReserva !== 'TodoReserva', function ($query) use ($TipoReserva) {
                                    return $query->where('EstadoReserva', $TipoReserva);
                                })
                                ->when($Habitacion !== 'TodoHabitaciones', function ($query) use ($Habitacion) {
                                    return $query->whereHas('hospedajehabitacion', function ($q) use ($Habitacion) {
                                        $q->where('habitacion_id', $Habitacion);
                                    });
                                })
                                ->get();
            
                $countreservas = $reservas->count();

            break;
            case 'AnualReserva':
                $reservas = Reserva::with(['hospedajehabitacion'])
                                ->whereYear('ingreso_reserva', $anio)
                                ->when($TipoReserva !== 'TodoReserva', function ($query) use ($TipoReserva) {
                                    return $query->where('EstadoReserva', $TipoReserva);
                                })
                                ->when($Habitacion !== 'TodoHabitaciones', function ($query) use ($Habitacion) {
                                    return $query->whereHas('hospedajehabitacion', function ($q) use ($Habitacion) {
                                        $q->where('habitacion_id', $Habitacion);
                                    });
                                })
                                ->get();
            
                $countreservas = $reservas->count();
            break;
            case 'RangoReserva':
                $reservas = Reserva::with(['hospedajehabitacion'])
                                ->whereBetween('ingreso_reserva', [$fechaInicio, $fechaFin])
                                ->when($TipoReserva !== 'TodoReserva', function ($query) use ($TipoReserva) {
                                    return $query->where('EstadoReserva', $TipoReserva);
                                })
                                ->when($Habitacion !== 'TodoHabitaciones', function ($query) use ($Habitacion) {
                                    return $query->whereHas('hospedajehabitacion', function ($q) use ($Habitacion) {
                                        $q->where('habitacion_id', $Habitacion);
                                    });
                                })
                                ->get();
            
                $countreservas = $reservas->count();
            break;
        }

        return response()->json([
            'reservas' => $reservas,
            'cantidadregistros' => $countreservas,
        ]);
    }

    public function GetReservaSeleccionado($id){
        $reservas = Reserva::with(['hospedajehabitacion',
                                    'hospedajehabitacion.adelantos',
                                    ])
                                ->where('id',$id)
                                ->get();
                                
        return response()->json($reservas);
    }

    public function RegistrarAdelantoReserva(Request $request){
        //return response()->json($request);

        $user = Auth::user();        
        $fechaEntrada = Carbon::parse($request->EntradaReserva)->format('Y-m-d');
        $fechaSalida = Carbon::parse($request->SalidaReserva)->format('Y-m-d');

        $hospedaje = HospedajeHabitacion::where('id', $request->HospedajeID)->first();

        $adelantos = $request->Adelantos;

        if (!empty($adelantos)) {
            foreach ($adelantos as $adelanto) {
                $adelanto = Adelanto::create([
                    'TipoAdelanto' => $adelanto['TipoPago'],
                    'FechaDeAdelanto' => now(),
                    'TotalAdelanto' => $adelanto['MontoPago'],
                    'hospedaje_habitacion_id' => $hospedaje->id,
                ]);

                $caja = Caja::latest()->first();
                $ingresoAcumulado = 0;
                $egresoAcumulado = 0;
                
                if($adelanto->TipoAdelanto == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalHostal'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Reserva de habitacion codigo de reserva " . $hospedaje->CodigoHospedaje." Dejo un adelanto",
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);
    
                    $caja->caja_hostal_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();
    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalHostal'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
    
                if($adelanto->TipoAdelanto == "Tarjeta"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalTarjeta'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Reserva de habitacion codigo de reserva " . $hospedaje->CodigoHospedaje." Dejo un adelanto",
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);
    
                    $caja->caja_tarjetas_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();  
    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
    
                if($adelanto->TipoAdelanto == "Deposito/QR"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalDeposito'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Reserva de habitacion codigo de reserva " . $hospedaje->CodigoHospedaje." Dejo un adelanto",
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);
    
                    $caja->caja_depositos_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();
                    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalDeposito'))->where('Eliminado','false')->get();
    
                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
            }

            $hospedaje = HospedajeHabitacion::where('id',$hospedaje->id)->first();

            $sumadelanto = Adelanto::where('hospedaje_habitacion_id', $hospedaje->id)->sum('TotalAdelanto');
            $hospedaje->Adelanto = $sumadelanto;
            $hospedaje->save();

        }

        return response()->json($hospedaje);
    }

    public function ActualizarReserva(Request $request){
        //return response()->json($request);

        $reserva = Reserva::with(['hospedajehabitacion',
                        'hospedajehabitacion.adelantos',
                        ])->where('id',$request->IdReserva)->first();
        $reserva->ingreso_reserva = $request->EditFechaIngreso;
        $reserva->salida_reserva = $request->EditFechaSalida;
        $reserva->save();

        if($request->SelectHabitacionesUpdate != "SinHabitacion"){
            $hospedaje = HospedajeHabitacion::where('id', $reserva->hospedaje_habitacion_id)->first();
            $hospedaje->habitacion_id = $request->SelectHabitacionesUpdate;
            $hospedaje->save();
        }

        $llevardatos = Reserva::with(['hospedajehabitacion',
                                'hospedajehabitacion.adelantos',
                                ])->where('id',$request->IdReserva)->get();
                                
        return response()->json($llevardatos);
    }

    public function ConcluirReservaHabitacion($id){
        $reserva = Reserva::where('id',$id)->first();
        $hospedaje = HospedajeHabitacion::where('id',$reserva->hospedaje_habitacion_id)->first();
        $habitacion = Habitacion::where('id',$hospedaje->habitacion_id)->first();

        if($habitacion->Estado_habitacion == "DISPONIBLE"){
            $reserva = Reserva::where('id',$id)->first();
            $reserva->EstadoReserva = "Concluido";
            $reserva->save();
            
            $fechaIngreso = Carbon::parse($reserva->ingreso_reserva);
            $fechaSalida = Carbon::parse($reserva->salida_reserva);
        
            if ($fechaIngreso->isSameDay($fechaSalida)) {
                $cantidadDias = 1;
            } else {
                $cantidadDias = $fechaIngreso->diffInDays($fechaSalida);
            }
    
            $hospedaje = HospedajeHabitacion::where('id',$reserva->hospedaje_habitacion_id)->first();
            $hospedaje->EstadoHospedaje = "true";
            $hospedaje->EstadoReserva = "false";
            $hospedaje->ingreso_hospedaje = $fechaIngreso;
            $hospedaje->salida_hospedaje = $fechaSalida;
            $hospedaje->dias_hospedarse = $cantidadDias;
            $hospedaje->CategoriaHabitacion = $reserva->CategoriaHabitacion;
            $hospedaje->CambioDolar = $reserva->PrecioDolar;
            $hospedaje->CambioBolivianos = $reserva->PrecioBolivianos;
            $hospedaje->Total = $reserva->PrecioBolivianos;
            $hospedaje->TotalHospedaje = $reserva->PrecioBolivianos;
            $hospedaje->SubTotal = $reserva->PrecioBolivianos;
            $hospedaje->save();
    
            $habitacion = Habitacion::where('id',$hospedaje->habitacion_id)->first();
            $habitacion->Estado_habitacion = "OCUPADO";
            $habitacion->save();
            
            return response()->json($reserva);
        }else{
            return response()->json("La Habitacion No Esta Disponible.");
        }
        
    }

    public function GetDatosReservasHabitacion(){
        $reserva = Reserva::get();
        return response()->json($reserva);
    }


    public function CancelarReservasHabitacion(Request $request){
        $reserva = Reserva::where('id',$request->id)->first();
        $reserva->ReservaCancelado = "si";
        $reserva->EstadoReserva = "Cancelado";
        $reserva->ComentarioCancelado = $request->Textrazoncancelar;
        $reserva->save();

        $hospedaje = HospedajeHabitacion::where('id',$reserva->hospedaje_habitacion_id)->first();
        $hospedaje->HospedajeCancelado = "si";
        $hospedaje->save();

        return response()->json($reserva);
    }
    
}
