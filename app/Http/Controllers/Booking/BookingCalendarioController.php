<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TipoHabitacion;
use App\Models\BookingCalendario;

class BookingCalendarioController extends Controller
{

    public function data(Request $request){
        $mes = $request->mes ?? now()->format('Y-m');

        $inicio = Carbon::parse($mes)->startOfMonth();
        $fin    = Carbon::parse($mes)->endOfMonth();

        /* =========================
        GENERAR FECHAS DEL MES
        ========================= */

        $fechas = [];
        $cursor = $inicio->copy();

        while ($cursor <= $fin) {

            $fechas[] = [
                'fecha' => $cursor->format('Y-m-d'),
                'dia' => $cursor->format('d'),
                'dia_semana' => $cursor->translatedFormat('D')
            ];

            $cursor->addDay();
        }

        /* =========================
        TRAER CALENDARIO DEL MES
        ========================= */

        $calendarios = BookingCalendario::whereBetween('fecha', [$inicio, $fin])
            ->get()
            ->groupBy('tipo_habitacion_id');

        /* =========================
        ARMAR HABITACIONES
        ========================= */

        $rooms = TipoHabitacion::all()->map(function ($room) use ($fechas, $calendarios) {

            $precios = [];
            $habitaciones = [];
            $cerrados = [];

            $calRoom = $calendarios->get($room->id);

            foreach ($fechas as $f) {

                $fecha = $f['fecha'];

                $cal = $calRoom
                    ? $calRoom->firstWhere('fecha', $fecha)
                    : null;

                $precios[$fecha] = $cal ? $cal->precio : $room->precio_base;
                $habitaciones[$fecha] = $cal ? $cal->total : $room->cantidad;
                $cerrados[$fecha] = $cal ? $cal->cerrado : 0;
            }

            return [
                'id' => $room->id,
                'nombre' => $room->nombre,
                'precios' => $precios,
                'habitaciones' => $habitaciones,
                'cerrados' => $cerrados
            ];
        });

        /* =========================
        RESPUESTA JSON
        ========================= */

        return response()->json([
            'titulo' => Carbon::parse($mes)->translatedFormat('F Y'),
            'fechas' => $fechas,
            'rooms' => $rooms
        ]);
    }

    public function update(Request $request){

        //return response()->json($request->all());

        $room_id = $request->room_id;
        $fecha = $request->fecha;
        $campo = $request->campo;
        $valor = $request->valor;

        if (!$room_id) {

            return response()->json([
                'error' => 'Room ID missing'
            ], 400);

        }

        $registro = BookingCalendario::firstOrCreate(

            [
                'tipo_habitacion_id' => $room_id,
                'fecha' => $fecha
            ]

        );

        $registro->$campo = $valor;

        $registro->save();

        return response()->json([
            'success' => true
        ]);

    }

    public function calendarioData(Request $request){

        $mes = $request->mes ?? now()->format('Y-m');

        $inicio = Carbon::parse($mes.'-01');
        $fin = $inicio->copy()->endOfMonth();

        $titulo = $inicio->translatedFormat('F Y');

        $fechas = [];

        for($d = $inicio->copy(); $d <= $fin; $d->addDay()){

            $fechas[] = [
                'fecha' => $d->format('Y-m-d'),
                'dia' => $d->format('d'),
                'dia_semana' => $d->translatedFormat('D')
            ];
        }

        $rooms = TipoHabitacion::all();

        $roomsData = [];

        foreach($rooms as $room){

            $precios = [];
            $habitaciones = [];

            foreach($fechas as $f){

                $cal = BookingCalendario::where('tipo_habitacion_id',$room->id)
                    ->where('fecha',$f['fecha'])
                    ->first();

                $precios[$f['fecha']] = $cal ? $cal->precio : null;
                $habitaciones[$f['fecha']] = $cal ? $cal->total : $room->cantidad;
            }

            $roomsData[] = [
                'id'=>$room->id,
                'nombre'=>$room->nombre,
                'precios'=>$precios,
                'habitaciones'=>$habitaciones
            ];
        }

        return response()->json([
            'titulo'=>$titulo,
            'fechas'=>$fechas,
            'rooms'=>$roomsData
        ]);
    }


    public function updateCalendario(Request $request){

        $room = $request->room_id;
        $fecha = $request->fecha;
        $campo = $request->campo;
        $valor = $request->valor;

        $cal = BookingCalendario::firstOrCreate(
            [
                'tipo_habitacion_id'=>$room,
                'fecha'=>$fecha
            ],
            [
                'total'=>0,
                'reservadas'=>0,
                'bloqueadas'=>0,
                'precio'=>0,
                'cerrado'=>0,
                'min_noches'=>1
            ]
        );

        if($campo == "precio"){
            $cal->precio = $valor;
        }

        if($campo == "habitaciones"){
            $cal->total = $valor;
        }

        $cal->save();

        return response()->json([
            'success'=>true
        ]);
    }

    public function updateMasivoCalendario(Request $request){
        //return response()->json($request->all());
        $room   = $request->room_id;
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin    = Carbon::parse($request->fecha_fin);
        $precio = $request->precio;

        while ($inicio <= $fin) {

            $fecha = $inicio->format('Y-m-d');

            $cal = BookingCalendario::firstOrCreate(
                [
                    'tipo_habitacion_id' => $room,
                    'fecha' => $fecha
                ],
                [
                    'total' => 0,
                    'reservadas' => 0,
                    'bloqueadas' => 0,
                    'precio' => 0,
                    'cerrado' => 0,
                    'min_noches' => 1
                ]
            );

            $cal->precio = $precio;
            $cal->save();

            $inicio->addDay();
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function updateMasivoCantidad(Request $request){

        $room   = $request->room_id;
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin    = Carbon::parse($request->fecha_fin);
        $cantidad = $request->cantidad;

        while ($inicio <= $fin) {

            $fecha = $inicio->format('Y-m-d');

            $cal = BookingCalendario::firstOrCreate(
                [
                    'tipo_habitacion_id' => $room,
                    'fecha' => $fecha
                ],
                [
                    'total' => 0,
                    'reservadas' => 0,
                    'bloqueadas' => 0,
                    'precio' => 0,
                    'cerrado' => 0,
                    'min_noches' => 1
                ]
            );

            $cal->total = $cantidad;

            $cal->save();

            $inicio->addDay();
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function updateCerrarDia(Request $request){

        $cal = BookingCalendario::firstOrCreate(
            [
                'tipo_habitacion_id'=>$request->room_id,
                'fecha'=>$request->fecha
            ],
            [
                'total'=>0,
                'reservadas'=>0,
                'bloqueadas'=>0,
                'precio'=>0,
                'cerrado'=>0,
                'min_noches'=>1
            ]
        );

        $cal->update([
            'cerrado'=>$request->cerrado
        ]);

        return response()->json($cal);

        return response()->json([
            'success'=>true
        ]);
    }
}