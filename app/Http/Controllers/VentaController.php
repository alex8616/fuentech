<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumo;
use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{

    public function GetConsumoAll() {
        $today = \Carbon\Carbon::today();
        $ventas = Consumo::with(['cliente', 'user', 'cliente', 'camarero','pagosconsumos'])
                         ->whereDate('created_at', $today)
                         ->get();
    
        $countventas = $ventas->count();
        $totalSum = round($ventas->sum('total'), 2);
     
        if ($countventas > 0) {
            $promedioventa = round($totalSum / $countventas, 2);
        } else {
            $promedioventa = 0;
        }

        $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);

        if ($cantpersonas > 0) {
            $promediopersonas = round($totalSum / $cantpersonas, 2);
        } else {
            $promediopersonas = 0;
        }

        return response()->json([
            'ventas' => $ventas,
            'totalSum' => $totalSum,
            'cantidadventas' => $countventas,
            'promedioventa' => $promedioventa,
            'cantpersonas' => $cantpersonas,
            'promediopersonas' => $promediopersonas,
        ]);
    }
    
    public function FiltrarDatosVentas(Request $request){
        
        //return response()->json($request);
        
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoVenta = $request->input('TipoVenta');
        $EventoStock = $request->input('EventoStock');
        $searchText = $request->input('searchText');
        $UsuarioVenta = $request->input('UsuarioVenta');
        $ClienteVenta = $request->input('ClienteVenta');
        $MetodoPagoVenta = $request->input('MetodoPagoVenta');
        $AmbienteMesaVenta = $request->input('AmbienteMesaVenta');
        $MesaVenta = $request->input('MesaVenta');
        
        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioVenta':
                if($TipoVenta == 'TodoVenta'){
                    $ventas = Consumo::with(['cliente', 'user', 'cliente', 'camarero','ambientemesa'])
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();
                
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
                    
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
            
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
            
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }
                                    
                break;
                }elseif($TipoVenta == 'Mesa'){
                    $ventas = Consumo::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                                            return $query->where('TipoConsumo', $TipoVenta);
                                        })
                                        ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                                            return $query->where('ambiente_mesa_id', $MesaVenta);
                                        })
                                        ->get();
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
                    
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
            
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
            
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }

                    break;
                }elseif($TipoVenta == 'Mostrador'){
                    $ventas = Consumo::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->whereNotNull('ingrediente_id')
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoVenta', $EventoStock);
                                        })
                                        ->when($TipoVenta !== 'TodoStock', function ($query) use ($TipoVenta) {
                                            if ($TipoVenta === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoVenta === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoVenta', $TipoVenta);
                                            }
                                        })
                                        ->get();
                    break;
                }else{
                    $ventas = Consumo::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoVenta', $EventoStock);
                                        })
                                        ->when($TipoVenta !== 'TodoStock', function ($query) use ($TipoVenta) {
                                            if ($TipoVenta === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoVenta === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoVenta', $TipoVenta);
                                            }
                                        })
                                        ->get();
                    break;
                }
            case 'MensualVenta':
                $ventas = Consumo::with(['cliente', 'user', 'cliente', 'camarero','pagosconsumos','ambientemesa'])
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                                    return $query->where('TipoConsumo', $TipoVenta);
                                })
                                ->when($UsuarioVenta !== 'TodoUsuario', function ($query) use ($UsuarioVenta) {
                                    return $query->where('user_id', $UsuarioVenta);
                                })
                                ->when($ClienteVenta !== 'TodoCliente', function ($query) use ($ClienteVenta) {
                                    return $query->where('cliente_id', $ClienteVenta);
                                })
                                ->when($MetodoPagoVenta !== 'TodoMetodoPago', function ($query) use ($MetodoPagoVenta) {
                                    return $query->whereHas('pagosconsumos', function ($query) use ($MetodoPagoVenta) {
                                        $query->where('TipoPago', $MetodoPagoVenta);
                                    });
                                })
                                ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                                    return $query->where('ambiente_mesa_id', $MesaVenta);
                                })
                                ->get();
                $countventas = $ventas->count();
                $totalSum = round($ventas->sum('total'), 2);

                // Verificar que el número de ventas no sea cero antes de dividir
                if ($countventas > 0) {
                    $promedioventa = round($totalSum / $countventas, 2);
                } else {
                    $promedioventa = 0;
                }

                $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);

                // Verificar que el número de personas no sea cero antes de dividir
                if ($cantpersonas > 0) {
                    $promediopersonas = round($totalSum / $cantpersonas, 2);
                } else {
                    $promediopersonas = 0;
                }
                
                break;
            case 'AnualVenta':
                $ventas = Consumo::with(['cliente', 'user', 'camarero','ambientemesa'])
                                        ->whereYear('created_at', $anio)
                                        ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                                            return $query->where('TipoConsumo', $TipoVenta);
                                        })
                                        ->when($UsuarioVenta !== 'TodoUsuario', function ($query) use ($UsuarioVenta) {
                                            return $query->where('user_id', $UsuarioVenta);
                                        })
                                        ->when($ClienteVenta !== 'TodoCliente', function ($query) use ($ClienteVenta) {
                                            return $query->where('cliente_id', $ClienteVenta);
                                        })
                                        ->when($MetodoPagoVenta !== 'TodoMetodoPago', function ($query) use ($MetodoPagoVenta) {
                                            return $query->whereHas('pagosconsumos', function ($query) use ($MetodoPagoVenta) {
                                                $query->where('TipoPago', $MetodoPagoVenta);
                                            });
                                        })
                                        ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                                            return $query->where('ambiente_mesa_id', $MesaVenta);
                                        })
                                        ->get();
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
    
                    // Verificar que el número de ventas no sea cero antes de dividir
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
    
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
    
                    // Verificar que el número de personas no sea cero antes de dividir
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }

                break;
            case 'RangoVenta':
                $ventas = Consumo::with(['cliente', 'user', 'cliente', 'camarero','ambientemesa'])
                                        ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                        ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                                            return $query->where('TipoConsumo', $TipoVenta);
                                        })
                                        ->when($UsuarioVenta !== 'TodoUsuario', function ($query) use ($UsuarioVenta) {
                                            return $query->where('user_id', $UsuarioVenta);
                                        })
                                        ->when($ClienteVenta !== 'TodoCliente', function ($query) use ($ClienteVenta) {
                                            return $query->where('cliente_id', $ClienteVenta);
                                        })
                                        ->when($MetodoPagoVenta !== 'TodoMetodoPago', function ($query) use ($MetodoPagoVenta) {
                                            return $query->whereHas('pagosconsumos', function ($query) use ($MetodoPagoVenta) {
                                                $query->where('TipoPago', $MetodoPagoVenta);
                                            });
                                        })
                                        ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                                            return $query->where('ambiente_mesa_id', $MesaVenta);
                                        })
                                        ->get();
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
    
                    // Verificar que el número de ventas no sea cero antes de dividir
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
    
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
    
                    // Verificar que el número de personas no sea cero antes de dividir
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }    

                break;
            default:
                $ventas = Consumo::get();
                break;
        }

        return response()->json([
            'ventas' => $ventas,
            'totalSum' => $totalSum,
            'cantidadventas' => $countventas,
            'promedioventa' => $promedioventa,
            'cantpersonas' => $cantpersonas,
            'promediopersonas' => $promediopersonas,
        ]);

    }

    public function FiltrarDatosVentasPdf(Request $request){
        
        //return response()->json($request);
        
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoVenta = $request->input('TipoVenta');
        $EventoStock = $request->input('EventoStock');
        $searchText = $request->input('searchText');
        $UsuarioVenta = $request->input('UsuarioVenta');
        $ClienteVenta = $request->input('ClienteVenta');
        $MetodoPagoVenta = $request->input('MetodoPagoVenta');
        $AmbienteMesaVenta = $request->input('AmbienteMesaVenta');
        $MesaVenta = $request->input('MesaVenta');
        
        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioVenta':
                if($TipoVenta == 'TodoVenta'){
                    $ventas = Consumo::with(['cliente', 'user', 'cliente', 'camarero','ambientemesa'])
                                    ->whereDay('created_at', $dia)
                                    ->whereMonth('created_at', $mes)
                                    ->whereYear('created_at', $anio)
                                    ->get();
                
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
                    
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
            
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
            
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }

                     // Contabilizar productos vendidos
                    $productosVendidos = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $productoId = $detalle->producto_id;
                            $productoNombre = $detalle->producto->NombreProducto;
                            $cantidad = $detalle->cantidad;

                            if (isset($productosVendidos[$productoId])) {
                                $productosVendidos[$productoId]['cantidad'] += $cantidad;
                            } else {
                                $productosVendidos[$productoId] = [
                                    'NombreProducto' => $productoNombre,
                                    'cantidad' => $cantidad,
                                ];
                            }
                        }
                    }

                    // Ordenar los productos de mayor a menor cantidad
                    usort($productosVendidos, function ($a, $b) {
                        return $b['cantidad'] <=> $a['cantidad'];
                    });

                
                    // Convertir a colección si lo necesitas
                    $productosVendidos = collect($productosVendidos);

                    $categoriasVendidas = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $categoria = $detalle->producto->categoria->Nombre_categoria; // Ajusta según el nombre real de la relación o atributo
                            $cantidad = $detalle->cantidad;

                            if (isset($categoriasVendidas[$categoria])) {
                                $categoriasVendidas[$categoria] += $cantidad;
                            } else {
                                $categoriasVendidas[$categoria] = $cantidad;
                            }
                        }
                    }

                    // Ordenar las categorías de mayor a menor cantidad
                    arsort($categoriasVendidas);
                    
                    $TipoReporte = "Diario";

                break;
                }elseif($TipoVenta == 'Mesa'){
                    $ventas = Consumo::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                                            return $query->where('TipoConsumo', $TipoVenta);
                                        })
                                        ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                                            return $query->where('ambiente_mesa_id', $MesaVenta);
                                        })
                                        ->get();
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
                    
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
            
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
            
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }

                     // Contabilizar productos vendidos
                    $productosVendidos = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $productoId = $detalle->producto_id;
                            $productoNombre = $detalle->producto->NombreProducto;
                            $cantidad = $detalle->cantidad;

                            if (isset($productosVendidos[$productoId])) {
                                $productosVendidos[$productoId]['cantidad'] += $cantidad;
                            } else {
                                $productosVendidos[$productoId] = [
                                    'NombreProducto' => $productoNombre,
                                    'cantidad' => $cantidad,
                                ];
                            }
                        }
                    }

                    // Ordenar los productos de mayor a menor cantidad
                    usort($productosVendidos, function ($a, $b) {
                        return $b['cantidad'] <=> $a['cantidad'];
                    });

                
                    // Convertir a colección si lo necesitas
                    $productosVendidos = collect($productosVendidos);

                    $categoriasVendidas = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $categoria = $detalle->producto->categoria->Nombre_categoria; // Ajusta según el nombre real de la relación o atributo
                            $cantidad = $detalle->cantidad;

                            if (isset($categoriasVendidas[$categoria])) {
                                $categoriasVendidas[$categoria] += $cantidad;
                            } else {
                                $categoriasVendidas[$categoria] = $cantidad;
                            }
                        }
                    }

                    // Ordenar las categorías de mayor a menor cantidad
                    arsort($categoriasVendidas);
                    $TipoReporte = "Diario";

                    break;
                }elseif($TipoVenta == 'Mostrador'){
                    $ventas = Consumo::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->whereNotNull('ingrediente_id')
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoVenta', $EventoStock);
                                        })
                                        ->when($TipoVenta !== 'TodoStock', function ($query) use ($TipoVenta) {
                                            if ($TipoVenta === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoVenta === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoVenta', $TipoVenta);
                                            }
                                        })
                                        ->get();

                    // Contabilizar productos vendidos
                    $productosVendidos = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $productoId = $detalle->producto_id;
                            $productoNombre = $detalle->producto->NombreProducto;
                            $cantidad = $detalle->cantidad;

                            if (isset($productosVendidos[$productoId])) {
                                $productosVendidos[$productoId]['cantidad'] += $cantidad;
                            } else {
                                $productosVendidos[$productoId] = [
                                    'NombreProducto' => $productoNombre,
                                    'cantidad' => $cantidad,
                                ];
                            }
                        }
                    }

                    // Ordenar los productos de mayor a menor cantidad
                    usort($productosVendidos, function ($a, $b) {
                        return $b['cantidad'] <=> $a['cantidad'];
                    });

                
                    // Convertir a colección si lo necesitas
                    $productosVendidos = collect($productosVendidos);

                    $categoriasVendidas = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $categoria = $detalle->producto->categoria->Nombre_categoria; // Ajusta según el nombre real de la relación o atributo
                            $cantidad = $detalle->cantidad;

                            if (isset($categoriasVendidas[$categoria])) {
                                $categoriasVendidas[$categoria] += $cantidad;
                            } else {
                                $categoriasVendidas[$categoria] = $cantidad;
                            }
                        }
                    }

                    // Ordenar las categorías de mayor a menor cantidad
                    arsort($categoriasVendidas);
                    
                    $TipoReporte = "Diario";

                    break;
                }else{
                    $ventas = Consumo::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoVenta', $EventoStock);
                                        })
                                        ->when($TipoVenta !== 'TodoStock', function ($query) use ($TipoVenta) {
                                            if ($TipoVenta === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoVenta === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoVenta', $TipoVenta);
                                            }
                                        })
                                        ->get();

                    // Contabilizar productos vendidos
                    $productosVendidos = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $productoId = $detalle->producto_id;
                            $productoNombre = $detalle->producto->NombreProducto;
                            $cantidad = $detalle->cantidad;

                            if (isset($productosVendidos[$productoId])) {
                                $productosVendidos[$productoId]['cantidad'] += $cantidad;
                            } else {
                                $productosVendidos[$productoId] = [
                                    'NombreProducto' => $productoNombre,
                                    'cantidad' => $cantidad,
                                ];
                            }
                        }
                    }

                    // Ordenar los productos de mayor a menor cantidad
                    usort($productosVendidos, function ($a, $b) {
                        return $b['cantidad'] <=> $a['cantidad'];
                    });

                
                    // Convertir a colección si lo necesitas
                    $productosVendidos = collect($productosVendidos);

                    $categoriasVendidas = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $categoria = $detalle->producto->categoria->Nombre_categoria; // Ajusta según el nombre real de la relación o atributo
                            $cantidad = $detalle->cantidad;

                            if (isset($categoriasVendidas[$categoria])) {
                                $categoriasVendidas[$categoria] += $cantidad;
                            } else {
                                $categoriasVendidas[$categoria] = $cantidad;
                            }
                        }
                    }

                    // Ordenar las categorías de mayor a menor cantidad
                    arsort($categoriasVendidas);
                    
                    $TipoReporte = "Diario";

                    break;
                }
            case 'MensualVenta':
                $ventas = Consumo::with([
                    'cliente',
                    'camarero',
                    'ambientemesa',
                    'pagosconsumos',
                    'consumoservicio',
                    'detalleconsumos.producto',
                    'detalleconsumos.producto.modificadore',
                    'detalleconsumos.producto.modificadore.detallemodificador',
                    'detalleconsumos.producto.modificadore.detallemodificador.producto',
                    'detalleconsumos.modificadordetalleconsumo',
                    'descuentoconsumos',
                    'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                    'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'
                ])
                ->whereMonth('created_at', $mes)
                ->whereYear('created_at', $anio)
                ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                    return $query->where('TipoConsumo', $TipoVenta);
                })
                ->when($UsuarioVenta !== 'TodoUsuario', function ($query) use ($UsuarioVenta) {
                    return $query->where('user_id', $UsuarioVenta);
                })
                ->when($ClienteVenta !== 'TodoCliente', function ($query) use ($ClienteVenta) {
                    return $query->where('cliente_id', $ClienteVenta);
                })
                ->when($MetodoPagoVenta !== 'TodoMetodoPago', function ($query) use ($MetodoPagoVenta) {
                    return $query->whereHas('pagosconsumos', function ($query) use ($MetodoPagoVenta) {
                        $query->where('TipoPago', $MetodoPagoVenta);
                    });
                })
                ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                    return $query->where('ambiente_mesa_id', $MesaVenta);
                })
                ->get();
            
                $countventas = $ventas->count();
                $totalSum = round($ventas->sum('total'), 2);
            
                // Verificar que el número de ventas no sea cero antes de dividir
                if ($countventas > 0) {
                    $promedioventa = round($totalSum / $countventas, 2);
                } else {
                    $promedioventa = 0;
                }
            
                $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
            
                // Verificar que el número de personas no sea cero antes de dividir
                if ($cantpersonas > 0) {
                    $promediopersonas = round($totalSum / $cantpersonas, 2);
                } else {
                    $promediopersonas = 0;
                }
            
                // Contabilizar productos vendidos
                $productosVendidos = [];
                foreach ($ventas as $venta) {
                    foreach ($venta->detalleconsumos as $detalle) {
                        $productoId = $detalle->producto_id;
                        $productoNombre = $detalle->producto->NombreProducto;
                        $cantidad = $detalle->cantidad;
            
                        if (isset($productosVendidos[$productoId])) {
                            $productosVendidos[$productoId]['cantidad'] += $cantidad;
                        } else {
                            $productosVendidos[$productoId] = [
                                'NombreProducto' => $productoNombre,
                                'cantidad' => $cantidad,
                            ];
                        }
                    }
                }
            
                // Ordenar los productos de mayor a menor cantidad
                usort($productosVendidos, function ($a, $b) {
                    return $b['cantidad'] <=> $a['cantidad'];
                });

                // Convertir a colección si lo necesitas
                $productosVendidos = collect($productosVendidos);

                $categoriasVendidas = [];
                foreach ($ventas as $venta) {
                    foreach ($venta->detalleconsumos as $detalle) {
                        $categoria = $detalle->producto->categoria->Nombre_categoria; // Ajusta según el nombre real de la relación o atributo
                        $cantidad = $detalle->cantidad;

                        if (isset($categoriasVendidas[$categoria])) {
                            $categoriasVendidas[$categoria] += $cantidad;
                        } else {
                            $categoriasVendidas[$categoria] = $cantidad;
                        }
                    }
                }

                // Ordenar las categorías de mayor a menor cantidad
                arsort($categoriasVendidas);

                $TipoReporte = "Mensual";
                break;
                
            case 'AnualVenta':
                $ventas = Consumo::with(['cliente', 'user', 'camarero','ambientemesa'])
                                        ->whereYear('created_at', $anio)
                                        ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                                            return $query->where('TipoConsumo', $TipoVenta);
                                        })
                                        ->when($UsuarioVenta !== 'TodoUsuario', function ($query) use ($UsuarioVenta) {
                                            return $query->where('user_id', $UsuarioVenta);
                                        })
                                        ->when($ClienteVenta !== 'TodoCliente', function ($query) use ($ClienteVenta) {
                                            return $query->where('cliente_id', $ClienteVenta);
                                        })
                                        ->when($MetodoPagoVenta !== 'TodoMetodoPago', function ($query) use ($MetodoPagoVenta) {
                                            return $query->whereHas('pagosconsumos', function ($query) use ($MetodoPagoVenta) {
                                                $query->where('TipoPago', $MetodoPagoVenta);
                                            });
                                        })
                                        ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                                            return $query->where('ambiente_mesa_id', $MesaVenta);
                                        })
                                        ->get();
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
    
                    // Verificar que el número de ventas no sea cero antes de dividir
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
    
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
    
                    // Verificar que el número de personas no sea cero antes de dividir
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }

                     // Contabilizar productos vendidos
                    $productosVendidos = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $productoId = $detalle->producto_id;
                            $productoNombre = $detalle->producto->NombreProducto;
                            $cantidad = $detalle->cantidad;

                            if (isset($productosVendidos[$productoId])) {
                                $productosVendidos[$productoId]['cantidad'] += $cantidad;
                            } else {
                                $productosVendidos[$productoId] = [
                                    'NombreProducto' => $productoNombre,
                                    'cantidad' => $cantidad,
                                ];
                            }
                        }
                    }

                    // Ordenar los productos de mayor a menor cantidad
                    usort($productosVendidos, function ($a, $b) {
                        return $b['cantidad'] <=> $a['cantidad'];
                    });

                    // Convertir a colección si lo necesitas
                    $productosVendidos = collect($productosVendidos);

                    $categoriasVendidas = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $categoria = $detalle->producto->categoria->Nombre_categoria; // Ajusta según el nombre real de la relación o atributo
                            $cantidad = $detalle->cantidad;

                            if (isset($categoriasVendidas[$categoria])) {
                                $categoriasVendidas[$categoria] += $cantidad;
                            } else {
                                $categoriasVendidas[$categoria] = $cantidad;
                            }
                        }
                    }

                    // Ordenar las categorías de mayor a menor cantidad
                    arsort($categoriasVendidas);
                    
                    $TipoReporte = "Anual";

                break;
            case 'RangoVenta':
                $ventas = Consumo::with(['cliente', 'user', 'cliente', 'camarero','ambientemesa'])
                                        ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                        ->when($TipoVenta !== 'TodoVenta', function ($query) use ($TipoVenta) {
                                            return $query->where('TipoConsumo', $TipoVenta);
                                        })
                                        ->when($UsuarioVenta !== 'TodoUsuario', function ($query) use ($UsuarioVenta) {
                                            return $query->where('user_id', $UsuarioVenta);
                                        })
                                        ->when($ClienteVenta !== 'TodoCliente', function ($query) use ($ClienteVenta) {
                                            return $query->where('cliente_id', $ClienteVenta);
                                        })
                                        ->when($MetodoPagoVenta !== 'TodoMetodoPago', function ($query) use ($MetodoPagoVenta) {
                                            return $query->whereHas('pagosconsumos', function ($query) use ($MetodoPagoVenta) {
                                                $query->where('TipoPago', $MetodoPagoVenta);
                                            });
                                        })
                                        ->when($MesaVenta !== 'TodoMesa', function ($query) use ($MesaVenta) {
                                            return $query->where('ambiente_mesa_id', $MesaVenta);
                                        })
                                        ->get();
                    $countventas = $ventas->count();
                    $totalSum = round($ventas->sum('total'), 2);
    
                    // Verificar que el número de ventas no sea cero antes de dividir
                    if ($countventas > 0) {
                        $promedioventa = round($totalSum / $countventas, 2);
                    } else {
                        $promedioventa = 0;
                    }
    
                    $cantpersonas = round($ventas->sum('CantidadPersonas'), 2);
    
                    // Verificar que el número de personas no sea cero antes de dividir
                    if ($cantpersonas > 0) {
                        $promediopersonas = round($totalSum / $cantpersonas, 2);
                    } else {
                        $promediopersonas = 0;
                    }    

                     // Contabilizar productos vendidos
                    $productosVendidos = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $productoId = $detalle->producto_id;
                            $productoNombre = $detalle->producto->NombreProducto;
                            $cantidad = $detalle->cantidad;

                            if (isset($productosVendidos[$productoId])) {
                                $productosVendidos[$productoId]['cantidad'] += $cantidad;
                            } else {
                                $productosVendidos[$productoId] = [
                                    'NombreProducto' => $productoNombre,
                                    'cantidad' => $cantidad,
                                ];
                            }
                        }
                    }

                    // Ordenar los productos de mayor a menor cantidad
                    usort($productosVendidos, function ($a, $b) {
                        return $b['cantidad'] <=> $a['cantidad'];
                    });

                
                    // Convertir a colección si lo necesitas
                    $productosVendidos = collect($productosVendidos);

                    $categoriasVendidas = [];
                    foreach ($ventas as $venta) {
                        foreach ($venta->detalleconsumos as $detalle) {
                            $categoria = $detalle->producto->categoria->Nombre_categoria; // Ajusta según el nombre real de la relación o atributo
                            $cantidad = $detalle->cantidad;

                            if (isset($categoriasVendidas[$categoria])) {
                                $categoriasVendidas[$categoria] += $cantidad;
                            } else {
                                $categoriasVendidas[$categoria] = $cantidad;
                            }
                        }
                    }

                    // Ordenar las categorías de mayor a menor cantidad
                    arsort($categoriasVendidas);
                    
                    $TipoReporte = "Rango";
                    
                break;
            default:
                $ventas = Consumo::get();
                break;
        }

        if($ClienteVenta != "TodoCliente"){
            $cliente = Cliente::where('id', $ClienteVenta)->first();
        }else{
            $cliente = "TodoCliente";
        }
        if($MetodoPagoVenta != "TodoMetodoPago"){
            $metododepago = $MetodoPagoVenta;
        }else{
            $metododepago = "TodoMetodoPago";
        }
        if($UsuarioVenta != "TodoUsuario"){
            $usuario = User::where('id', $UsuarioVenta)->first();
        }else{
            $usuario = "TodoUsuario";
        }
        if($TipoVenta != "TodoVenta"){
            $tipodeventa = $TipoVenta;
        }else{
            $tipodeventa = "TodoVenta";
        }

        $pdf = PDF::loadView('admin.venta.FiltroDatosVentaPdf', compact('ventas', 
                                                                        'totalSum', 
                                                                        'countventas', 
                                                                        'promedioventa', 
                                                                        'cantpersonas', 
                                                                        'promediopersonas',
                                                                        'productosVendidos',
                                                                        'TipoReporte',
                                                                        'tipoFiltro',
                                                                        'dia',
                                                                        'mes',
                                                                        'anio',
                                                                        'fechaInicio',
                                                                        'fechaFin',
                                                                        'tipodeventa',
                                                                        'EventoStock',
                                                                        'searchText',
                                                                        'usuario',
                                                                        'MetodoPagoVenta',
                                                                        'AmbienteMesaVenta',
                                                                        'MesaVenta',
                                                                        'cliente',
                                                                        'metododepago',
                                                                        'categoriasVendidas'
                                                                        ))
            ->setPaper([0,0,612.00,792.00], 'portrait');

        return $pdf->stream('Ventas.pdf');

    }

    public function GetUser(){
        $user = User::get();
        return response()->json($user);
    }

    public function GetVentaCantidad() {
        $today = Carbon::now()->toDateString();
        $movimientos = Consumo::whereDate('created_at', $today)->count();
        $day = Carbon::now()->toDateString();
        $daymore = Carbon::now()->addDay()->toDateString();

        $data = [
            'day' => $day,
            'daymore' => $daymore,
            'count' => $movimientos
        ];

        return response()->json($data);
    }
    
}
