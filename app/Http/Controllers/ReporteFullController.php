<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AmbienteMesa;
use App\Models\Cliente;
use App\Models\ClienteTemporal;
use App\Models\Consumo;
use App\Models\DescuentoConsumo;
use App\Models\DetalleConsumo;
use App\Models\ModificadorDetalleConsumo;
use App\Models\Pagos;
use App\Models\Producto;
use App\Models\StockDate;
use App\Models\ArqueoCaja;
use App\Models\Caja;
use App\Models\DetalleCaja;
use App\Models\ReservaSalones;
use App\Models\HospedajeHabitacion;
use App\Models\GrupoHospedaje;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteFullController extends Controller
{
    
    public function FullVentasGet(Request $request){
        //return response()->json($request);

        $ingreso = 0;
        $salida = 0; 
        $tipoFiltro = $request->input('tipoFiltro');
        $tipoPago = $request->input('tipoPago');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoMovimientoReporteVenta = $request->input('TipoMovimientoReporteVenta');
        $ingresoSum = 0;
        $salidaSum = 0;

        $datediario = '';
        $datemes = '';
        $dateanual = '';
        $daterangoInicio = '';
        $daterangoFinal = '';
        $dateservicio = '';
        $totalmonto = 0;
        $totalefec = 0;
        $totaltar = 0;
        $totaldepo = 0;

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioMovimientoReporteVenta':

                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereDay('created_at', $dia)
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto','pagosconsumos'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereDay('created_at', $dia)
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->when($tipoPago && $tipoPago !== 'TodoPago', function($query) use ($tipoPago) {
                        return $query->whereHas('pagosconsumos', function($query) use ($tipoPago) {
                            $query->where('TipoPago', $tipoPago);
                        });
                    })
                    ->with(['pagosconsumos'])
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }
                        $totalProductosVendidos += $cantidad;
                    }                   
                    
                    $totalmonto += $consumo->total; 

                    foreach ($consumo->pagosconsumos as $pago) {
                        if($pago->TipoPago == "Efectivo"){
                            $totalefec += $pago->TotalPago;
                        }
                        if($pago->TipoPago == "Tarjeta"){
                            $totaltar += $pago->TotalPago;                            
                        }
                        if($pago->TipoPago == "Deposito/QR"){
                            $totaldepo += $pago->TotalPago;                        
                        }
                    }
                }
                

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                
                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                
                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                
                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                
                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereDay('created_at', $dia)
                            ->whereMonth('created_at', $mes)
                            ->whereYear('created_at', $anio);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                
                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                 $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                
                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/

                $datediario = $dia;
                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "DiarioMovimientoReporteVenta";
                $tipoPago = $tipoPago;
                $totalmonto = $totalmonto; 

            break;
            case 'MensualMovimientoReporteVenta':
               $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();
                                    
                
                                    
                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;

                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }

                        $totalProductosVendidos += $cantidad;
                    }
                }

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                
                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                
                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                
                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                
                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereMonth('created_at', $mes)
                            ->whereYear('created_at', $anio);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                
                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                    $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                
                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/

                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "MensualMovimientoReporteVenta";
                $tipoPago = $tipoPago;

            break;
            case 'AnualMovimientoReporteVenta':
                                    
               $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->whereYear('created_at', $anio)
                                    ->get();
                                    
                
                                    
                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereYear('created_at', $anio)
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereYear('created_at', $anio)
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;

                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }

                        $totalProductosVendidos += $cantidad;
                    }
                }

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                
                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                
                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                
                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                
                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereYear('created_at', $anio);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                
                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                    $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                
                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/
                                    

                $dateanual = $anio;
                $dateservicio = "AnualMovimientoReporteVenta";
                $tipoPago = $tipoPago;

            break;
            case 'RangoMovimientoReporteVenta':
                   
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                ->get();                                                
                                    
                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;

                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }

                        $totalProductosVendidos += $cantidad;
                    }
                }

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                
                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                
                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                
                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                
                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereBetween('created_at', [$fechaInicio, $fechaFin]);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                
                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                    $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                
                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/
                
                $daterangoInicio = $fechaInicio;
                $daterangoFinal = $fechaFin;
                $dateservicio = "RangoMovimientoReporteVenta";
                $tipoPago = $tipoPago;
            break;
        }

        return response()->json([
            'consumos' => $consumos,
            'consumomesas' => $consumomesas,
            'consumomostradores' => $consumomostradores,
            'consumodeliverys' => $consumodeliverys,
            'consumohabitacions' => $consumohabitacions,
            'consumosalones' => $consumosalones,
            'consumopedidosya' => $consumopedidosya,

            'productosCantidad' => $productosCantidad,
            'productosCantidadMesas' => $productosCantidadMesas,
            'productosCantidadMostrador' => $productosCantidadMostrador,
            'productosCantidadDelivery' => $productosCantidadDelivery,
            'productosCantidadHabitacion' => $productosCantidadHabitacion,
            'productosCantidadSalone' => $productosCantidadSalone,
            'productosCantidadPedidoYa' => $productosCantidadPedidoYa,

            'totalProductosVendidos' => $totalProductosVendidos,
            'totalProductosVendidosMesas' => $totalProductosVendidosMesas,
            'totalProductosVendidosMostrador' => $totalProductosVendidosMostrador,
            'totalProductosVendidosDelivery' => $totalProductosVendidosDelivery,
            'totalProductosVendidosHabitacion' => $totalProductosVendidosHabitacion,
            'totalProductosVendidosSalone' => $totalProductosVendidosSalone,
            'totalProductosVendidosPedidoYa' => $totalProductosVendidosPedidoYa,

            'seleccion' => $dateservicio,
            'dia' => $datediario,
            'mes' => $datemes,
            'anio' => $dateanual,
            'inicio' => $daterangoInicio,
            'fin' => $daterangoFinal,
            'pago' => $tipoPago,
            'total' => $totalmonto,
            'totalefectivo' => $totalefec,
            'totaltarjeta' => $totaltar,
            'totaldeposito' => $totaldepo,
        ]);
    }

    public function FullVentasGetPDF(Request $request){
        $ingreso = 0;
        $salida = 0; 
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoMovimientoReporteVenta = $request->input('TipoMovimientoReporteVenta');
        $ingresoSum = 0;
        $salidaSum = 0;

        $datediario = '';
        $datemes = '';
        $dateanual = '';
        $daterangoInicio = '';
        $daterangoFinal = '';
        $dateservicio = '';

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioMovimientoReporteVenta':

                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereDay('created_at', $dia)
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereDay('created_at', $dia)
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;
                $totalconsumo = $consumos->sum('total');

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;

                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }

                        $totalProductosVendidos += $cantidad;
                    }
                }

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                $totalMesas = $consumomesas->sum('total');

                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                $totalMostrador = $consumomostradores->sum('total');
                
                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                $totalDelivery = $consumodeliverys->sum('total');
                
                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                $totalHabitacion = $consumohabitacions->sum('total');
                
                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereDay('created_at', $dia)
                            ->whereMonth('created_at', $mes)
                            ->whereYear('created_at', $anio);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                $totalSalone = $consumosalones->sum('total');
                
                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                 $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                $totalPedidoYa = $consumopedidosya->sum('total');
                
                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/

                $datediario = $dia;
                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "DiarioMovimientoReporteVenta";
            break;
            case 'MensualMovimientoReporteVenta':
               $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();
                                    
                
                                    
                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;
                $totalconsumo = $consumos->sum('total');

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;

                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }

                        $totalProductosVendidos += $cantidad;
                    }
                }

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                $totalMesas = $consumomesas->sum('total');
                
                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                $totalMostrador = $consumomostradores->sum('total');
                
                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                $totalDelivery = $consumodeliverys->sum('total');

                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                $totalHabitacion = $consumohabitacions->sum('total');

                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereMonth('created_at', $mes)
                            ->whereYear('created_at', $anio);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                $totalSalone = $consumosalones->sum('total');

                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                    $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                $totalPedidoYa = $consumopedidosya->sum('total');

                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/

                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "MensualMovimientoReporteVenta";

            break;
            case 'AnualMovimientoReporteVenta':
                                    
               $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->whereYear('created_at', $anio)
                                    ->get();
                                    
                
                                    
                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereYear('created_at', $anio)
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereYear('created_at', $anio)
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;
                $totalconsumo = $consumos->sum('total');

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;

                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }

                        $totalProductosVendidos += $cantidad;
                    }
                }

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                $totalMesas = $consumomesas->sum('total');

                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                $totalMostrador = $consumomostradores->sum('total');

                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                $totalDelivery = $consumodeliverys->sum('total');

                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                $totalHabitacion = $consumohabitacions->sum('total');

                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereYear('created_at', $anio);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                $totalSalone = $consumosalones->sum('total');

                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                    $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereYear('created_at', $anio)
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                $totalPedidoYa = $consumopedidosya->sum('total');

                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/
                                    

                $dateanual = $anio;
                $dateservicio = "AnualMovimientoReporteVenta";

            break;
            case 'RangoMovimientoReporteVenta':
                   
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                ->get();                                                
                                    
                $salones = Consumo::where('TipoConsumo', 'Salon')
                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                    ->whereHas('consumoservicio.reservasalon', function ($query) {
                        $query->where('Estado', 'COMPLETO');
                    })
                    ->with(['consumoservicio', 'consumoservicio.reservasalon'])
                    ->get();

                // Obtener consuos que no son del tipo 'Salon'
                $consumos = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                    ->where('TipoConsumo', '!=', 'Salon')
                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                    ->get();

                $salones->each(function ($salon) use ($consumos) {
                    $consumos->push($salon); 
                });

                $productosCantidad = [];
                $totalProductosVendidos = 0;
                $totalconsumo = $consumos->sum('total');

                foreach ($consumos as $consumo) {
                    foreach ($consumo->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;

                        if (isset($productosCantidad[$nombreProducto])) {
                            $productosCantidad[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidad[$nombreProducto] = $cantidad;
                        }

                        $totalProductosVendidos += $cantidad;
                    }
                }

                //return response()->json([$salones, $productosCantidad, $totalProductosVendidos]);

                /*MESAS INICIO*/
                $consumomesas = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mesa')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadMesas = [];
                $totalProductosVendidosMesas = 0;
                $totalMesas = $consumomesas->sum('total');

                foreach ($consumomesas as $consumomesa) {
                    foreach ($consumomesa->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMesas[$nombreProducto])) {
                            $productosCantidadMesas[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMesas[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMesas += $cantidad;
                    }
                }                
                /*MESAS FIN*/

                /*MOSTRADOR INICIO*/
                $consumomostradores = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Mostrador')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadMostrador = [];
                $totalProductosVendidosMostrador = 0;
                $totalMostrador = $consumomostradores->sum('total');

                foreach ($consumomostradores as $consumomostrador) {
                    foreach ($consumomostrador->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadMostrador[$nombreProducto])) {
                            $productosCantidadMostrador[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadMostrador[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosMostrador += $cantidad;
                    }
                }
                /*MOSTRADOR FIN*/

                /*DELIVERY INICIO*/
                $consumodeliverys = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Delivery')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadDelivery = [];
                $totalProductosVendidosDelivery = 0;
                $totalDelivery = $consumodeliverys->sum('total');

                foreach ($consumodeliverys as $consumodelivery) {
                    foreach ($consumodelivery->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadDelivery[$nombreProducto])) {
                            $productosCantidadDelivery[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadDelivery[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosDelivery += $cantidad;
                    }
                }
                /*DELIVERY FIN*/

                /*HABITACION INICIO*/
                $consumohabitacions = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'Habitacion')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadHabitacion = [];
                $totalProductosVendidosHabitacion = 0;
                $totalHabitacion = $consumohabitacions->sum('total');

                foreach ($consumohabitacions as $consumohabitacion) {
                    foreach ($consumohabitacion->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadHabitacion[$nombreProducto])) {
                            $productosCantidadHabitacion[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadHabitacion[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosHabitacion += $cantidad;
                    }
                }
                /*HABITACION FIN*/

                /*SALONES INICIO*/
                $salon = ReservaSalones::where('Estado', 'COMPLETO')
                    ->with(['servicioconsumos', 'servicioconsumos.consumo' => function ($query) use ($dia, $mes, $anio) {
                        $query->where('TipoConsumo', 'Salon')
                            ->whereBetween('created_at', [$fechaInicio, $fechaFin]);
                    }])->first();

                $consumosalones = $salon ? $salon->servicioconsumos->pluck('consumo')->flatten() : collect();

                $productosCantidadSalone = [];
                $totalProductosVendidosSalone = 0;
                $totalSalone = $consumosalones->sum('total');

                foreach ($consumosalones as $consumosalone) {
                    foreach ($consumosalone->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadSalone[$nombreProducto])) {
                            $productosCantidadSalone[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadSalone[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosSalone += $cantidad;
                    }
                }
                /*SALONES FIN*/

                /*PEDIDOSYA-DINKI INICIO*/
                    $consumopedidosya = Consumo::with(['detalleconsumos', 'detalleconsumos.producto'])
                                    ->where('TipoConsumo', 'ServicioPedido')
                                    ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                    ->get();

                $productosCantidadPedidoYa = [];
                $totalProductosVendidosPedidoYa = 0;
                $totalPedidoYa = $consumopedidosya->sum('total');

                foreach ($consumopedidosya as $consumopedidos) {
                    foreach ($consumopedidos->detalleconsumos as $detalle) {
                        $nombreProducto = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
                
                        if (isset($productosCantidadPedidoYa[$nombreProducto])) {
                            $productosCantidadPedidoYa[$nombreProducto] += $cantidad;
                        } else {
                            $productosCantidadPedidoYa[$nombreProducto] = $cantidad;
                        }
                
                        $totalProductosVendidosPedidoYa += $cantidad;
                    }
                }
                /*PEDIDOSYA-DINKI FIN*/
                
                $daterangoInicio = $fechaInicio;
                $daterangoFinal = $fechaFin;
                $dateservicio = "RangoMovimientoReporteVenta";

            break;
        }


        $pdf = PDF::loadView('admin.venta.FullVentaPDF', [
            'consumos' => $consumos,
            'consumomesas' => $consumomesas,
            'consumomostradores' => $consumomostradores,
            'consumodeliverys' => $consumodeliverys,
            'consumohabitacions' => $consumohabitacions,
            'consumosalones' => $consumosalones,
            'consumopedidosya' => $consumopedidosya,

            'productosCantidad' => $productosCantidad,
            'productosCantidadMesas' => $productosCantidadMesas,
            'productosCantidadMostrador' => $productosCantidadMostrador,
            'productosCantidadDelivery' => $productosCantidadDelivery,
            'productosCantidadHabitacion' => $productosCantidadHabitacion,
            'productosCantidadSalone' => $productosCantidadSalone,
            'productosCantidadPedidoYa' => $productosCantidadPedidoYa,

            'totalProductosVendidos' => $totalProductosVendidos,
            'totalProductosVendidosMesas' => $totalProductosVendidosMesas,
            'totalProductosVendidosMostrador' => $totalProductosVendidosMostrador,
            'totalProductosVendidosDelivery' => $totalProductosVendidosDelivery,
            'totalProductosVendidosHabitacion' => $totalProductosVendidosHabitacion,
            'totalProductosVendidosSalone' => $totalProductosVendidosSalone,
            'totalProductosVendidosPedidoYa' => $totalProductosVendidosPedidoYa,

            'totalconsumo' => $totalconsumo,
            'totalMesas' => $totalMesas,
            'totalMostrador' => $totalMostrador,
            'totalDelivery' => $totalDelivery,
            'totalHabitacion' => $totalHabitacion,
            'totalSalone' => $totalSalone,
            'totalPedidoYa' => $totalPedidoYa,

            'seleccion' => $dateservicio,
            'dia' => $datediario,
            'mes' => $datemes,
            'anio' => $dateanual,
            'inicio' => $daterangoInicio,
            'fin' => $daterangoFinal,
        ])
            ->setOptions(['defaultFont' => 'sans-serif'])
            ->setPaper(array(0,0,595.28,841.89), 'portrait');

        return $pdf->stream('Date.pdf');
    }
 
    public function FullHostalGet(Request $request){
        $ingreso = 0;
        $salida = 0; 
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoMovimientoReporteVenta = $request->input('TipoMovimientoReporteVenta');
        $ingresoSum = 0;
        $salidaSum = 0;

        $datediario = '';
        $datemes = '';
        $dateanual = '';
        $daterangoInicio = '';
        $daterangoFinal = '';
        $dateservicio = '';

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioMovimientoReporteVenta':

                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereDay('salida_hospedaje', $dia)
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereDay('salida_hospedaje', $dia)
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereDay('salida_reserva', $dia)
                    ->whereMonth('salida_reserva', $mes)
                    ->whereYear('salida_reserva', $anio)
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $datediario = $dia;
                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "DiarioMovimientoReporteVenta";
            break;
            case 'MensualMovimientoReporteVenta':
                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereMonth('salida_reserva', $mes)
                    ->whereYear('salida_reserva', $anio)
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "MensualMovimientoReporteVenta";

            break;
            case 'AnualMovimientoReporteVenta':

                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereYear('salida_reserva', $anio)
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $dateanual = $anio;
                $dateservicio = "AnualMovimientoReporteVenta";
            break;
            case 'RangoMovimientoReporteVenta':
                
                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereBetween('salida_hospedaje', [$fechaInicio, $fechaFin])
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereBetween('salida_hospedaje', [$fechaInicio, $fechaFin])
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereBetween('salida_reserva', [$fechaInicio, $fechaFin])
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $daterangoInicio = $fechaInicio;
                $daterangoFinal = $fechaFin;
                $dateservicio = "RangoMovimientoReporteVenta";
            break;
        }

        return response()->json([
            'hospedajes' => $hospedajes,
            'grupohospedajes' => $grupohospedajes,
            'reservashospedaje' => $reservashospedaje,
    
            'CantidadHospedajes' => $CantidadHospedajes,
            'CantidadGrupos' => $CantidadGrupos,
            'CantidadReservas' => $CantidadReservas,

            'TotalHospedajes' => $TotalHospedajes,
            'TotalGrupos' => $TotalGrupos,
            'TotalReservas' => $TotalReservas,
            'TotalGeneral' => $TotalGeneral,

            'seleccion' => $dateservicio,
            'dia' => $datediario,
            'mes' => $datemes,
            'anio' => $dateanual,
            'inicio' => $daterangoInicio,
            'fin' => $daterangoFinal,
        ]);
    }

    public function FullHostalGetPDF(Request $request){
        $ingreso = 0;
        $salida = 0; 
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoMovimientoReporteVenta = $request->input('TipoMovimientoReporteVenta');
        $ingresoSum = 0;
        $salidaSum = 0;

        $datediario = '';
        $datemes = '';
        $dateanual = '';
        $daterangoInicio = '';
        $daterangoFinal = '';
        $dateservicio = '';

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioMovimientoReporteVenta':

                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereDay('salida_hospedaje', $dia)
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereDay('salida_hospedaje', $dia)
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereDay('salida_reserva', $dia)
                    ->whereMonth('salida_reserva', $mes)
                    ->whereYear('salida_reserva', $anio)
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $datediario = $dia;
                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "DiarioMovimientoReporteVenta";
            break;
            case 'MensualMovimientoReporteVenta':
                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereMonth('salida_hospedaje', $mes)
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereMonth('salida_reserva', $mes)
                    ->whereYear('salida_reserva', $anio)
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $datemes = $mes;
                $dateanual = $anio;
                $dateservicio = "MensualMovimientoReporteVenta";

            break;
            case 'AnualMovimientoReporteVenta':

                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereYear('salida_hospedaje', $anio)
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereYear('salida_reserva', $anio)
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $dateanual = $anio;
                $dateservicio = "AnualMovimientoReporteVenta";
            break;
            case 'RangoMovimientoReporteVenta':
                
                $hospedajes = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])
                    ->where('EstadoHospedaje', 'false')->where('EstadoHospedajeGrupo', 'false')->where('Reserva', 'false')
                    ->whereBetween('salida_hospedaje', [$fechaInicio, $fechaFin])
                    ->get();
                
                $grupohospedajes = GrupoHospedaje::with(['hospedajes', 'hospedajes.habitacion', 'hospedajes.detallehospedajes', 'hospedajes.detallehospedajes.cliente'])
                    ->where('EstadoGrupo', 'CONCLUIDO')
                    ->whereBetween('salida_hospedaje', [$fechaInicio, $fechaFin])
                    ->get();
                
                $reservashospedaje = Reserva::with(['hospedajehabitacion','hospedajehabitacion.detallehospedajes','hospedajehabitacion.detallehospedajes.cliente'])
                    ->where('EstadoReserva', 'CONCLUIDO')
                    ->whereBetween('salida_reserva', [$fechaInicio, $fechaFin])
                    ->whereHas('hospedajehabitacion', function ($query) {
                        $query->where('Reserva', "true");
                    })
                    ->get();                                  
                
                $CantidadHospedajes = $hospedajes->count();
                $CantidadGrupos = $grupohospedajes->count();
                $CantidadReservas = $reservashospedaje->count();

                $TotalHospedajes = $hospedajes->sum('Total');
                $TotalGrupos = $grupohospedajes->sum('Total');
                $TotalReservas = $reservashospedaje->sum(function ($reserva) {
                    return $reserva->hospedajehabitacion->Total ?? 0;
                });
                $TotalGeneral = $TotalHospedajes + $TotalGrupos + $TotalReservas;

                $daterangoInicio = $fechaInicio;
                $daterangoFinal = $fechaFin;
                $dateservicio = "RangoMovimientoReporteVenta";
            break;
        }

        $pdf = PDF::loadView('admin.venta.FullHospedajePDF', [
            'hospedajes' => $hospedajes,
            'grupohospedajes' => $grupohospedajes,
            'reservashospedaje' => $reservashospedaje,
    
            'CantidadHospedajes' => $CantidadHospedajes,
            'CantidadGrupos' => $CantidadGrupos,
            'CantidadReservas' => $CantidadReservas,

            'TotalHospedajes' => $TotalHospedajes,
            'TotalGrupos' => $TotalGrupos,
            'TotalReservas' => $TotalReservas,
            'TotalGeneral' => $TotalGeneral,

            'seleccion' => $dateservicio,
            'dia' => $datediario,
            'mes' => $datemes,
            'anio' => $dateanual,
            'inicio' => $daterangoInicio,
            'fin' => $daterangoFinal,
        ])
            ->setOptions(['defaultFont' => 'sans-serif'])
            ->setPaper(array(0,0,595.28,841.89), 'portrait');

        return $pdf->stream('Date.pdf');
    }
}