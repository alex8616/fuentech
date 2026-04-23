<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno;
use App\Models\StockDate;
use App\Models\DetalleStockDate;
use Carbon\Carbon;
use App\Traits\CambiarEstadoTurnosTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class TurnoController extends Controller
{
    use CambiarEstadoTurnosTrait;

    public function GetTurnoAll(){
        $horaServidor = date('Y-m-d H:i:s');

        // Puedes hacer lo que necesites con la hora, por ejemplo, devolverla en un JSON
        return response()->json(['hora_servidor' => $horaServidor]);

        
        $turnos = Turno::get();

        $turnoscambiadoestado = $this->CambiarEstadoTurnos(); 

        return response()->json($turnoscambiadoestado);
    }

    public function GetTurnos(){
        $all = Turno::get();
        return response()->json($all);
    }

    /*public function CambiarEstadoTurnos(){
        $currentTime = Carbon::now()->format('H:i:s');
        $turnos = Turno::all();
        foreach ($turnos as $turno) {
            $inicio = Carbon::createFromFormat('H:i:s', $turno->Inicio);
            $fin = Carbon::createFromFormat('H:i:s', $turno->Fin);
            $current = Carbon::createFromFormat('H:i:s', $currentTime);
            if ($inicio < $fin) {
                $turno->Estado = $current >= $inicio && $current <= $fin ? 'true' : 'false';
            } else {
                $turno->Estado = $current >= $inicio || $current <= $fin ? 'true' : 'false';
            }
            $turno->save();
        }
        return response()->json($turnos);
    }*/


    public function filtrarDatosKardex(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $id = $request->input('idCaja'); 
        $fechaInicio = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
        $producto = $request->input('TipoProducto'); 
        $tipoStock = $request->input('TipoKardex'); 

        switch ($tipoFiltro) {
            case 'DiarioKardex':
                $Kardex = DetalleStockDate::with('stockdates', 'stockdates.productos')
                        ->whereDay('created_at', $dia)
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anio)
                        ->when($producto !== 'TodoProducto', function ($query) use ($producto) {
                            $query->whereHas('stockdates.productos', function ($subQuery) use ($producto) {
                                $subQuery->where('id', $producto);
                            });
                        })
                        ->when($tipoStock !== 'TodoTipos', function ($query) use ($tipoStock) {
                            $query->where('TipoStock', $tipoStock);
                        })
                        ->get();
            break;
            case 'MensualKardex':
                $Kardex = DetalleStockDate::with('stockdates', 'stockdates.productos')
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anio)
                        ->when($producto !== 'TodoProducto', function ($query) use ($producto) {
                            $query->whereHas('stockdates.productos', function ($subQuery) use ($producto) {
                                $subQuery->where('id', $producto);
                            });
                        })
                        ->when($tipoStock !== 'TodoTipos', function ($query) use ($tipoStock) {
                            $query->where('TipoStock', $tipoStock);
                        })
                        ->get();
            case 'AnualKardex':
                $Kardex = DetalleStockDate::with('stockdates', 'stockdates.productos')
                        ->whereYear('created_at', $anio)
                        ->when($producto !== 'TodoProducto', function ($query) use ($producto) {
                            $query->whereHas('stockdates.productos', function ($subQuery) use ($producto) {
                                $subQuery->where('id', $producto);
                            });
                        })
                        ->when($tipoStock !== 'TodoTipos', function ($query) use ($tipoStock) {
                            $query->where('TipoStock', $tipoStock);
                        })
                        ->get();
            case 'RangoKardex':
                
            break;
        }

        return response()->json([
            'Kardex' => $Kardex,
        ]);
    }


    public function filtrarDatosKardexMovimientos(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $id = $request->input('idCaja'); 
        $fechaInicio = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
        $producto = $request->input('TipoProducto'); 
        $tipoStock = $request->input('TipoKardex'); 

        switch ($tipoFiltro) {
            case 'DiarioKardex':
                $Kardex = DetalleStockDate::with('stockdates', 'stockdates.productos')
                        ->whereDay('created_at', $dia)
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anio)
                        ->when($producto !== 'TodoProducto', function ($query) use ($producto) {
                            $query->whereHas('stockdates.productos', function ($subQuery) use ($producto) {
                                $subQuery->where('id', $producto);
                            });
                        })
                        ->when($tipoStock !== 'TodoTipos', function ($query) use ($tipoStock) {
                            $query->where('TipoStock', $tipoStock);
                        })
                        ->get();
            break;
            case 'MensualKardex':
                $Kardex = DetalleStockDate::with('stockdates', 'stockdates.productos')
                        ->whereMonth('created_at', $mes)
                        ->whereYear('created_at', $anio)
                        ->when($producto !== 'TodoProducto', function ($query) use ($producto) {
                            $query->whereHas('stockdates.productos', function ($subQuery) use ($producto) {
                                $subQuery->where('id', $producto);
                            });
                        })
                        ->when($tipoStock !== 'TodoTipos', function ($query) use ($tipoStock) {
                            $query->where('TipoStock', $tipoStock);
                        })
                        ->get();
            case 'AnualKardex':
                $Kardex = DetalleStockDate::with('stockdates', 'stockdates.productos')
                        ->whereYear('created_at', $anio)
                        ->when($producto !== 'TodoProducto', function ($query) use ($producto) {
                            $query->whereHas('stockdates.productos', function ($subQuery) use ($producto) {
                                $subQuery->where('id', $producto);
                            });
                        })
                        ->when($tipoStock !== 'TodoTipos', function ($query) use ($tipoStock) {
                            $query->where('TipoStock', $tipoStock);
                        })
                        ->get();
            case 'RangoKardex':
                
            break;
        }

        $pdf = PDF::loadView('admin.kardex.ReportMovimientoKardex', compact('Kardex'))
                    ->setPaper(array(0,0,595.28,841.89), 'portrait');;

        return $pdf->stream('ReportMovimientoKardex.pdf');

    }
}
