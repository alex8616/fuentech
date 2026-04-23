<?php

namespace App\Http\Controllers;

use App\Models\Salones;
use App\Models\ReservaSalones;
use App\Models\Adelanto;
use App\Models\DetalleCaja;
use App\Models\Caja;
use App\Models\ClienteReserva;
use App\Models\EmpresaReserva;
use App\Models\Servicio;
use App\Models\Consumo;
use App\Models\ServicioConsumo;
use App\Models\DetalleServicio;
use App\Models\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Traits\GenerarCodigoHospedajeTrait;
use App\Traits\CambiarEstadoTurnosTrait;

class SalonesController extends Controller
{
    use CambiarEstadoTurnosTrait;
    use GenerarCodigoHospedajeTrait;
   
    public function GetClienteReservas(Request $request){
        $query = $request->input('query');
        $clientes = ClienteReserva::where('NombreCliente', 'like', '%' . $query . '%')->get();
        return response()->json($clientes);
    }

    public function GetEmpresaReservas(Request $request){
        $query = $request->input('query');
        $empresas = EmpresaReserva::where('NombreEmpresa', 'like', '%' . $query . '%')->get();
        return response()->json($empresas);
    }


    public function GetAmbienteSalones(){
        $salones = Salones::get();
        return response()->json($salones);
    }

    public function GetAmbienteSalonesReservas(){
        $reservas = ReservaSalones::get();
        return response()->json($reservas);
    }

    public function RegistrarSalonAmbiente(Request $request){
        //return response()->json($request);
        $imageName = "NULL";

        if ($request->hasFile('ImagenInput')) {
            $imageName = time() . '.' . $request->ImagenInput->extension();
            $request->ImagenInput->move(public_path('images/salones'), $imageName);
        }

        $salon = Salones::create([
            'Nombre_salon' => $request->Nombre_salonInput,
            'Detalle_salon' => $request->Detalle_salonInput,
            'Precio_salon' => "0.00",
            'imagen' => $imageName,
        ]);
    
        return response()->json($salon);
    }

    public function RegistrarReservaSalonAmbiente(Request $request){
        $user = Auth::user();
    
        // Formatear la fecha de ingreso con horas
        $fechaConHoraInicio = $request->FechaIngresoSalonInput . ' ' . $request->HoraInicioSalonInput;
        $fechaCompletaInicio = new \DateTime($fechaConHoraInicio);
        
        $fechaConHoraFin = $request->FechaIngresoSalonInput . ' ' . $request->HoraFinSalonInput;
        $fechaCompletaFin = new \DateTime($fechaConHoraFin);
    
        // Verificar si existe solapamiento con otras reservas en la misma fecha
        $reservaSolapada = ReservaSalones::where('salones_id', $request->SeleccionarSalonInput)
            ->where('ingreso_salon', $request->FechaIngresoSalonInput) // Mismo día
            ->where(function($query) use ($request) {
                // Verificar si la nueva reserva solapa con reservas existentes por hora
                $query->whereBetween('hora_ingreso', [$request->HoraInicioSalonInput, $request->HoraFinSalonInput])
                      ->orWhereBetween('hora_salida', [$request->HoraInicioSalonInput, $request->HoraFinSalonInput])
                      ->orWhere(function($query) use ($request) {
                          $query->where('hora_ingreso', '<=', $request->HoraInicioSalonInput)
                                ->where('hora_salida', '>=', $request->HoraFinSalonInput);
                      });
            })
            ->exists();
    
        // Si existe un solapamiento, retornamos una respuesta de error
        if ($reservaSolapada) {
            return response()->json([
                'error' => 'El salón ya está reservado en este horario.'
            ], 400); // Código de error 400: Bad Request
        }

        $clienteID = "";
        $empresaID = "";

        if($request->AgregarClienteCheckbox == "true"){
            $cliente = ClienteReserva::create([
                'NombreCliente' => $request->NombreClienteReservasSalonInput,
                'CelularCliente' => $request->TelefonoClienteReservasSalonInput,
            ]);
            $clienteID = $cliente->id;
        }else{
            $cliente = ClienteReserva::where('NombreCliente', $request->NombreClienteReservasSalonInput)->first();
            $clienteID = $cliente->id;
        }
            
        if($request->AgregarEmpresaCheckbox == "true"){
            $empresa = EmpresaReserva::create([
                'NombreEmpresa' => $request->EmpresaReservasSalonInput,
            ]);
            $empresaID = $empresa->id;
        }else{
            $empresa = EmpresaReserva::where('NombreEmpresa', $request->EmpresaReservasSalonInput)->first();
            $empresaID = $empresa->id;
        }

        // Si no hay solapamiento, se puede registrar la nueva reserva
        $reserva = ReservaSalones::create([
            'ingreso_salon' => $request->FechaIngresoSalonInput,
            'hora_ingreso_salon' => $fechaConHoraInicio,                        
            'hora_salida_salon' => $fechaConHoraFin,
            'hora_ingreso' => $request->HoraInicioSalonInput,                        
            'hora_salida' => $request->HoraFinSalonInput,
            'Codigosalon' => $this->generarCodigoHospedajeUnico(),
            'Precio_salon' => $request->PrecioSalonInput,
            'PrecioRestante' => 0.00,
            'Adelanto' => 0.00,
            'Total' => $request->PrecioSalonInput,
            'Totalsalon' => $request->PrecioSalonInput,
            'TotalServicio' => 0.00,
            'TotalConsumo' => 0.00,
            'SubTotal' => $request->PrecioSalonInput,
            'Tarifa_salon' => $request->SeleccionarTarifaInput,
            'EstadoReserva' => "true",
            'Estadosalon' => "true",
            'ComentarioReserva' => $request->ComentarioSalonInput,
            'user_id' => $user->id,
            'salones_id' => $request->SeleccionarSalonInput,
            'cliente_reservas_id' => $clienteID,
            'empresa_reservas_id' => $empresaID,
        ]);
    
        return response()->json($reserva);
    }

