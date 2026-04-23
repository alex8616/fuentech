<?php

namespace App\Http\Controllers;

use App\Models\HospedajeHabitacion;
use App\Models\Habitacion;
use App\Models\DetalleHospedajeHabitacion;
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
use App\Models\Salones;
use App\Models\ReservaSalones;
use App\Models\DetalleStockDate;
use App\Models\GrupoHospedaje;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\CambiarEstadoTurnosTrait;
use App\Traits\GenerarCodigoHospedajeTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class HospedajeHabitacionController extends Controller
{
    use CambiarEstadoTurnosTrait;
    use GenerarCodigoHospedajeTrait;

    public function OcuparHabitacionHospedaje(Request $request){
        $fechaIngreso = Carbon::parse($request->fechaIngreso);
        $fechaSalida = Carbon::parse($request->fechaSalida);
    
        if ($fechaIngreso->isSameDay($fechaSalida)) {
            $cantidadDias = 1;
        } else {
            $cantidadDias = $fechaIngreso->diffInDays($fechaSalida);
        }
        
        $user = Auth::user();

        if($request->PrecioHabitacion == 0){
            $precioxnoche = $request->bolivianoInput/$cantidadDias;
            $hospedaje = HospedajeHabitacion::create([
                'ingreso_hospedaje' => $request->fechaIngreso,
                'hora_ingreso_hospedaje' => $request->horaIngreso,
                'salida_hospedaje' => $request->fechaSalida,
                'procedencia_hospedaje' => $request->procedencia,
                'destino_hospedaje' => $request->destino,
                'dias_hospedarse' => $cantidadDias,
                'Precio_habitacion' => $precioxnoche,
                'Total' => $request->bolivianoInput,
                'user_id' => $user->id,
                'habitacion_id' => $request->habitacionId,
                'TotalHospedaje' => $request->bolivianoInput,
                'TotalServicio' => 0.00,
                'TotalConsumo' => 0.00,
                'Adelanto' => 0.00,
                'TotalGeneralHospedaje' => 0.00,
                'CategoriaHabitacion' => $request->categoriaHabitacion,
                'CamaraHotelera' => 'false',
                'SubTotal' => $request->bolivianoInput,
                'CambioBolivianos' => $request->bolivianoInput,
                'CambioDolar' => $request->dolarInput,
                'CodigoHospedaje' => $this->generarCodigoHospedajeUnico(),
            ]);
        }else{
            $totalhospedaje = $request->PrecioHabitacion*$cantidadDias;
            $hospedaje = HospedajeHabitacion::create([
                'ingreso_hospedaje' => $request->fechaIngreso,
                'hora_ingreso_hospedaje' => $request->horaIngreso,
                'salida_hospedaje' => $request->fechaSalida,
                'procedencia_hospedaje' => $request->procedencia,
                'destino_hospedaje' => $request->destino,
                'dias_hospedarse' => $cantidadDias,
                'Precio_habitacion' => $request->PrecioHabitacion,
                'Total' => $totalhospedaje,
                'user_id' => $user->id,
                'habitacion_id' => $request->habitacionId,
                'TotalHospedaje' => $totalhospedaje,
                'TotalServicio' => 0.00,
                'TotalConsumo' => 0.00,
                'Adelanto' => 0.00,
                'TotalGeneralHospedaje' => 0.00,
                'CategoriaHabitacion' => $request->categoriaHabitacion,
                'CamaraHotelera' => 'false',
                'SubTotal' => $totalhospedaje,
                'CambioBolivianos' => 0.00,
                'CambioDolar' => 0.00,
                'CodigoHospedaje' => $this->generarCodigoHospedajeUnico()
            ]);
        }
        

        $servicio = Servicio::create([
            'hospedaje_habitacion_id' => $hospedaje->id,
            'user_id' => $user->id,
            'FechaRegistro_servicio' => $request->fechaIngreso,
            'FechaCierre' => null,
            'ServicioComentario' => "Servicios para la habitacion #".$request->habitacionId,
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
            'ServicioComentario' => "Servicios para la habitacion #".$request->habitacionId,
            'subTotal' => 0,
            'totalpagado' => 0,
            'total' => 0,
            'totalgeneral' => 0,
        ]);

        $habitacion = Habitacion::where('id',$request->habitacionId)->first();
        $habitacion->Estado_habitacion = 'OCUPADO';
        $habitacion->save();
        return response()->json($hospedaje);

    }
    
    public function GetHabitacionOcupada($id){
        $habitacion = Habitacion::where('id', $id)
                    ->where("Estado_habitacion", "OCUPADO")
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('EstadoHospedaje', "true");
                    })
                    ->with([
                        'hospedajehabitacion' => function ($query) {
                            $query->where('EstadoHospedaje', "true")
                                ->latest('id')
                                ->limit(1);
                        },
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
                        'hospedajehabitacion.reservas',
                    ])
                    ->first();

        return response()->json($habitacion);
    }
    
    public function UpdateHabitacionOcupada(Request $request){
        //return response()->json($request);
        $preciohab = 0;
        if($request->UpdateCambioBolivianos && $request->UpdateCambioDolar){
            $hospedaje = HospedajeHabitacion::where('id',$request->HospedajeId)->first();
            $hospedaje->CategoriaHabitacion = $request->UpdateCategoriaHabitacion;
            $hospedaje->CambioBolivianos = $request->UpdateCambioBolivianos;
            $hospedaje->CambioDolar = $request->UpdateCambioDolar;
            $hospedaje->ingreso_hospedaje = $request->UpdateFechaIngreso;
            $hospedaje->salida_hospedaje = $request->UpdateFechaSalida;
            $hospedaje->Total = $request->UpdatePrecioHabitacion;
            $hospedaje->procedencia_hospedaje = $request->EditProcedencia;
            $hospedaje->destino_hospedaje = $request->EditDestino;
            $hospedaje->save();

            $fechaIngreso = Carbon::parse($hospedaje->ingreso_hospedaje);
            $fechaSalida = Carbon::parse($hospedaje->salida_hospedaje);
        
            if ($fechaIngreso->isSameDay($fechaSalida)) {
                $cantidadDias = 1;
            } else {
                $cantidadDias = $fechaIngreso->diffInDays($fechaSalida);
            }
            
            $preciohab = $request->UpdateCambioBolivianos/$cantidadDias; 
            $hospedaje->dias_hospedarse = $cantidadDias;
            $hospedaje->Precio_habitacion = $preciohab;  
            $hospedaje->TotalHospedaje = $request->UpdateCambioBolivianos;
            $hospedaje->save();

        }else{
            $hospedaje = HospedajeHabitacion::where('id',$request->HospedajeId)->first();
            $hospedaje->CategoriaHabitacion = $request->UpdateCategoriaHabitacion;
            $hospedaje->Precio_habitacion = $request->UpdatePrecioHabitacion;
            $hospedaje->ingreso_hospedaje = $request->UpdateFechaIngreso;
            $hospedaje->salida_hospedaje = $request->UpdateFechaSalida;
            $hospedaje->Total = $request->UpdatePrecioHabitacion;
            $hospedaje->procedencia_hospedaje = $request->EditProcedencia;
            $hospedaje->destino_hospedaje = $request->EditDestino;
            $hospedaje->save();

            $fechaIngreso = Carbon::parse($hospedaje->ingreso_hospedaje);
            $fechaSalida = Carbon::parse($hospedaje->salida_hospedaje);
        
            if ($fechaIngreso->isSameDay($fechaSalida)) {
                $cantidadDias = 1;
            } else {
                $cantidadDias = $fechaIngreso->diffInDays($fechaSalida);
            }
            
            $preciohab = $hospedaje->Precio_habitacion*$cantidadDias; 
            $hospedaje->dias_hospedarse = $cantidadDias;
            $hospedaje->TotalHospedaje = $preciohab;
            $hospedaje->save();
        }

        $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
        $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
        $hospedaje->save();
        
        return response()->json($hospedaje);
    }

    public function AgregarHospedajeCliente(Request $request){
        $idClientes = $request->input('IdCliente');
        $idHospedaje = $request->input('IdHospedaje');
        foreach ($idClientes as $idCliente) {
            $detalles = DetalleHospedajeHabitacion::create([
                'hospedaje_habitacion_id' => $idHospedaje,
                'cliente_id' => $idCliente,
            ]);
        }
        return response()->json($idHospedaje);
    }

    public function EliminarDetalleHospedajeCliente(Request $request) {
        try {
            $detalle = DetalleHospedajeHabitacion::find($request->DetalleHospedajeId);
            
            if ($detalle) {
                $detalle->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Eliminado correctamente.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al intentar eliminar el detalle del hospedaje.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function RegistrarServicioDesayunoHostal(Request $request){
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $id = $request->IdHospedaje;
        $hospedaje = HospedajeHabitacion::where('id', $id)->with('servicios')->first();
        $servicio = $hospedaje->servicios[0]->id;
        
        $detalleservicio = DetalleServicio::create([
            'servicio_id' => $servicio,
            'TipoServicio' => "Desayuno",
            'fecha_venta' => $request->InputFechaDesayuno,
            'comentario' => $request->DesayunoComentario,
            'eliminado' => "false",
            'comentarioeliminado' => "null",
            'cantidad' => $request->InputCantidadDesayuno,
            'precio' => $request->InputPrecioDesayuno,
            'total' => $request->InputTotalDesayuno
        ]);

        $valorservicio = Servicio::where('id', $servicio)->first();
        $valorservicio->subTotalDesayuno += $request->InputTotalDesayuno;
        $valorservicio->totalDesayuno = $valorservicio->subTotalDesayuno-$valorservicio->totalpagadoDesayuno;
        $valorservicio->totalgeneral = $valorservicio->totalDesayuno+$valorservicio->totalLavado;
        $valorservicio->save();

        $hospedaje->TotalServicio = $valorservicio->totalgeneral;
        $hospedaje->save();
        $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
        $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
        $hospedaje->save();

        $caja = Caja::latest()->first();
        if($caja && $request->DesayunoEstadoPagoSelect == "Pagado"){                       
            if($request->DesayunoTipoPagoSelect == "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalRestaurante'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Servicio de Desayuno Extra, de la habitacion #" . $hospedaje->habitacion_id." Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." desayunos.",
                    'Ingreso' => $request->InputTotalDesayuno,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $detalleservicio->id,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_restaurante_ingreso += $request->InputTotalDesayuno;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalRestaurante'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->DesayunoTipoPagoSelect == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Servicio de Desayuno Extra, de la habitacion #" .$hospedaje->habitacion_id." Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." desayunos.",
                    'Ingreso' => $request->InputTotalDesayuno,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $detalleservicio->id,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_tarjetas_ingreso += $request->InputTotalDesayuno;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->DesayunoTipoPagoSelect == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Servicio de Desayuno Extra, de la habitacion #" .$hospedaje->habitacion_id." Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." desayunos.",
                    'Ingreso' => $request->InputTotalDesayuno,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $detalleservicio->id,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_depositos_ingreso += $request->InputTotalDesayuno;
                $caja->save();
                
                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            $serviciohospedaje = Servicio::where('id', $servicio)->first();
            $serviciohospedaje->totalpagadoDesayuno += $request->InputTotalDesayuno;
            $serviciohospedaje->totalDesayuno = $serviciohospedaje->subTotalDesayuno-$serviciohospedaje->totalpagadoDesayuno;
            $serviciohospedaje->totalgeneral = $serviciohospedaje->totalDesayuno+$serviciohospedaje->totalLavado;
            $serviciohospedaje->save();

            $hospedaje->TotalServicio = $serviciohospedaje->totalgeneral;
            $hospedaje->save();
            $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
            $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
            $hospedaje->save();

            $detalleservicio->pagado = "true";
            $detalleservicio->tipopago = $request->DesayunoTipoPagoSelect;
            $detalleservicio->save();

            return response()->json($detalleservicio->pagado);
        }
    }

    public function RegistrarServicioLavadoHostal(Request $request){
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $id = $request->IdHospedaje;
        $hospedaje = HospedajeHabitacion::where('id', $id)->with('servicios')->first();
        $servicio = $hospedaje->servicios[0]->id;
        
        $detalleservicio = DetalleServicio::create([
            'servicio_id' => $servicio,
            'TipoServicio' => "Lavado",
            'fecha_venta' => $request->InputFechaLavado,
            'comentario' => $request->LavadoComentario,
            'eliminado' => "false",
            'comentarioeliminado' => null,
            'cantidad' => $request->InputKiloLavado,
            'precio' => $request->InputPrecioLavado,
            'total' => $request->InputTotalLavado,  
        ]);

        $valorservicio = Servicio::where('id', $servicio)->first();
        $valorservicio->subTotalLavado += $request->InputTotalLavado;
        $valorservicio->totalLavado = $valorservicio->subTotalLavado-$valorservicio->totalpagadoLavado;
        $valorservicio->totalgeneral = $valorservicio->totalDesayuno+$valorservicio->totalLavado;
        $valorservicio->save();

        $hospedaje->TotalServicio = $valorservicio->totalgeneral;
        $hospedaje->save();
        $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
        $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
        $hospedaje->save();

        $caja = Caja::latest()->first();
        if($caja && $request->LavadoEstadoPagoSelect == "Pagado"){
            if($request->LavadoTipoPagoSelect== "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalHostal'),
                    'articulo_caja_id' => 55,
                    'Articulo_description' => "Servicio de Lavanderia, de la habitacion #" . $hospedaje->habitacion_id. " Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$request->InputKiloLavado." kilos.",
                    'Ingreso' => $request->InputTotalLavado,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $hospedaje->id,
                    'TipoServicioPrestado' => 'Servicio',
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

            if($request->LavadoTipoPagoSelect == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 55,
                    'Articulo_description' => "Servicio de Lavanderia, de la habitacion #" . $hospedaje->habitacion_id. " Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$request->InputKiloLavado." kilos.",
                    'Ingreso' => $request->InputTotalLavado,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $hospedaje->id,
                    'TipoServicioPrestado' => 'Servicio',
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

            if($request->LavadoTipoPagoSelect == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 55,
                    'Articulo_description' => "Servicio de Lavanderia, de la habitacion #" . $hospedaje->habitacion_id. " Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$request->InputKiloLavado." kilos.",
                    'Ingreso' => $request->InputTotalLavado,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $hospedaje->id,
                    'TipoServicioPrestado' => 'Servicio',
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

            $serviciohospedaje = Servicio::where('id', $servicio)->first();
            $serviciohospedaje->totalpagadoLavado += $request->InputTotalLavado;
            $serviciohospedaje->totalLavado = $serviciohospedaje->subTotalLavado-$serviciohospedaje->totalpagadoLavado;
            $serviciohospedaje->totalgeneral = $serviciohospedaje->totalDesayuno+$serviciohospedaje->totalLavado;
            $serviciohospedaje->save();

            $hospedaje->TotalServicio = $serviciohospedaje->totalgeneral;
            $hospedaje->save();
            $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
            $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
            $hospedaje->save();
            
            $detalleservicio->pagado = "true";
            $detalleservicio->tipopago = $request->LavadoTipoPagoSelect;
            $detalleservicio->save();
            
            return response()->json($detalleservicio);
        }        
    }

    public function EntregarServicioLavadoHostal(Request $request){
        $detalleservicio = DetalleServicio::where('id', $request->id)->first();
        $detalleservicio->lavado = "Entregado";
        $detalleservicio->fecha_cierre = now();
        $detalleservicio->save();
        return response()->json($detalleservicio);
    }

    public function ActualizarServicioDesayunoHostal(Request $request){
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $detalleservicio = DetalleServicio::where('id', $request->DetalleServicioDesayuno)->first();
        $detalleservicio->pagado = "true";
        $detalleservicio->fecha_cierre = now();
        $detalleservicio->tipopago = $request->ModalDesayunoTipoPagoSelect;
        $detalleservicio->save();

        $servicio = Servicio::where('id', $detalleservicio->servicio_id)->first();
        $servicio->totalpagadoDesayuno += $detalleservicio->total;
        $servicio->totalDesayuno = $servicio->subTotalDesayuno-$servicio->totalpagadoDesayuno;
        $servicio->totalgeneral = $servicio->totalDesayuno+$servicio->totalLavado;
        $servicio->save();

        $hospedaje = HospedajeHabitacion::where('id', $servicio->hospedaje_habitacion_id)->first();

        $caja = Caja::latest()->first();
        if($caja){
            if($request->ModalDesayunoTipoPagoSelect == "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalRestaurante'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Servicio de Desayuno Extra, de la habitacion #" . $request->habitacionId." Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." desayunos.",
                    'Ingreso' => $detalleservicio->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $request->DetalleServicioDesayuno,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_restaurante_ingreso += $detalleservicio->total;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalRestaurante'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->ModalDesayunoTipoPagoSelect == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Servicio de Desayuno Extra, de la habitacion #" . $request->habitacionId." Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." desayunos.",
                    'Ingreso' => $detalleservicio->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $request->DetalleServicioDesayuno,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_tarjetas_ingreso += $detalleservicio->total;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->ModalDesayunoTipoPagoSelect == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Servicio de Desayuno Extra, de la habitacion #" . $request->habitacionId." Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." desayunos.",
                    'Ingreso' => $detalleservicio->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $request->DetalleServicioDesayuno,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_depositos_ingreso += $detalleservicio->total;
                $caja->save();
                
                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }
        }

        $hospedaje->TotalServicio = $servicio->totalgeneral;
        $hospedaje->save();
        $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
        $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
        $hospedaje->save();
        
        return response()->json($detalleservicio);
    }

    public function ActualizarServicioLavadoHostal(Request $request){
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $detalleservicio = DetalleServicio::where('id', $request->DetalleServicioDesayuno)->first();
        $detalleservicio->pagado = "true";
        $detalleservicio->fecha_cierre = now();
        $detalleservicio->tipopago = $request->ModalLavadoTipoPagoSelect;
        $detalleservicio->save();

        $servicio = Servicio::where('id', $detalleservicio->servicio_id)->first();
        $servicio->totalpagadoLavado += $detalleservicio->total;
        $servicio->totalLavado = $servicio->subTotalLavado-$servicio->totalpagadoLavado;
        $servicio->totalgeneral = $servicio->totalDesayuno+$servicio->totalLavado;
        $servicio->save();

        $hospedaje = HospedajeHabitacion::where('id', $servicio->hospedaje_habitacion_id)->first();

        $caja = Caja::latest()->first();
        if($caja){
            if($request->ModalLavadoTipoPagoSelect == "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalHostal'),
                    'articulo_caja_id' => 55,
                    'Articulo_description' => "Servicio de Lavanderia, de la habitacion #" . $hospedaje->habitacion_id. " Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." kilos.",
                    'Ingreso' => $detalleservicio->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $request->DetalleServicioDesayuno,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_hostal_ingreso += $detalleservicio->total;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalHostal'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $datecaja) {
                    $ingresoAcumulado += $datecaja->Ingreso;
                    $egresoAcumulado += $datecaja->Egreso;
                    $datecaja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $datecaja->save();
                }
            }

            if($request->ModalLavadoTipoPagoSelect == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 55,
                    'Articulo_description' => "Servicio de Lavanderia, de la habitacion #" . $hospedaje->habitacion_id. " Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." kilos.",
                    'Ingreso' => $detalleservicio->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $request->DetalleServicioDesayuno,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_tarjetas_ingreso += $detalleservicio->total;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->ModalLavadoTipoPagoSelect == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 55,
                    'Articulo_description' => "Servicio de Lavanderia, de la habitacion #" . $hospedaje->habitacion_id. " Codigo De hospedaje ".$hospedaje->CodigoHospedaje." fueron ".$detalleservicio->cantidad." kilos.",
                    'Ingreso' => $detalleservicio->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $request->DetalleServicioDesayuno,
                    'TipoServicioPrestado' => 'Servicio',
                ]);

                $caja->caja_depositos_ingreso += $detalleservicio->total;
                $caja->save();
                
                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }
        }

        $hospedaje->TotalServicio = $servicio->totalgeneral;
        $hospedaje->save();
        $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
        $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
        $hospedaje->save();

        return response()->json($detalleservicio);
    }

    public function GetConsumoHospedaje($id){
        $hospedaje = HospedajeHabitacion::where('id',$id)->with(['servicioconsumos','servicioconsumos.consumo','servicioconsumos.consumo.detalleconsumos'])->first();
        return response()->json($hospedaje);
    }

    public function GetConsumoSelectPrivate($id){
        $consumo = Consumo::where('id',$id)
                            ->with([
                                'camarero',
                                'detalleconsumos.producto',
                                'detalleconsumos.producto.modificadore',
                                'detalleconsumos.producto.modificadore.detallemodificador',
                                'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                'detalleconsumos.modificadordetalleconsumo',
                                'descuentoconsumos',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                                'pagosconsumos',
                            ])->first();
        return response()->json($consumo);
    }

    public function GetConsumo($id){
        $consumo = Consumo::where('id',$id)->with(['descuentoconsumos',
                                                    'detalleconsumos',
                                                    'detalleconsumos.producto',
                                                    'detalleconsumos.modificadordetalleconsumo',                                                    
                                                    ])->first();
        return response()->json($consumo);
    }

    public function RegistrarConsumoHospedaje(Request $request){
        //return response()->json($request);
        $hospedaje = HospedajeHabitacion::where('id', $request->IdHospedaje)->first();
        $servicioconsumo = ServicioConsumo::where('hospedaje_habitacion_id', $request->IdHospedaje)->first();
        $user = Auth::user();
        $turnoscambiadoestado = $this->CambiarEstadoTurnos();
        $turnoActivo = $turnoscambiadoestado->firstWhere('Estado', 'true');
        $consumo = Consumo::create([
            'CantidadPersonas' => 0,
            'empresa_id' => $user->empresa_id,
            'user_id' => $user->id,
            'cliente_id' => null,
            'camarero_id' => null,
            'ambiente_mesa_id' => null,
            'fecha_venta' => now(),
            'total' => 0,
            'subTotal' => 0,
            'Comentario' => "Consumo Para Habitacion #".$hospedaje->habitacion_id,
            'ocupado' => 'true',
            'turno_id' => $turnoActivo->id,
            'TipoConsumo' => 'Habitacion',
            'servicio_consumo_id' => $servicioconsumo->id,
        ]);

        return response()->json($consumo);
    }

    public function RegistrarDetalleConsumoHospedaje(Request $request){        
        try {
            foreach ($request->all() as $producto) {
                $totalmodificador = 0;
                $consumoId = $producto['consumoId'];
                $productoId = $producto['Idproducto'];
                $cantidad = $producto['cantidad'];
                $comentario = $producto['comentario'];
                $precio = $producto['precio'];
                $modificadores = $producto['Modificadores'];                         
    
                $ExiteProducto = Producto::where('id', $productoId)->first();
                $consumo = Consumo::where('id', $consumoId)->first();
                $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->first();
                $hospedaje = HospedajeHabitacion::where('id', $servicioconsumo->hospedaje_habitacion_id)->first();

                if ($ExiteProducto->ControlStock == "true") {
                    $stock = StockDate::where('producto_id', $ExiteProducto->id)->first();

                    if($stock->Cantidad > 0 && $stock->Cantidad >= $cantidad){                           
                        $detalleConsumo = DetalleConsumo::create([
                            'producto_id' => $productoId,
                            'consumo_id' => $consumoId,
                            'fecha_venta' => now(),
                            'comentario' => $comentario,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'total' => $precio * $cantidad,
                            'eliminado' => 'false',
                            'comentarioeliminado' => '',
                        ]);
    
                        $cantidadanterior = $stock->Cantidad;
                        $cantidadactual = $stock->Cantidad - $cantidad;
                        $stock->Cantidad -= $cantidad;
                        $stock->save();
                        
                        if($consumo->TipoConsumo == "Salon"){
                            $valortiposervicio = "Salon";
                            $valordescripcion = "Consumo en Habitacion #".$hospedaje->habitacion_id." - ".$hospedaje->CodigoHospedaje." - ".$ExiteProducto->NombreProducto;
                        }

                        if($consumo->TipoConsumo == "Habitacion"){
                            $valortiposervicio = "Habitacion";
                            $valordescripcion = "Consumo en Habitacion #".$hospedaje->habitacion_id." - ".$hospedaje->CodigoHospedaje." - ".$ExiteProducto->NombreProducto;
                        }

                        $stockdate = DetalleStockDate::create([
                            'TipoStock' => "Salida",
                            'StockAnterior' => $cantidadanterior,
                            'StockActual' => $cantidadactual,
                            'Diferencia' => $cantidad,
                            'DetalleStock' => $valordescripcion,
                            'FechaStock' => now(),
                            'stock_dates_id' => $stock->id,
                            'TipoServicio' => $valortiposervicio, 
                            'IdTipoServicio' => $hospedaje->id,
                        ]);
                    }else{
                        return response()->json("El Stock Del Producto Es Menor a La cantidad");
                    }
                } else {
                    $detalleConsumo = DetalleConsumo::create([
                        'producto_id' => $productoId,
                        'consumo_id' => $consumoId,
                        'fecha_venta' => now(),
                        'comentario' => $comentario,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $precio * $cantidad,
                        'eliminado' => 'false',
                        'comentarioeliminado' => '',
                    ]);
                } 
    
                foreach ($modificadores as $modificador) {
                    if ($modificador['Checkbox']) {
                        $ModificadorPrecio = $modificador['CostoDetalleModificador'];
                        $ModificadorCantidad = $modificador['Cantidad'];
    
                        $detallemodificadore = ModificadorDetalleConsumo::create([
                            'detalle_modificadore_id' => $modificador['id'],
                            'detalle_consumo_id' => $detalleConsumo->id,
                            'fecha_venta' => now(),
                            'comentario' => "nada",
                            'cantidad' => $ModificadorCantidad,
                            'precio' => $ModificadorPrecio,
                            'total' => $ModificadorCantidad * $ModificadorPrecio,
                            'eliminado' => 'false',
                            'comentarioeliminado' => '',
                        ]);
                        $totalmodificador += $ModificadorPrecio * $ModificadorCantidad;
                    }
                }                
    
                $consumo->subTotal += $precio * $cantidad + $totalmodificador;
                $consumo->total = $consumo->subTotal;
                $consumo->save();

                $descuentoPorcentaje = DescuentoConsumo::where('consumo_id', $consumoId)->get();
                foreach ($descuentoPorcentaje as $descuento) {
                    if ($descuento->TipoDescuento == 'porcentaje') {
                        $totalDescuento = ($consumo->subTotal * $descuento->MontoDescuento) / 100;
                        $descuento->TotalDescuento = $totalDescuento;
                        $descuento->save();
                    }
                }
    
                $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
                $valorfinal = $consumo->total - $SumDescuentoSubtotal;
                $consumo->total = $valorfinal;
                $consumo->save();

                $SCsubtotal = 0;
                $SCtotalpagado = 0;
                $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->with('consumo')->first();
                if ($servicioconsumo && $servicioconsumo->consumo) {
                    foreach ($servicioconsumo->consumo as $misconsumos) {
                        $SCsubtotal += $misconsumos->total;
                        if($misconsumos->ocupado != "true"){
                            $SCtotalpagado += $misconsumos->total; 
                        }
                    }
                }
                $servicioconsumo->subTotal = $SCsubtotal;
                $servicioconsumo->totalpagado = $SCtotalpagado;
                $servicioconsumo->total = $SCsubtotal - $SCtotalpagado;
                $servicioconsumo->totalgeneral = $servicioconsumo->total;
                $servicioconsumo->save();
            }
            
            
            $hospedaje->TotalConsumo = $servicioconsumo->totalgeneral;
            $hospedaje->save();
            $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
            $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
            $hospedaje->save();

            return response()->json(['message' => $consumo]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function RegistrarDetalleConsumoReservaSalon(Request $request){
        //return response()->json($request);

        try {
            foreach ($request->all() as $producto) {
                $totalmodificador = 0;
                $consumoId = $producto['consumoId'];
                $productoId = $producto['Idproducto'];
                $cantidad = $producto['cantidad'];
                $comentario = $producto['comentario'];
                $precio = $producto['precio'];
                $modificadores = $producto['Modificadores'];                         
    
                $consumo = Consumo::where('id',$consumoId)->first();

                $ExiteProducto = Producto::where('id', $productoId)->first();
    
                if ($ExiteProducto->ControlStock == "true") {
                    $stock = StockDate::where('producto_id', $ExiteProducto->id)->first();
    
                    if($stock->Cantidad > 0 && $stock->Cantidad >= $cantidad){                           
                        $detalleConsumo = DetalleConsumo::create([
                            'producto_id' => $productoId,
                            'consumo_id' => $consumoId,
                            'fecha_venta' => now(),
                            'comentario' => $comentario,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'total' => $precio * $cantidad,
                            'eliminado' => 'false',
                            'comentarioeliminado' => '',
                        ]);
    
                        $cantidadanterior = $stock->Cantidad;
                        $cantidadactual = $stock->Cantidad - $cantidad;
                        $stock->Cantidad -= $cantidad;
                        $stock->save();
                        
                        $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->first();
                        $reservasalon = ReservaSalones::where('id', $servicioconsumo->reserva_salones_id)->first();
                        $salon = Salones::where('id', $reservasalon->salones_id)->first();

                        if($consumo->TipoConsumo == "Salon"){
                            $valortiposervicio = "Salon";
                            $valordescripcion = "Consumo en ".$salon->Nombre_salon." - ".$ExiteProducto->NombreProducto;
                        }

                        $stockdate = DetalleStockDate::create([
                            'TipoStock' => "Salida",
                            'StockAnterior' => $cantidadanterior,
                            'StockActual' => $cantidadactual,
                            'Diferencia' => $cantidad,
                            'DetalleStock' => $valordescripcion,
                            'FechaStock' => now(),
                            'stock_dates_id' => $stock->id,
                            'TipoServicio' => $valortiposervicio, 
                            'IdTipoServicio' => $reservasalon->id,
                        ]);
                    }else{
                        return response()->json("El Stock Del Producto Es Menor a La cantidad");
                    }
                } else {
                    $detalleConsumo = DetalleConsumo::create([
                        'producto_id' => $productoId,
                        'consumo_id' => $consumoId,
                        'fecha_venta' => now(),
                        'comentario' => $comentario,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $precio * $cantidad,
                        'eliminado' => 'false',
                        'comentarioeliminado' => '',
                    ]);
                } 
    
                foreach ($modificadores as $modificador) {
                    if ($modificador['Checkbox']) {
                        $ModificadorPrecio = $modificador['CostoDetalleModificador'];
                        $ModificadorCantidad = $modificador['Cantidad'];
    
                        $detallemodificadore = ModificadorDetalleConsumo::create([
                            'detalle_modificadore_id' => $modificador['id'],
                            'detalle_consumo_id' => $detalleConsumo->id,
                            'fecha_venta' => now(),
                            'comentario' => "nada",
                            'cantidad' => $ModificadorCantidad,
                            'precio' => $ModificadorPrecio,
                            'total' => $ModificadorCantidad * $ModificadorPrecio,
                            'eliminado' => 'false',
                            'comentarioeliminado' => '',
                        ]);
                        $totalmodificador += $ModificadorPrecio * $ModificadorCantidad;
                    }
                }                
    
                $consumo->subTotal += $precio * $cantidad + $totalmodificador;
                $consumo->total = $consumo->subTotal;
                $consumo->save();

                $descuentoPorcentaje = DescuentoConsumo::where('consumo_id', $consumoId)->get();
                foreach ($descuentoPorcentaje as $descuento) {
                    if ($descuento->TipoDescuento == 'porcentaje') {
                        $totalDescuento = ($consumo->subTotal * $descuento->MontoDescuento) / 100;
                        $descuento->TotalDescuento = $totalDescuento;
                        $descuento->save();
                    }
                }
    
                $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
                $valorfinal = $consumo->total - $SumDescuentoSubtotal;
                $consumo->total = $valorfinal;
                $consumo->save();

                $SCsubtotal = 0;
                $SCtotalpagado = 0;
                $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->with('consumo')->first();
                if ($servicioconsumo && $servicioconsumo->consumo) {
                    foreach ($servicioconsumo->consumo as $misconsumos) {
                        $SCsubtotal += $misconsumos->total;
                        if($misconsumos->ocupado != "true"){
                            $SCtotalpagado += $misconsumos->total; 
                        }
                    }
                }
                $servicioconsumo->subTotal = $SCsubtotal;
                $servicioconsumo->totalpagado = $SCtotalpagado;
                $servicioconsumo->total = $SCsubtotal - $SCtotalpagado;
                $servicioconsumo->totalgeneral = $servicioconsumo->total;
                $servicioconsumo->save();
            }
            
            $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->first();
            $reservasalon = ReservaSalones::where('id', $servicioconsumo->reserva_salones_id)->first();
            $reservasalon->TotalConsumo = $servicioconsumo->totalgeneral;
            $reservasalon->save();
            $reservasalon->SubTotal = $reservasalon->Totalsalon+$reservasalon->TotalServicio+$reservasalon->TotalConsumo;
            $reservasalon->total = $reservasalon->SubTotal-$reservasalon->Adelanto;
            $reservasalon->save();

            return response()->json(['message' => $consumo]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function CerrarConsumoHabitacion(Request $request){
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;

        $consumo = Consumo::where('id', $request->id)->first();    
        $consumo->ocupado = "false";
        $consumo->save();

        $pagos = Pagos::create([
            'TipoPago' => $request->ModalConsumoTipoPagoSelect,
            'FechaDePago' => now(),
            'TotalPago' => $consumo->total,
            'consumo_id' => $request->id,
        ]);

        $SCsubtotal = 0;
        $SCtotalpagado = 0;
        $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->with('consumo')->first();
        if ($servicioconsumo && $servicioconsumo->consumo) {
            foreach ($servicioconsumo->consumo as $misconsumos) {
                $SCsubtotal += $misconsumos->total;
                if($misconsumos->ocupado != "true"){
                    $SCtotalpagado += $misconsumos->total; 
                }
            }
        }
        $servicioconsumo->subTotal = $SCsubtotal;
        $servicioconsumo->totalpagado = $SCtotalpagado;
        $servicioconsumo->total = $SCsubtotal - $SCtotalpagado;
        $servicioconsumo->totalgeneral = $servicioconsumo->total;
        $servicioconsumo->save();

        $hospedaje = HospedajeHabitacion::where('id', $servicioconsumo->hospedaje_habitacion_id)->first();
        $hospedaje->TotalConsumo = $servicioconsumo->totalgeneral;
        $hospedaje->save();
        $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
        $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
        $hospedaje->save();

        $caja = Caja::latest()->first();
        if($caja){
            if($request->ModalConsumoTipoPagoSelect== "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalRestaurante'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Consumo Habitacion #" . $hospedaje->habitacion_id ." Codigo De hospedaje ".$hospedaje->CodigoHospedaje,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_restaurante_ingreso += $consumo->total;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalRestaurante'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->ModalConsumoTipoPagoSelect == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Consumo Habitacion #" . $hospedaje->habitacion_id ." Codigo De hospedaje ".$hospedaje->CodigoHospedaje,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_tarjetas_ingreso += $consumo->total;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->ModalConsumoTipoPagoSelect == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Consumo Habitacion #" . $hospedaje->habitacion_id ." Codigo De hospedaje ".$hospedaje->CodigoHospedaje,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_depositos_ingreso += $consumo->total;
                $caja->save();
                
                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }
        } 

        return response()->json($consumo);
    }

    public function CerrarConsumoReservaSalon(Request $request){
        //return response()->json($request);

        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;

        $consumo = Consumo::where('id', $request->id)->first();    
        $consumo->ocupado = "false";
        $consumo->save();

        $pagos = Pagos::create([
            'TipoPago' => $request->ModalConsumoTipoPagoSelect,
            'FechaDePago' => now(),
            'TotalPago' => $consumo->total,
            'consumo_id' => $request->id,
        ]);

        $SCsubtotal = 0;
        $SCtotalpagado = 0;
        $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->with('consumo')->first();
        if ($servicioconsumo && $servicioconsumo->consumo) {
            foreach ($servicioconsumo->consumo as $misconsumos) {
                $SCsubtotal += $misconsumos->total;
                if($misconsumos->ocupado != "true"){
                    $SCtotalpagado += $misconsumos->total; 
                }
            }
        }
        $servicioconsumo->subTotal = $SCsubtotal;
        $servicioconsumo->totalpagado = $SCtotalpagado;
        $servicioconsumo->total = $SCsubtotal - $SCtotalpagado;
        $servicioconsumo->totalgeneral = $servicioconsumo->total;
        $servicioconsumo->save();

        $reservasalon = ReservaSalones::where('id', $servicioconsumo->reserva_salones_id)->first();
        $reservasalon->TotalConsumo = $servicioconsumo->totalgeneral;
        $reservasalon->save();
        $reservasalon->SubTotal = $reservasalon->Totalsalon+$reservasalon->TotalServicio+$reservasalon->TotalConsumo;
        $reservasalon->total = $reservasalon->SubTotal-$reservasalon->Adelanto;
        $reservasalon->save();

        $caja = Caja::latest()->first();
        if($caja){
            if($request->ModalConsumoTipoPagoSelect== "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalRestaurante'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Consumo Salon #" . $reservasalon->salones_id ." Codigo De Salon ".$reservasalon->Codigosalon,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_restaurante_ingreso += $consumo->total;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalRestaurante'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->ModalConsumoTipoPagoSelect == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Consumo Salon #" . $reservasalon->salones_id ." Codigo De Salon ".$reservasalon->Codigosalon,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_tarjetas_ingreso += $consumo->total;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->ModalConsumoTipoPagoSelect == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Consumo Salon #" . $reservasalon->salones_id ." Codigo De Salon ".$reservasalon->Codigosalon,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_depositos_ingreso += $consumo->total;
                $caja->save();
                
                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }
        } 

        return response()->json($consumo);
    }
    
    public function ConsumoHospedajeDelete($id){
        $consumo = Consumo::find($id);

        if (!$consumo) {
            return response()->json(['error' => 'Consumo no encontrado'], 404);
        }

        try {
            $consumo->delete();
            return response()->json(['message' => 'Consumo eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el consumo'], 500);
        }
    }

    public function RegistrarAdelantoHospedaje(Request $request){
        
        if($request->TipoMoneda == "Bs"){
            $adelanto = Adelanto::create([
                'TipoAdelanto' => $request->TipoAdelanto,
                'TipoMoneda' => $request->TipoMoneda,
                'FechaDeAdelanto' => now(),
                'TotalAdelanto' => $request->MontoAdelanto,
                'hospedaje_habitacion_id' => $request->hospedajeID,
            ]); 
        }else{
            $adelanto = Adelanto::create([
                'TipoAdelanto' => $request->TipoAdelanto,
                'TipoMoneda' => $request->TipoMoneda,
                'MontoDolar' =>  $request->MontoAdelanto,
                'FechaDeAdelanto' => now(),
                'TotalAdelanto' => $request->MontoAdelanto*7,
                'hospedaje_habitacion_id' => $request->hospedajeID,
            ]); 
        }
              

        $hospedaje = HospedajeHabitacion::where('id',$request->hospedajeID)->first();

        $sumadelanto = Adelanto::where('hospedaje_habitacion_id', $request->hospedajeID)->sum('TotalAdelanto');
        $hospedaje->Adelanto = $sumadelanto;
        $hospedaje->save();

        $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
        $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
        $hospedaje->save();

        $user = Auth::user();
        $caja = Caja::latest()->first();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        if($request->TipoMoneda == "Bs"){      
            if($caja){                       
                if($request->TipoAdelanto == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalHostal'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Se realizo un adelanto de la habitacion #" . $hospedaje->habitacion_id." Codigo De hospedaje ".$hospedaje->CodigoHospedaje,
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);

                    $caja->caja_hostal_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();

                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalHostal'))->where('Eliminado','false')->get();

                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }

                if($request->TipoAdelanto == "Tarjeta"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalTarjeta'),
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Se realizo un adelanto de la habitacion #" . $hospedaje->habitacion_id." Codigo De hospedaje ".$hospedaje->CodigoHospedaje,
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

                if($request->TipoAdelanto == "Deposito/QR"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalDeposito'),
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Se realizo un adelanto de la habitacion #" . $hospedaje->habitacion_id." Codigo De hospedaje ".$hospedaje->CodigoHospedaje,
                        'Ingreso' => $adelanto->TotalAdelanto,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
                    ]);

                    $caja->caja_depositos_ingreso += $adelanto->TotalAdelanto;
                    $caja->save();
                    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
            }
        }else{
            if($caja){                       
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDolar'),
                    'articulo_caja_id' => 71,
                    'Articulo_description' => "Se realizo un adelanto de la habitacion #" . $hospedaje->habitacion_id." Codigo De hospedaje ".$hospedaje->CodigoHospedaje,
                    'Ingreso' => $adelanto->MontoDolar,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $hospedaje->id,
                    'TipoServicioPrestado' => 'Hospedaje',
                ]);

                $caja->caja_dolars_ingreso += $adelanto->MontoDolar;
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


        $habitacion = Habitacion::where('id', $hospedaje->habitacion_id)
                    ->where("Estado_habitacion", "OCUPADO")
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('EstadoHospedaje', "true");
                    })
                    ->with([
                        'hospedajehabitacion' => function ($query) {
                            $query->where('EstadoHospedaje', "true")
                                ->latest('id')
                                ->limit(1);
                        },
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
                        'hospedajehabitacion.reservas',
                    ])
                    ->first();

        return response()->json($habitacion);
    }

    public function RegistrarDetalleHospedaje(Request $request){
        if($request->selectedValue == "auto"){
            $auto = Auto::create([
                'color' => $request->ColorAuto,
                'placa' => $request->PlacaAuto, 
                'comentario' => $request->ComentarioAuto, 
                'hospedaje_habitacion_id' => $request->IdHospedaje,
            ]); 
        }else{
            $prestamo = Prestamo::create([                
                'nombre_objeto' => $request->NombreObjetoPrestamo,
                'TipoServicio' => "Prestamo",
                'fecha_venta' => now(),
                'comentario' => $request->ComentarioPrestamo,
                'hospedaje_habitacion_id' => $request->IdHospedaje,
            ]); 
        }
        
        return response()->json($request->selectedValue);
    }

    
    public function ConcluirHospedajeCerrar(Request $request, $id){
        //return response()->json($datos = $request->all());

        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        
        $registro = Pagos::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $datos = $request->all();
        $pagos = $datos['pagos'];
        $hospedaje = HospedajeHabitacion::where('id',$id)->first();

        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipo'],
                'TipoMoneda' =>  $pago['moneda'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['cantidad'],
                'hospedaje_habitacion_id' => $id,
            ]);

            $caja = Caja::latest()->first();
            if($CreatePago->TipoMoneda == "Bs"){
                if($CreatePago->TipoPago == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalHostal'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion,
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
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
                        'Articulo_description' => "Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion,
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
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
                        'Articulo_description' => "Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion,
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
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
                    'Articulo_description' => "Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion,
                    'Ingreso' => $CreatePago->TotalPago,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $hospedaje->id,
                    'TipoServicioPrestado' => 'Hospedaje',
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

        $hospedaje->EstadoHospedaje = "false";
        $hospedaje->salida_hospedaje = now();
        $hospedaje->save();
        $idhabitacion = $hospedaje->habitacion_id;
        
        $habitacion = Habitacion::where('id', $idhabitacion)->first();
        $habitacion->Estado_habitacion = "LIMPIEZA";
        $habitacion->save();

        return response()->json($hospedaje);
        
    }

    public function ConcluirDeudaHospedajeCerrar(Request $request, $id){
        //return response()->json([$request,$id]);

        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        
        $registro = Pagos::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $datos = $request->all();
        $pagos = $datos['pagos'];
        $hospedaje = HospedajeHabitacion::where('id',$id)->first();

        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipo'],
                'TipoMoneda' =>  $pago['moneda'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['cantidad'],
                'hospedaje_habitacion_id' => $id,
            ]);

            $caja = Caja::latest()->first();
            if($CreatePago->TipoMoneda == "Bs"){
                if($CreatePago->TipoPago == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalHostal'),
                        'articulo_caja_id' => 71,
                        'Articulo_description' => "Se pago la deuda del Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion." de la fecha ".$hospedaje->salida_hospedaje,
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
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
                        'Articulo_description' => "Se pago la deuda del Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion." de la fecha ".$hospedaje->salida_hospedaje,
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
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
                        'Articulo_description' => "Se pago la deuda del Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion." de la fecha ".$hospedaje->salida_hospedaje,
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $hospedaje->id,
                        'TipoServicioPrestado' => 'Hospedaje',
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
                    'Articulo_description' => "Se pago la deuda del Hospedaje Habitacion #" . $hospedaje->habitacion_id." se hospedo ".$hospedaje->dias_hospedarse." dias cada noche a ".$hospedaje->Precio_habitacion." de la fecha ".$hospedaje->salida_hospedaje,
                    'Ingreso' => $CreatePago->TotalPago,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $hospedaje->id,
                    'TipoServicioPrestado' => 'Hospedaje',
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

        $hospedaje->EstadoHospedaje = "false";
        $hospedaje->HospedajePendiente = "false";
        $hospedaje->FechaDeudaConcluida = now();
        $hospedaje->save();

        return response()->json($hospedaje);
    }

    public function ImprimirInformacionHospedaje($id){
    
        $habitacion = Habitacion::where('id', $id)
            ->where("Estado_habitacion", "OCUPADO")
            ->whereHas('hospedajehabitacion', function($query) {
                $query->where('EstadoHospedaje', "true"); // �� string porque tu BD guarda texto
            })
            ->with([
                'hospedajehabitacion' => function($query) {
                    $query->where('EstadoHospedaje', "true")
                          ->orderBy('id', 'desc') // �� trae el m��s reciente
                          ->take(1);              // �� solo uno
                },
                'hospedajehabitacion.detallehospedajes',
                'hospedajehabitacion.user',
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
    
        //return response()->json($habitacion);
        
        if(!$habitacion){
            return response()->json(['message' => 'No encontrado'], 404);
        }
    
        $pdf = PDF::loadView('admin.Hostal.PdfInformacion', compact('habitacion'))
                    ->setPaper(array(0,0,595.28,841.89), 'portrait');
    
        $pdfBase64 = base64_encode($pdf->output());
    
        return response()->json(['pdfBase64' => $pdfBase64]);
    }
    
    public function ImprimirServiciosHospedaje($id){
        $habitacion = Habitacion::where('id', $id)
                    ->where("Estado_habitacion", "OCUPADO")
                    ->whereHas('hospedajehabitacion', function($query) {
                        $query->where('EstadoHospedaje', "true");
                    })
                    ->with(['hospedajehabitacion' => function($query) {
                        $query->where('EstadoHospedaje', "true");
                    },'hospedajehabitacion.detallehospedajes',
                        'hospedajehabitacion.user',
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

        //return response()->json($habitacion);

        $pdf = PDF::loadView('admin.Hostal.PdfServicios', compact('habitacion'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json(['pdfBase64' => $pdfBase64]);
    }

    public function ImprimirConsumosHospedaje($id){
        $habitacion = Habitacion::where('id', $id)
                    ->where("Estado_habitacion", "OCUPADO")
                    ->whereHas('hospedajehabitacion', function($query) {
                        $query->where('EstadoHospedaje', "true");
                    })
                    ->with(['hospedajehabitacion' => function($query) {
                        $query->where('EstadoHospedaje', "true");
                    },'hospedajehabitacion.detallehospedajes',
                        'hospedajehabitacion.user',
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

        //return response()->json($habitacion);

        $pdf = PDF::loadView('admin.Hostal.PdfConsumos', compact('habitacion'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json(['pdfBase64' => $pdfBase64]);
    }

    public function ImprimirConsumoHospedaje($id){
        $consumos = Consumo::where('id', $id)
                    ->with(['detalleconsumos','detalleconsumos.producto','pagosconsumos'])->first();

        //return response()->json($consumos);

        $pdf = PDF::loadView('admin.Hostal.PdfConsumoHospedaje', compact('consumos'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json(['pdfBase64' => $pdfBase64]);
    }

    public function ImprimirInformacionHospedajeGrupo($id){
    
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
    
    
        //return response()->json($grupo);

        $pdf = PDF::loadView('admin.Hostal.PdfInformacionGrupo', compact('grupo'))
                    ->setPaper(array(0,0,595.28,841.89), 'portrait');
    
        $pdfBase64 = base64_encode($pdf->output());
    
        return response()->json(['pdfBase64' => $pdfBase64]);
    }
}
