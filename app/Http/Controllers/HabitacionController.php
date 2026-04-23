<?php

namespace App\Http\Controllers;
use App\Models\Habitacion;
use App\Models\GrupoHospedaje;
use App\Models\Consumo;
use App\Models\Mantenimiento;
use App\Models\HospedajeHabitacion;
use App\Models\DetalleHospedajeHabitacion;
use App\Models\AmbienteMesa;
use App\Models\ServicioConsumo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function GetHabitacionesSelect() {
        $habitaciones = Habitacion::get();
        return response()->json($habitaciones);
    }

    public function GetHabitaciones() {
        $habitaciones = Habitacion::with(['hospedajehabitacion' => function($query) {
            $query->where(function($query) {
                $query->where('EstadoHospedajeGrupo', "true")
                      ->orWhere('EstadoHospedaje', "true");
            });
        }])->get();

        /* SUMAR CANTIDAD HUESPEDES INICIO */
        $totalDetalleHospedajes = Habitacion::where('Estado_habitacion', 'OCUPADO')
                                ->with(['hospedajehabitacion', 'hospedajehabitacion.detallehospedajes'])
                                ->with(['hospedajehabitacion' => function ($query) {
                                    $query->withCount('detallehospedajes');
                                }])
                                ->get()
                                ->pluck('hospedajehabitacion')
                                ->flatten()
                                ->sum('detallehospedajes_count');
                                
        $totalDetalleHospedajesgrupos = GrupoHospedaje::where('Estado', 'true')
                                ->with(['hospedajes', 'hospedajes.detallehospedajes'])
                                ->with(['hospedajes' => function ($query) {
                                    $query->withCount('detallehospedajes');
                                }])
                                ->get()
                                ->pluck('hospedajes')
                                ->flatten()
                                ->sum('detallehospedajes_count');
        /* SUMAR CANTIDAD HUESPEDES FIN */



        $ocupados = Habitacion::where('Estado_habitacion', 'OCUPADO')->count();
        $mantenimientos = Habitacion::where('Estado_habitacion', 'MANTENIMIENTO')->count();
        $limpieza = Habitacion::where('Estado_habitacion', 'LIMPIEZA')->count();
        $libre = Habitacion::where('Estado_habitacion', 'DISPONIBLE')->count();
        $cantidadhuspedes = $totalDetalleHospedajes + $totalDetalleHospedajesgrupos;

        return response()->json([
            'habitaciones' => $habitaciones,
            'ocupados' => $ocupados,
            'mantenimientos' => $mantenimientos,
            'limpieza' => $limpieza,
            'libre' => $libre,
            'cantidadhuspedes' => $cantidadhuspedes,
        ]);
    }
    

    public function GetHuespedesAll() {
        $huespedes = DetalleHospedajeHabitacion::with(['cliente', 'hospedajehabitacion', 'hospedajehabitacion.habitacion'])
            ->whereHas('hospedajehabitacion.habitacion', function($query) {
                $query->where('Estado_habitacion', 'OCUPADO');
            })
            ->get()
            ->map(function($detalleHospedaje) {
                return [
                    'nombre_cliente' => $detalleHospedaje->cliente->NombreCompleto_cliente,
                    'habitacion_id'  => $detalleHospedaje->hospedajehabitacion->habitacion->id,
                    'grupo' => 'si'
                ];
            });
    
        $grupohuespedes = GrupoHospedaje::where("Estado", "true")
            ->with(['hospedajes', 'hospedajes.detallehospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes.cliente'])
            ->get()
            ->map(function($grupo) {
                return $grupo->hospedajes->map(function($hospedaje) {
                    return $hospedaje->detallehospedajes->map(function($detalleHospedaje) use ($hospedaje) {
                        return [
                            'nombre_cliente' => $detalleHospedaje->cliente->NombreCompleto_cliente,
                            'habitacion_id'  => $hospedaje->habitacion->id,
                            'grupo' => 'no'
                        ];
                    });
                });
            })
            ->flatten(2);
        
        $todosLosHuespedes = $huespedes->merge($grupohuespedes);
    
        return response()->json($todosLosHuespedes);
    }
    
    

    public function GetGruposHabitaciones(){
        $habitaciones = GrupoHospedaje::where("Estado", "true")->get();
        return response()->json($habitaciones);
    }

    public function CambiarEstadoHabitacionHospedaje(Request $request){
        $habitacion = Habitacion::where('id', $request->idhabitacion)->first();
        $habitacion->Estado_habitacion = "DISPONIBLE";
        $habitacion->save();

        return response()->json($habitacion);
    }

    public function CambiarEstadoHabitacionHospedajeSucio(Request $request){
        $habitacion = Habitacion::where('id', $request->idhabitacion)->first();
        $habitacion->Estado_habitacion = "LIMPIEZA";
        $habitacion->save();

        return response()->json($habitacion);
    }

    public function CambiarEstadoHabitacionMantenimientoProblema(Request $request){
        $user = Auth::user(); 

        if($user){
            $habitacion = Habitacion::where('id', $request->idhabitacion)->first();
            $habitacion->Estado_habitacion = "MANTENIMIENTO";
            $habitacion->save();
    
            $mantenimiento = Mantenimiento::create([
                'Problema' => $request->ProblemaInput,
                'InicioProblema' => now(),
                'user_id' => $user->id,
                'habitacion_id' => $request->idhabitacion,
            ]);
        }

        return response()->json($user);
    }

    public function GetProblemasHabitacion($id){
        $habitacion = Habitacion::where('id', $id)->first();
        $mantenimiento = Mantenimiento::where('habitacion_id', $id)->where('EstadoSolucion', "false")->first();
        return response()->json($mantenimiento);
    }

    public function CambiarEstadoHabitacionMantenimientoSolucion(Request $request){
        $mantenimiento = Mantenimiento::where('id', $request->idmantenimiento)->first();

        if (!$mantenimiento) {
            return response()->json(['error' => 'Mantenimiento no encontrado'], 404);
        }

        $mantenimiento->Solucion = $request->SolucionInput;
        $mantenimiento->FinalProblema = now();
        $mantenimiento->save();

        $inicio = Carbon::parse($mantenimiento->InicioProblema);
        $final = Carbon::parse($mantenimiento->FinalProblema); 
        $diferencia = $inicio->diff($final);
        
        $dias = $diferencia->d == 1 ? '1 día' : $diferencia->d . ' días';
        $horas = $diferencia->h == 1 ? '1 hora' : $diferencia->h . ' horas';
        $minutos = $diferencia->i == 1 ? '1 minuto' : $diferencia->i . ' minutos';
        $diferenciaTexto = "$dias, $horas y $minutos";
        
        $mantenimiento->TiempoSolucion = $diferenciaTexto;
        $mantenimiento->save();        

        return response()->json($mantenimiento);
    }

    public function CambiarEstadoHabitacionHospedajeMantenimientoSucio(Request $request){
        $habitacion = Habitacion::where('id', $request->idhabitacion)->first();
        $habitacion->Estado_habitacion = "LIMPIEZA";
        $habitacion->save();

        $mantenimiento = Mantenimiento::where('id', $request->idmantenimiento)->first();
        $mantenimiento->EstadoSolucion = "true";
        $mantenimiento->save();

        return response()->json($habitacion);
    }

    public function GetHabitacionesOcupadas(){
        $habitaciones = Habitacion::where('Estado_habitacion', 'OCUPADO')
                                   ->orWhere('Estado_habitacion', 'GRUPO')
                                   ->get();
        return response()->json($habitaciones);
    }

    public function GetHabitacionesLibres(){
        $habitaciones = Habitacion::where('Estado_habitacion', 'DISPONIBLE')
                                   ->get();
        return response()->json($habitaciones);
    }

    public function RegistrarCambioHabitacion(Request $request){
        $hospedaje = HospedajeHabitacion::where('id', $request->hospedajeId)->first();
        $anteriorhabitacion = Habitacion::where('id', $hospedaje->habitacion_id)->first();
        $anteriorhabitacion->Estado_habitacion = "LIMPIEZA";
        $anteriorhabitacion->save();
        
        $hospedaje->habitacion_id = $request->habitacionSeleccionada;
        $hospedaje->save();

        $habitacion = Habitacion::where('id', $request->habitacionSeleccionada)->first();
        $habitacion->Estado_habitacion = "OCUPADO";
        $habitacion->save();

        return response()->json($request);
    }

    public function CambiarConsumoHabitacion(Request $request){
        $habitacion = Habitacion::where('id', $request->habitacionId)->first();
        $mesa = AmbienteMesa::where('id', $request->mesaId)->first();

        if ($habitacion->Estado_habitacion == "OCUPADO") {
            $hospedaje = HospedajeHabitacion::where('habitacion_id', $habitacion->id)
                        ->where('EstadoHospedaje', 'true')
                        ->with('servicioconsumos')
                        ->latest('id')
                        ->limit(1)
                        ->first();

            $consumo = Consumo::where('ambiente_mesa_id',$request->mesaId)->where('TipoConsumo', 'Mesa')->where('ocupado', 'true')
                            ->first();
            
            $mesa->estado = "libre"; 
            $consumo->ocupado = 'true';
            $consumo->TipoConsumo = "Habitacion";
            $consumo->Comentario = "Cambio Mesa a Consumo Para Habitacion #".$habitacion->id;
            $consumo->ambiente_mesa_id = NULL; 
            $consumo->servicio_consumo_id = $hospedaje->servicioconsumos[0]->id;
            $mesa->save();
            $consumo->save();

            $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->first();
            $pagado = Consumo::Where('servicio_consumo_id', $servicioconsumo->id)->where("ocupado","false")->sum('total');
            $nopagado = Consumo::Where('servicio_consumo_id', $servicioconsumo->id)->where("ocupado","true")->sum('total'); 
            


            $servicioconsumo->subTotal = $nopagado + $pagado;
            $servicioconsumo->totalpagado = $pagado;
            $servicioconsumo->total = $servicioconsumo->subTotal - $servicioconsumo->totalpagado;
            $servicioconsumo->totalgeneral = $servicioconsumo->subTotal - $servicioconsumo->totalpagado;
            $servicioconsumo->save();

            $hospedaje = HospedajeHabitacion::where('id', $servicioconsumo->hospedaje_habitacion_id)->first();
            $hospedaje->TotalConsumo = $servicioconsumo->totalgeneral;
            $hospedaje->save();
            $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
            $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
            $hospedaje->save();
        }
        elseif ($habitacion->Estado_habitacion == "GRUPO") {
            $hospedaje = HospedajeHabitacion::where('habitacion_id', $habitacion->id)
                        ->where('EstadoHospedaje', 'true')
                        ->where('EstadoHospedajeGrupo', 'true')
                        ->with(['servicioconsumos'])
                        ->first();
            $consumo = Consumo::where('ambiente_mesa_id',$request->mesaId)->where('TipoConsumo', 'Mesa')->where('ocupado', 'true')
                        ->first();
            
            $mesa->estado = "libre"; 
            $consumo->ocupado = 'true';
            $consumo->TipoConsumo = "Habitacion";
            $consumo->Comentario = "Cambio Mesa a Consumo Para Habitacion #".$habitacion->id." del grupo";
            $consumo->ambiente_mesa_id = NULL; 
            $consumo->servicio_consumo_id = $hospedaje->servicioconsumos[0]->id;
            $mesa->save();
            $consumo->save();

            $servicioconsumo = ServicioConsumo::where('id',$consumo->servicio_consumo_id)->first();
            $pagado = Consumo::Where('servicio_consumo_id', $servicioconsumo->id)->where("ocupado","false")->sum('total');
            $nopagado = Consumo::Where('servicio_consumo_id', $servicioconsumo->id)->where("ocupado","true")->sum('total'); 
            
            $servicioconsumo->subTotal = $nopagado + $pagado;
            $servicioconsumo->totalpagado = $pagado;
            $servicioconsumo->total = $servicioconsumo->subTotal - $servicioconsumo->totalpagado;
            $servicioconsumo->totalgeneral = $servicioconsumo->subTotal - $servicioconsumo->totalpagado;
            $servicioconsumo->save();

            $hospedaje = HospedajeHabitacion::where('id', $servicioconsumo->hospedaje_habitacion_id)->first();
            $hospedaje->TotalConsumo = $servicioconsumo->totalgeneral;
            $hospedaje->save();
            $hospedaje->SubTotal = $hospedaje->TotalHospedaje+$hospedaje->TotalServicio+$hospedaje->TotalConsumo;
            $hospedaje->total = $hospedaje->SubTotal-$hospedaje->Adelanto;
            $hospedaje->save();
        }
    
        return response()->json([$hospedaje, $consumo, $mesa, $consumo]);

    }
 
    public function PendienteHabitacionHospedaje($id){
        $hospedaje = HospedajeHabitacion::where('id', $id)->first();
        $hospedaje->HospedajeDeuda = "Si";
        $hospedaje->HospedajePendiente = "true";
        $hospedaje->salida_hospedaje = now();
        $hospedaje->save();

        $habitacion = Habitacion::where('id', $hospedaje->habitacion_id)->first();
        $habitacion->Estado_habitacion = "LIMPIEZA";
        $habitacion->save();

        return response()->json($hospedaje);
    }

    public function GetPendienteHabitacionHospedaje(){
        $hospedaje = HospedajeHabitacion::where('HospedajeDeuda', 'Si')->where('HospedajePendiente', 'true')->with(['detallehospedajes','detallehospedajes.cliente'])->get();
        return response()->json($hospedaje);
    }

    public function SelectPendienteHabitacionHospedaje($id){
        $hospedaje = HospedajeHabitacion::where('id', $id)->first();
        $habitacion = Habitacion::where('id', $hospedaje->habitacion_id)
                    ->whereHas('hospedajehabitacion', function($query) {
                        $query->where('HospedajeDeuda', "Si");
                        $query->where('HospedajePendiente', "true");
                    })
                    ->with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes',
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
}