    public function FiltrarDatosReservaSalon(Request $request){
        //return response()->json($request);
        
        $ingreso = 0;
        $salida = 0; 
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoReserva = $request->input('TipoReserva');
        $Salon = $request->input('Salones');
        $ingresoSum = 0;
        $salidaSum = 0;

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioReservaSalon':
                $reservas = ReservaSalones::with(['salon'])
                                ->whereDay('ingreso_salon', $dia)
                                ->whereMonth('ingreso_salon', $mes)
                                ->whereYear('ingreso_salon', $anio)
                                ->get();
            
                $countreservas = $reservas->count();

            break;
            case 'MensualReservaSalon':
                $reservas = ReservaSalones::with(['salon'])
                                ->whereMonth('ingreso_salon', $mes)
                                ->whereYear('ingreso_salon', $anio)
                                ->get();

                $countreservas = $reservas->count();

            break;
            case 'AnualReservaSalon':
                 $reservas = ReservaSalones::with(['salon'])
                                ->whereYear('ingreso_salon', $anio)
                                ->get();
                                
                $countreservas = $reservas->count();
            break;
            case 'RangoReservaSalon':
                $reservas = ReservaSalones::with(['salon'])
                                ->whereBetween('ingreso_salon', [$fechaInicio, $fechaFin])
                                ->get();

                $countreservas = $reservas->count();
            break;
        }

