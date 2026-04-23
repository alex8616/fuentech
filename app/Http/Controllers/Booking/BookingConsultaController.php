<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BookingDisponibilidadHabitacion;
use App\Models\CategoriaHabitacion; 
use App\Models\TipoHabitacion; 
use App\Models\BookingCalendario; 
use App\Models\BookingReservaDetalle; 
use App\Models\BookingReserva; 
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaCreada;
use Illuminate\Support\Facades\DB;

class BookingConsultaController extends Controller
{
    public function PagePrincipal(){
        return view('booking.index');
    }
    
    public function BuscarDisponibilidad(){
        return view('booking.resultadosbuscar');
    }

    public function disponibilidad(Request $request){

        $checkin  = $request->input('checkin');
        $checkout = $request->input('checkout');

        if (!$checkin || !$checkout) {
            return response()->json([]);
        }

        // Rango SIN incluir checkout
        $period = CarbonPeriod::create($checkin, Carbon::parse($checkout)->subDay());

        $fechas = [];
        foreach ($period as $date) {
            $fechas[] = $date->format('Y-m-d');
        }

        $rooms = TipoHabitacion::all();
        $result = [];

        foreach ($rooms as $room) {

            $disponiblesPorDia = [];
            $precioTotal = 0;
            $bloqueado = false;

            foreach ($fechas as $fecha) {

                $cal = BookingCalendario::where('tipo_habitacion_id', $room->id)
                    ->where('fecha', $fecha)
                    ->first();

                // 🔴 SI EXISTE Y ESTÁ CERRADO → BLOQUEAR TODO
                if ($cal && $cal->cerrado == 1) {
                    $bloqueado = true;
                    break;
                }

                // 🟢 DISPONIBILIDAD DEL DÍA
                $cantidadDia = $cal 
                    ? ($cal->total - $cal->reservadas - $cal->bloqueadas) 
                    : $room->cantidad;

                $disponiblesPorDia[] = $cantidadDia;

                // 💰 PRECIO
                $precioTotal += $cal ? $cal->precio : $room->precio_base;
            }

            // 🔴 SI ALGÚN DÍA ESTÁ BLOQUEADO → NO DISPONIBLE
            if ($bloqueado) {
                $disponiblesFinal = 0;
                $precioTotal = 0;
            } else {
                $disponiblesFinal = !empty($disponiblesPorDia)
                    ? min($disponiblesPorDia)
                    : $room->cantidad;
            }

            $result[] = [
                'id'         => $room->id,
                'nombre'     => $room->nombre,
                'disponibles'=> (int) $disponiblesFinal,
                'precio'     => (float) $precioTotal,
            ];
        }

        return response()->json($result);
    }

    public function EnviarReserva(Request $request)
    {
        $request->validate([
            'checkin'   => 'required|date',
            'checkout'  => 'required|date|after:checkin',
            'nombre'    => 'required|string|max:255',
            'telefono'  => 'required|string|max:50',
            'email'     => 'nullable|email',
            'observaciones' => 'nullable|string',

            // 🔥 NUEVO: array de habitaciones
            'rooms' => 'required|array|min:1',
            'rooms.*.id' => 'required|integer',
            'rooms.*.cantidad' => 'required|integer|min:1',
            'rooms.*.precio' => 'nullable|numeric'
        ]);

        DB::beginTransaction();

        try {

            // 🔥 código único
            $codigo = 'RES-' . strtoupper(Str::random(6));

            // 🔥 calcular total de adultos automáticamente (opcional)
            $totalHabitaciones = collect($request->rooms)->sum('cantidad');

            // 🔥 crear reserva principal
            $reserva = BookingReserva::create([
                'codigo_reserva' => $codigo,
                'nombre'         => $request->nombre,
                'telefono'       => $request->telefono,
                'email'          => $request->email,
                'fecha_ingreso'  => $request->checkin,
                'fecha_salida'   => $request->checkout,
                'adultos'        => $totalHabitaciones, // 🔥 puedes mejorar esto luego
                'ninos'          => 0,
                'estado'         => 'pendiente',
            ]);

            // 🔥 guardar múltiples detalles
            foreach ($request->rooms as $room) {

                BookingReservaDetalle::create([
                    'booking_reserva_id' => $reserva->id,
                    'tipo_habitacion_id' => $room['id'],
                    'cantidad'           => $room['cantidad'],
                    'precio'             => $room['precio'] ?? null,
                ]);
            }

            // 🔥 enviar correo
            if($request->email){
                Mail::to($request->email)->send(new ReservaCreada($reserva));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reserva creada correctamente',
                'codigo'  => $codigo
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar reserva',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verEstado($codigo){
        $reserva = BookingReserva::where('codigo_reserva', $codigo)->firstOrFail();
        return view('booking.estado', compact('reserva'));
    }
}
