<?php

namespace App\Http\Controllers;

use App\Models\DetallePersonal;
use App\Models\Persona;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class PersonaController extends Controller
{
    public function index()
    {
        return view('admin.personal.personal');
    }

    public function GetPersonal(){
        $personal = Persona::get();
        return response()->json($personal);
    }

    public function GetSeleccionadoPersonal($id){
        $personal = Persona::where('id', $id)->first();
        return response()->json($personal);
    }

    public function ActualizarPersonal(Request $request){
        $personal = Persona::where('id', $request->id)->first();
        $personal->Nombre_Completo = $request->UpdateNombre;
        $personal->Dni = $request->UpdateDni;
        $personal->Cargo = $request->UpdateCargo;
        $personal->Tiempo = $request->UpdateTiempo;
        $personal->estado = $request->UpdateEstado;
        $personal->save();
        return response()->json($request);
    }

    public function data(){
        $personalDate = Persona::get();
        return datatables()->of($personalDate)->toJson(); 
    }

    public function store(Request $request){
        $personal = Persona::create([
            'Nombre_Completo' => $request->Nombre_Completo,
            'Dni' => $request->Dni,
            'Cargo' => $request->Cargo,
        ]);
        return response()->json($personal);
    }

    public function edit(Request $request, $id){
        $personal = Persona::findOrFail($id);
        return response()->json($personal);
    }
    
    public function updatepersonal(Request $request, $id){
        $personaupdate = Persona::findOrFail($id);
        $personaupdate->Nombre_Completo = $request->Edit_Nombre_Completo;
        $personaupdate->Dni = $request->Edit_Dni;
        $personaupdate->Cargo = $request->Edit_Cargo;
        $personaupdate->save();
        return response()->json($request);
    }

    public function AsistenciaHoja(Request $request){
        $personals = Persona::where('estado','true')->get();
        $Month = $request->get('AsistenciaMes');
        list($year, $month) = explode('-', $Month);
    
        // Nombre del mes en español
        $meses = [
            '01' => 'enero', '02' => 'febrero', '03' => 'marzo',
            '04' => 'abril', '05' => 'mayo', '06' => 'junio',
            '07' => 'julio', '08' => 'agosto', '09' => 'septiembre',
            '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'
        ];
        $monthText = $meses[$month] ?? $month;
    
        // Días del mes con nombres en español
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $days = [];
        for ($day = 1; $day <= $numDays; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $dayOfWeek = Carbon::parse($date)->format('l');
            $dayOfWeekEs = $this->traducirDia($dayOfWeek); // Traducción segura
    
            $days[] = [
                'date' => $date,
                'dayOfWeek' => ucfirst($dayOfWeekEs)
            ];
        }
    
        $pdf = PDF::loadView('admin.personal.HojaAsistencia', compact('days', 'personals', 'monthText', 'year'))
                ->setPaper('A4', 'portrait');
    
        return $pdf->stream('Planilla' . time() . '.pdf');
    }

    public function eliminar($id){
        $personal = Persona::find($id);
        if($personal) {
            $personal->delete();
            return response()->json(['success' => true, 'message' => 'Registro eliminado exitosamente.']);
        } else {
            return response()->json(['success' => false, 'message' => 'No se ha podido eliminar el registro.']);
        }
    }

    public function Biometrico(){
        return view('admin.Biometrico.Asistencia_Biometrico');
    }
    

    public function RegisterPersonalFull(){
        return view('admin.personal.Registrar_personal');
    }



    public function RegistrarPersonal(Request $request){
        //return response()->json($request);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'pin' => 'required|string|max:255',
            'dni' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'imagen' => 'required|string',
            'descriptores' => 'required|array',
        ]);

        $nombre = $request->nombre;
        $pin = $request->pin;
        $imagenDataUrl = $request->imagen;
        $descriptores = $request->descriptores;
        $dni = $request->dni;
        $cargo = $request->cargo;
        $tiempo = $request->tiempo;
        
        $persona = Persona::create([
            'Nombre_Completo' => $nombre,
            'Dni' => $dni,
            'Cargo' => $cargo,
            'Pin' => $pin,
            'imagen' => $imagenDataUrl,
            'descriptores' => json_encode($descriptores),
            'Tiempo' => $tiempo,
        ]);

        return response()->json($persona);
    }

    
    public function obtenerCarpetasUsuarios(){
        $usuarios = Persona::all();
        $carpetas = $usuarios->pluck('Nombre_Completo');
        return response()->json(['carpetas' => $carpetas]);
    }
    

    public function obtenerImagenesCarpeta($carpeta) {
        $imagenes = Storage::files("biometrico/{$carpeta}");
        $urls = array_map(function ($imagen) {
            return asset("storage/{$imagen}");
        }, $imagenes);
        return response()->json(['imagenes' => $urls]);
    }
    

    public function GetDescriptors(){

        /*$fecha = Carbon::now()->format('d/m/Y');
        $hora = Carbon::now()->format('H:i');
        return response()->json($hora);*/

        $usuarios = DB::table('personas')->select('id','Nombre_Completo', 'descriptores')->get();
        
        // Transforma el resultado para obtener un array simple de descriptores y nombres
        $data = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'Nombre_Completo' => $usuario->Nombre_Completo,
                'descriptores' => json_decode($usuario->descriptores)[0], // Extrae la primera (y única) matriz
            ];
        })->toArray();
    
        return response()->json($data);
    }
            
    
    public function RegistrarIngresoSalida(Request $request)
    {
        $userId = $request->userId;
        $persona = Persona::where('id', $userId)->first();
    
        $hora = $request->hora_js;
        $fecha = $request->fecha_js;
        $fechaHoraCompleta = $fecha . ' ' . $hora;
    
        if ($request->Estado == 'ingreso') {
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => $fecha,
                'hora_ingreso' => $hora,
                'fecha_salida' => null,
                'hora_salida' => null,
                'estado' => 'ingreso',
                'persona_id' => $userId,
            ]);
            
            $Detalle->created_at = $fechaHoraCompleta;
            $Detalle->updated_at = $fechaHoraCompleta;
            $Detalle->save();
            
            return response()->json(['success' => 'Registro de ingreso exitoso']);
        } else {
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => null,
                'hora_ingreso' => null,
                'fecha_salida' => $fecha,
                'hora_salida' => $hora,
                'estado' => 'salida',
                'persona_id' => $userId,
            ]);
            
            $Detalle->created_at = $fechaHoraCompleta;
            $Detalle->updated_at = $fechaHoraCompleta;
            $Detalle->save();
            
            return response()->json(['success' => 'Registro de salida exitoso']);
        }
    
        return response()->json(['error' => 'Detalle no encontrado'], 404);
    }
 
 
 
 /*public function RegistrarIngresoSalida(Request $request)
{
    // Coordenadas del punto de referencia (ejemplo: ubicación de la oficina)
    $latitudReferencia = -19.58848808616622;
    $longitudReferencia = -65.7502856802036;
    
    // Coordenadas del usuario
    $latitudUsuario = $request->latitud;
    $longitudUsuario = $request->longitud;
    
    // Radio permitido en metros (aumentar para depuración)
    $radioPermitido = 2000; // Aumentar el radio a 500 metros para pruebas
    
    // Calcular la distancia entre el punto de referencia y el usuario usando la fórmula de Haversine
    $distancia = $this->calcularDistancia($latitudReferencia, $longitudReferencia, $latitudUsuario, $longitudUsuario);
    
    // Verificar si la distancia es menor o igual al radio permitido
    if ($distancia <= $radioPermitido) {
        // Continúa con el registro si está dentro del área permitida
        $userId = $request->userId;
        
        $persona = Persona::where('id', $userId)->first();
        
        if($request->Estado == 'ingreso'){
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => Carbon::now()->format('Y-m-d'),
                'hora_ingreso' => Carbon::now()->format('H:i:s'),
                'fecha_salida' => null,
                'hora_salida' => null,
                'estado' => 'ingreso',
                'persona_id' => $userId,
            ]);
            return response()->json(['success' => 'Registro exitoso']);
        } else {
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => null,
                'hora_ingreso' => null,
                'fecha_salida' => Carbon::now()->format('Y-m-d'),
                'hora_salida' => Carbon::now()->format('H:i:s'),
                'estado' => 'salida',
                'persona_id' => $userId,
            ]);
            return response()->json(['success' => 'Registro exitoso']);
        }
    } else {
        // Retorna la distancia calculada y el radio para depurar
        return response()->json([
            'distancia' => $distancia,
            'radio_permitido' => $radioPermitido,
            'error' => 'Estás fuera del área permitida'
        ], 403);
    }
}

// Función para calcular la distancia entre dos puntos usando la fórmula de Haversine
private function calcularDistancia($lat1, $lon1, $lat2, $lon2)
{
    $radioTierra = 6371000; // Radio de la Tierra en metros
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $diferenciaLatitud = $lat2 - $lat1;
    $diferenciaLongitud = $lon2 - $lon1;

    $a = sin($diferenciaLatitud / 2) * sin($diferenciaLatitud / 2) +
        cos($lat1) * cos($lat2) *
        sin($diferenciaLongitud / 2) * sin($diferenciaLongitud / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distancia = $radioTierra * $c; // Distancia en metros

    return $distancia;
}*/


    public function GetRegistros(){
        $fecha = Carbon::now()->format('Y-m-d');
        $registros = DetallePersonal::whereDate('created_at', $fecha)
                        ->orderBy('id', 'desc')
                        ->with(['personal' => function ($query) {
                            $query->select(['id', 
                                            'Nombre_Completo', 
                                            'Dni',
                                            'Cargo',
                                            'Tiempo',
                                            'Pin',]);
                        }])
                        ->get();
        return response()->json($registros);
    }

    
    public function RegistrarHoraExtra(Request $request){
        $id = $request->idRegistro;
        $detalle = DetallePersonal::where('id', $id)->first();
        if ($detalle) {
            $detalle->HoraExtra = true; 
            $detalle->RazonHoraExtra = $request->detalleTexto;
            $detalle->save();
            return response()->json($detalle);
        } else {
            return response()->json(['error' => 'Detalle no encontrado'], 404);
        }
    }

    public function GetPin(Request $request){
        $pinEsperado = Persona::select('Pin')->get();
        return response()->json($pinEsperado);
    }

    public function RegistrarIngresoSalidaPin(Request $request){
        $persona = Persona::where('Pin',$request->pin)->first();
        
        $hora = $request->hora_js;
        $fecha = $request->fecha_js;
        $fechaHoraCompleta = $fecha . ' ' . $hora;

        if($request->opcion == 'Ingreso'){
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => $fecha,
                'hora_ingreso' => $hora,
                'fecha_salida' => null,
                'hora_salida' => null,
                'estado' => 'ingreso',
                'persona_id' => $persona->id,
            ]);

            $Detalle->created_at = $fechaHoraCompleta;
            $Detalle->updated_at = $fechaHoraCompleta;
            $Detalle->save();

        }else{
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => null,
                'hora_ingreso' => null,
                'fecha_salida' => $fecha,
                'hora_salida' => $hora,
                'estado' => 'salida',
                'persona_id' => $persona->id,
            ]);

            $Detalle->created_at = $fechaHoraCompleta;
            $Detalle->updated_at = $fechaHoraCompleta;
            $Detalle->save();
            
        }
        return response()->json($persona);
    }
    
    
    public function HorarioAsistencia(Request $request){
        setlocale(LC_TIME, 'es_ES.UTF-8');

        $personaId = $request->input('persona_id');
        $reporteMes = $request->input('ReporteMes');
        $primerDia = Carbon::createFromFormat('Y-m', $reporteMes)->firstOfMonth();
        $ultimoDia = Carbon::createFromFormat('Y-m', $reporteMes)->lastOfMonth();

        $allpersons = Persona::when($personaId !== 'todos', function ($query) use ($personaId) {
            return $query->where('id', $personaId);
        })->get();

        $allDetalle = DetallePersonal::where(function ($query) use ($primerDia, $ultimoDia) {
                $query->whereBetween('fecha_ingreso', [$primerDia->toDateString(), $ultimoDia->toDateString()])
                    ->orWhereBetween('fecha_salida', [$primerDia->toDateString(), $ultimoDia->toDateString()]);
            })
            ->when($personaId !== 'todos', function ($query) use ($personaId) {
                return $query->where('persona_id', $personaId);
            })
            ->orderBy('persona_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $detallesPorPersona = $allDetalle->groupBy('persona_id');
        $resultados = [];

        foreach ($allpersons as $persona) {
            $usuarioId = $persona->id;
            $resultados[$usuarioId] = [];
            for ($fechaActual = $primerDia->copy(); $fechaActual->lte($ultimoDia); $fechaActual->addDay()) {
                $fecha = $fechaActual->toDateString();
                $nombreDia = $fechaActual->translatedFormat('l');

                $resultados[$usuarioId][$fecha] = [
                    'detalles' => [],
                    'totalHorasTrabajadas' => 0,
                    'totalMinutosTrabajados' => 0,
                    'totalMinutosRetrasados' => 0,
                    'nombreDia' => ucfirst($nombreDia),
                ];
            }
        }

        foreach ($allDetalle as $detalle) {
            if (isset($resultados[$detalle->persona_id])) {
                $fechaRegistro = Carbon::parse($detalle->created_at)->toDateString();
                if (isset($resultados[$detalle->persona_id][$fechaRegistro])) {
                    $resultados[$detalle->persona_id][$fechaRegistro]['detalles'][] = $detalle;
                }
            }
        }

        foreach ($allpersons as $persona) {
            $usuarioId = $persona->id;
            $registrosPersona = $detallesPorPersona->get($usuarioId, collect());

            $ingresosPendientes = [];

            foreach ($registrosPersona as $registro) {
                if ($registro->estado === 'ingreso' && $registro->fecha_ingreso && $registro->hora_ingreso) {
                    $fechaParte = Carbon::parse($registro->fecha_ingreso)->toDateString();
                    $dtIngreso = Carbon::parse($fechaParte . ' ' . $registro->hora_ingreso);
                    $ingresosPendientes[] = $dtIngreso;
                } elseif ($registro->estado === 'salida' && $registro->fecha_salida && $registro->hora_salida && !empty($ingresosPendientes)) {
                    $dtIngreso = array_shift($ingresosPendientes);
                    $fechaParte = Carbon::parse($registro->fecha_salida)->toDateString();
                    $dtSalida = Carbon::parse($fechaParte . ' ' . $registro->hora_salida);
                    
                    if ($dtSalida->greaterThan($dtIngreso)) {
                        $diferenciaMinutos = $dtIngreso->diffInMinutes($dtSalida);

                        $horaIngresoPrevista = $dtIngreso->copy()->startOfHour();
                        $horaIngresoTolerancia = $horaIngresoPrevista->copy()->addMinutes(10);
                        
                        $retraso = 0;
                        if ($dtIngreso->greaterThan($horaIngresoTolerancia)) {
                            $retraso = $horaIngresoPrevista->diffInMinutes($dtIngreso);
                        }

                        $fechaIngresoStr = $dtIngreso->toDateString();

                        if (isset($resultados[$usuarioId][$fechaIngresoStr])) {
                            $minutosActuales = ($resultados[$usuarioId][$fechaIngresoStr]['totalHorasTrabajadas'] * 60) + $resultados[$usuarioId][$fechaIngresoStr]['totalMinutosTrabajados'];
                            $nuevosMinutosTotales = $minutosActuales + $diferenciaMinutos;
                            
                            $resultados[$usuarioId][$fechaIngresoStr]['totalHorasTrabajadas'] = intdiv($nuevosMinutosTotales, 60);
                            $resultados[$usuarioId][$fechaIngresoStr]['totalMinutosTrabajados'] = $nuevosMinutosTotales % 60;
                            $resultados[$usuarioId][$fechaIngresoStr]['totalMinutosRetrasados'] += $retraso;
                        }
                    }
                }
            }
        }

        $pdf = PDF::loadView('admin.personal.ReporteAsistencia', compact('resultados', 'allpersons'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('Planilla_' . now()->timestamp . '.pdf');
    }

    

    // Función para traducir los días en inglés a español (si se necesita)
    private function traducirDia($diaEnIngles) {
        $dias = [
            'Monday' => 'lunes',
            'Tuesday' => 'martes',
            'Wednesday' => 'miércoles',
            'Thursday' => 'jueves',
            'Friday' => 'viernes',
            'Saturday' => 'sábado',
            'Sunday' => 'domingo',
        ];
    
        return $dias[$diaEnIngles] ?? $diaEnIngles;
    }

    public function GetPersonas() {
        $personas = Persona::select('id', 'Nombre_Completo')->where('estado','true')->get();
        return response()->json($personas);
    }
    

    public function RegistrarPorPin(Request $request) {
        $fechaCompleta = $request->input('fecha');

        $fecha = $request->input('fecha');
        $hora = $request->input('hora');
        $opcion = $request->input('opcion');
        $pin = $request->input('pin');
    
        $persona = Persona::where('pin', $pin)->first();
    
        if (!$persona) {
            return response()->json(['error' => 'PIN incorrecto'], 400);
        }
    
        // Determinar si es ingreso o salida
        if ($opcion === 'Ingreso') {
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => $fecha,
                'hora_ingreso' => $hora,
                'fecha_salida' => null,
                'hora_salida' => null,
                'estado' => 'ingreso',
                'persona_id' => $persona->id,
            ]);
        } else {
            $Detalle = DetallePersonal::create([
                'fecha_ingreso' => null,
                'hora_ingreso' => null,
                'fecha_salida' => $fecha,
                'hora_salida' => $hora,
                'estado' => 'salida',
                'persona_id' => $persona->id,
            ]);
        }

        $Detalle->created_at = $fechaCompleta;
        $Detalle->updated_at = $fechaCompleta;
        $Detalle->save();
    
        return response()->json(['message' => 'Registro exitoso']);
    }

    public function DetalleRegistroPorPin($id){
        $detalleregistro = DetallePersonal::findOrFail($id);
        return response()->json($detalleregistro);
    }
    
    public function ActualicarInformacionPersona(Request $request) {
    
        $hora = $request->input('hora');
        $opcion = $request->input('opcion');
        $id = $request->input('id');
        $extra = $request->input('extra');

        $detalle = DetallePersonal::findOrFail($id);
        $salidafecha = $detalle->fecha_salida;
        $ingresofecha = $detalle->fecha_ingreso;
        $fechadetalle = "";

        if($detalle->estado === 'ingreso'){
            $fechadetalle = $detalle->fecha_ingreso;
        }else{
            $fechadetalle = $detalle->fecha_salida;
        }

        if ($opcion === 'Ingreso') {
            $detalle->fecha_ingreso = $fechadetalle;
            $detalle->fecha_salida = null;
            $detalle->hora_salida = null;
            $detalle->hora_ingreso = $hora;
            $detalle->estado = 'ingreso';
            $detalle->save();
        } else {
            $detalle->fecha_salida = $fechadetalle;
            $detalle->fecha_ingreso = null;
            $detalle->hora_ingreso = null;
            $detalle->hora_salida = $hora;
            $detalle->estado = 'salida';
            $detalle->save();
        }

        if($extra != "null"){
            $detalle->HoraExtra = 'true';
            $detalle->RazonHoraExtra = $extra;
            $detalle->save();
        }

        // CORRECCIÓN A PARTIR DE AQUÍ:
        if ($detalle->fecha_ingreso && $detalle->hora_ingreso) {
            $fecha = \Carbon\Carbon::parse($detalle->fecha_ingreso)->format('Y-m-d'); // Solo la fecha sin hora
            $fechaHoraIngreso = $fecha . ' ' . $detalle->hora_ingreso;
        } else {
            $fechaHoraIngreso = null;
            if ($detalle->fecha_salida && $detalle->hora_salida) {
                $fecha = \Carbon\Carbon::parse($detalle->fecha_salida)->format('Y-m-d'); // Solo la fecha sin hora
                $fechaHoraIngreso = $fecha . ' ' . $detalle->hora_salida;
            }
        }

        if ($fechaHoraIngreso) {
            $fechaHoraIngreso = \Carbon\Carbon::parse($fechaHoraIngreso)->format('Y-m-d H:i:s');
        }

        $detalle->created_at = $fechaHoraIngreso;
        $detalle->updated_at = $fechaHoraIngreso;
        $detalle->save();

        return response()->json(['message' => 'Registro exitoso']);
    }


    public function EliminarInformacionPersona(Request $request) {
        $id = $request->input('id');
    
        try {
            $detalle = DetallePersonal::findOrFail($id);
            $detalle->delete();
    
            return response()->json(['message' => 'Eliminación exitosa']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el registro: ' . $e->getMessage()], 500);
        }
    }

    public function GetPersonasActivas() {
        $activos = Persona::where('estado','true')->count();
        $inactivos = Persona::where('estado','false')->count();
        return response()->json([
            'activos' => $activos,
            'inactivos' => $inactivos
        ]);
    }
    
}