        return response()->json([
            'reservas' => $reservas,
            'cantidadregistros' => $countreservas,
        ]);
    }

    public function GetReservaSalonSeleccionado($id){
        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio', 'servicioconsumos', 'servicioconsumos.consumo', 'servicioconsumos.consumo.detalleconsumos', 'servicioconsumos.consumo.detalleconsumos.producto','adelantos','pagos'])
                                ->where('id',$id)
                                ->get();
                                
        return response()->json($reservas);
    }

    public function RegistrarAdelantoSalon(Request $request){
        //return response()->json($request);
        $id = $request->idreservaSalon;
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;

        $reservasalon = ReservaSalones::where('id',$request->idreservaSalon)->first();

        $newadelanto = Adelanto::create([
            'TipoAdelanto' => $request->TipoAdelanto,
            'FechaDeAdelanto' => now(),
            'TotalAdelanto' => $request->MontoAdelanto,
            'reserva_salones_id' => $request->idreservaSalon
        ]);

        $adelantos = Adelanto::where('reserva_salones_id', $reservasalon->id)->get();
        $valorsumado = $adelantos->sum('TotalAdelanto');

        $reservasalon->Adelanto = $valorsumado;
        $reservasalon->Total = $reservasalon->SubTotal-$valorsumado;
        $reservasalon->save();

        $caja = Caja::latest()->first();
        if($request->TipoAdelanto== "Efectivo"){
            $detallecaja = DetalleCaja::create([
                'user_id' => $user->id,
                'caja_id' => $caja->id,
                'codigo_caja_id' => config('global.GlobalHostal'),
                'articulo_caja_id' => 50,
                'Articulo_description' => "Pago un adelanto de la reserva Codigo De reserva ".$reservasalon->Codigosalon." de ".$request->MontoAdelanto." Bs.",
                'Ingreso' => $request->MontoAdelanto,
                'Egreso' => "0.00",
                'Fecha_registro' => now(),
                'ServicioPrestado' => $reservasalon->id,
                'TipoServicioPrestado' => "Salon"
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

        if($request->TipoAdelanto == "Tarjeta"){
            $detallecaja = DetalleCaja::create([
                'user_id' => $user->id,
                'caja_id' => $caja->id,
                'codigo_caja_id' => config('global.GlobalTarjeta'),
                'articulo_caja_id' => 50,
                'Articulo_description' => "Pago un adelanto de la reserva Codigo De reserva ".$reservasalon->Codigosalon." de ".$request->MontoAdelanto." Bs.",
                'Ingreso' => $request->MontoAdelanto,
                'Egreso' => "0.00",
                'Fecha_registro' => now(),
                'ServicioPrestado' => $reservasalon->id,
                'TipoServicioPrestado' => "Salon"
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

        if($request->TipoAdelanto == "Deposito/QR"){
            $detallecaja = DetalleCaja::create([
                'user_id' => $user->id,
                'caja_id' => $caja->id,
                'codigo_caja_id' => config('global.GlobalDeposito'),
                'articulo_caja_id' => 50,
                'Articulo_description' => "Pago un adelanto de la reserva Codigo De reserva ".$reservasalon->Codigosalon." de ".$request->MontoAdelanto." Bs.",
                'Ingreso' => $request->MontoAdelanto,
                'Egreso' => "0.00",
                'Fecha_registro' => now(),
                'ServicioPrestado' => $reservasalon->id,
                'TipoServicioPrestado' => "Salon"
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

        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio','servicioconsumos','adelantos','pagos'])->where('id',$id)->get();

        return response()->json($reservas);
    }
    
    public function RegistrarServicioDataSalon(Request $request){
        //return response()->json($request);
        $user = Auth::user();
        $id = $request->id;

        $reservasalon = ReservaSalones::where('id',$request->id)->first();
        $exiteservicio = Servicio::where('reserva_salones_id',$reservasalon->id)->first();
        

        if($exiteservicio){
            $detalleservicio = DetalleServicio::create([
                'servicio_id' => $exiteservicio->id,
                'TipoServicio' => $request->ServicioAlquilerSalon,
                'fecha_venta' => now(),
                'comentario' => $request->ComentarioAlquilerSalon,
                'cantidad' => $request->CantidadAlquilerSalon,
                'precio' => $request->PrecioAlquilerSalon,
                'total' => $request->TotalAlquilerSalon,
            ]);
            
        }else{
            $servicio = Servicio::create([
                'totalgeneral' => 0.00,
                'user_id' => $user->id,
                'reserva_salones_id' => $request->id
            ]);

            $detalleservicio = DetalleServicio::create([
                'servicio_id' => $servicio->id,
                'TipoServicio' => $request->ServicioAlquilerSalon,
                'fecha_venta' => now(),
                'comentario' => $request->ComentarioAlquilerSalon,
                'cantidad' => $request->CantidadAlquilerSalon,
                'precio' => $request->PrecioAlquilerSalon,
                'total' => $request->TotalAlquilerSalon,
            ]);
        }

        $miservicio = Servicio::where('reserva_salones_id',$request->id)->first();
        $sumtotalDetalle = DetalleServicio::where('servicio_id',$miservicio->id)->where('eliminado',NULL)->sum('total');
        $miservicio->totalgeneral = $sumtotalDetalle;
        $miservicio->save();

        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio','servicioconsumos','adelantos','pagos'])->where('id',$miservicio->reserva_salones_id)->first();
        $reservas->SubTotal = $reservas->Precio_salon + $reservas->TotalConsumo + $miservicio->totalgeneral;
        $reservas->Total = $reservas->SubTotal - $reservas->Adelanto;
        $reservas->TotalServicio = $sumtotalDetalle;
        $reservas->save();

        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio','servicioconsumos','adelantos','pagos'])->where('id',$id)->get();
        return response()->json($reservas);
    }

    public function ActualizarServicioDataSalon(Request $request){
        //return response()->json($request);
        $detalle = DetalleServicio::where('id',$request->id)->first();
        $detalle->cantidad = $request->cantidad;
        $detalle->precio = $request->precio; 
        $detalle->total = $request->total; 
        $detalle->save(); 
        
        $miservicio = Servicio::where('id',$detalle->servicio_id)->first();
        $sumtotalDetalle = DetalleServicio::where('servicio_id',$miservicio->id)->where('eliminado',NULL)->sum('total');
        $miservicio->totalgeneral = $sumtotalDetalle;
        $miservicio->save();

        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio','servicioconsumos','adelantos','pagos'])->where('id',$miservicio->reserva_salones_id)->first();
        $reservas->SubTotal = $reservas->Precio_salon + $reservas->TotalConsumo + $miservicio->totalgeneral;
        $reservas->Total = $reservas->SubTotal - $reservas->Adelanto;
        $reservas->TotalServicio = $sumtotalDetalle;
        $reservas->save();

        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio','servicioconsumos','adelantos','pagos'])->where('id',$miservicio->reserva_salones_id)->get();
        return response()->json($reservas);
    }

    public function DeleteServicioDataSalon(Request $request){
        $detalle = DetalleServicio::where('id',$request->id)->first();
        $detalle->eliminado = "true";
        $detalle->comentarioeliminado = $request->ComentarioDeleteServicioSalon; 
        $detalle->save(); 
        
        $miservicio = Servicio::where('id',$detalle->servicio_id)->first();
        $sumtotalDetalle = DetalleServicio::where('servicio_id',$miservicio->id)->where('eliminado',NULL)->sum('total');
        $miservicio->totalgeneral = $sumtotalDetalle;
        $miservicio->save();


        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio','servicioconsumos','adelantos','pagos'])->where('id',$miservicio->reserva_salones_id)->first();
        $reservas->SubTotal = $reservas->Precio_salon + $reservas->TotalConsumo + $miservicio->totalgeneral;
        $reservas->Total = $reservas->SubTotal - $reservas->Adelanto;
        $reservas->TotalServicio = $sumtotalDetalle;
        $reservas->save();
        
        $reservas = ReservaSalones::with(['clientereserva', 'empresareserva', 'salon','detallereservas','servicios', 'servicios.detalleservicio','servicioconsumos','adelantos','pagos'])->where('id',$miservicio->reserva_salones_id)->get();

        return response()->json($reservas);
    }

    public function RegistrarConsumoReservaSalon(Request $request){
        $user = Auth::user();
        $id = $request->IdReservaSalon;

        $reservasalon = ReservaSalones::with('salon')->where('id',$id)->first();
        $exiteservicioconsumo = ServicioConsumo::where('reserva_salones_id',$reservasalon->id)->first();
        $turnoscambiadoestado = $this->CambiarEstadoTurnos();
        $turnoActivo = $turnoscambiadoestado->firstWhere('Estado', 'true');


        if($exiteservicioconsumo){
            $consumo = Consumo::create([
                'CantidadPersonas' => 1,
                'empresa_id' => $user->empresa_id,
                'user_id' => $user->id,
                'cliente_id' => null,
                'camarero_id' => null,
                'ambiente_mesa_id' => null,
                'fecha_venta' => now(),
                'total' => 0,
                'subTotal' => 0,
                'Comentario' => "Consumo Para Salon Reserva ".$reservasalon->salon->Nombre_salon,
                'ocupado' => 'true',
                'turno_id' => $turnoActivo->id,
                'TipoConsumo' => 'Salon',
                'servicio_consumo_id' => $exiteservicioconsumo->id,
            ]);
            
        }else{
            $servicioconsumo = ServicioConsumo::create([
                'user_id' => $user->id,
                'FechaRegistro_servicio' => now(),
                'ServicioComentario' => "Consumo De Salon Reserva",
                'subTotal' => 0.00,
                'totalpagado'=> 0.00,
                'total'=> 0.00,
                'totalgeneral'=> 0.00,
                'reserva_salones_id' => $id,
            ]);

            $consumo = Consumo::create([
                'CantidadPersonas' => 1,
                'empresa_id' => $user->empresa_id,
                'user_id' => $user->id,
                'cliente_id' => null,
                'camarero_id' => null,
                'ambiente_mesa_id' => null,
                'fecha_venta' => now(),
                'total' => 0,
                'subTotal' => 0,
                'Comentario' => "Consumo Para Salon Reserva ".$reservasalon->salon->Nombre_salon,
                'ocupado' => 'true',
                'turno_id' => $turnoActivo->id,
                'TipoConsumo' => 'Salon',
                'servicio_consumo_id' => $servicioconsumo->id,
            ]);
        }
        
        return response()->json($request);
    }

    public function GetConsumoReservaSalon($id){
        $servicioconsumo = ReservaSalones::where('id', $id)->with(['servicioconsumos','servicioconsumos.consumo','servicioconsumos.consumo.detalleconsumos'])->first();
        return response()->json($servicioconsumo);
    }

    public function ConcluirReservaSalon($id){
        $reservasalon = ReservaSalones::where('id', $id)->with(['servicioconsumos','servicioconsumos.consumo','servicioconsumos.consumo.detalleconsumos'])->first();
        $reservasalon->EstadoReserva = "true";
        $reservasalon->Estado = "PROCESO";
        $reservasalon->save();

        $salon = Salones::where('id', $reservasalon->salones_id)->first();
        $salon->Estado_salon = "OCUPADO";
        $salon->save();
        
        return response()->json($reservasalon);
    }

    public function GetSalonOcupada($id){
        $salon = Salones::where('id', $id)
                    ->where("Estado_salon", "OCUPADO")
                    ->whereHas('reservasalon', function($query) {
                        $query->where('EstadoReserva', "true");
                    })
                    ->with(['reservasalon' => function($query) {
                        $query->where('EstadoReserva', "true");
                    },'reservasalon.clientereserva',
                        'reservasalon.empresareserva',
                        'reservasalon.servicios',                       
                        'reservasalon.servicios.detalleservicio',
                        'reservasalon.servicioconsumos',
                        'reservasalon.servicioconsumos.consumo.pagosconsumos',
                        'reservasalon.servicioconsumos.consumo.detalleconsumos',
                        'reservasalon.servicioconsumos.consumo.detalleconsumos.producto',
                        'reservasalon.adelantos',
                    ])
                    ->first();

        return response()->json($salon);
    }

    public function DarBajaReservaSalon(Request $request){
    
        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        
        $id = $request->id;
        $pagos = $request->input('pagos');        
    
        $reservasalon = ReservaSalones::with('salon')->where('id',$id)->first();

        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipoPago'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['monto'],
                'reserva_salones_id' => $id,
            ]);

            $caja = Caja::latest()->first();
            if($CreatePago->TipoPago == "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalHostal'),
                    'articulo_caja_id' => 50,
                    'Articulo_description' => "Pago Total Reserva De Reserva Salon" . $reservasalon->salon->Nombre_salon,
                    'Ingreso' => $CreatePago->TotalPago,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $reservasalon->id,
                    'TipoServicioPrestado' => "Salon"
                ]);
                
                $caja->caja_hostal_ingreso += $reservasalon->total;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalHostal'))->where('Eliminado','false')->get();

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
                    'articulo_caja_id' => 50,
                    'Articulo_description' => "Pago Total Reserva De Reserva Salon" . $reservasalon->salon->Nombre_salon,
                    'Ingreso' => $CreatePago->TotalPago,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $reservasalon->id,
                    'TipoServicioPrestado' => "Salon"
                ]);

                $caja->caja_tarjetas_ingreso += $reservasalon->total;
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
                    'articulo_caja_id' => 50,
                    'Articulo_description' => "Pago Total Reserva De Reserva Salon" . $reservasalon->salon->Nombre_salon,
                    'Ingreso' => $CreatePago->TotalPago,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $reservasalon->id,
                    'TipoServicioPrestado' => "Salon"
                ]);

                $caja->caja_depositos_ingreso += $reservasalon->total;
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

        $reservasalon->EstadoReserva = "false";
        $reservasalon->Estadosalon = "false";
        $reservasalon->Estado = "COMPLETO";
        $reservasalon->save();

        $salonambiente = Salones::where('id', $reservasalon->salones_id)->first();
        $salonambiente->Estado_salon = "DISPONIBLE";
        $salonambiente->save();

        return response()->json($reservasalon);
        
    }
}
