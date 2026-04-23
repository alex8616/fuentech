<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use App\Models\Producto;
use App\Models\DetalleConsumo;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function ReporteMesasGet(){
        $ventas = Consumo::get();
        $agrupadas = collect($ventas)->groupBy('ambiente_mesa_id')->map(function ($group) {
            return [
                'mesa' => $group->first()->ambiente_mesa_id,
                'ventas' => $group->map(function ($venta) {
                    return [
                        'fecha_venta' => $venta->fecha_venta,
                        'fecha_cierre' => $venta->FechaCierre,
                        'label' => "Consumo # {$venta->id}",
                        'total' => $venta->total,
                    ];
                })
            ];
        })->values();
    
        return response()->json($agrupadas);
    }

    public function ReporteFiltrarDatos(Request $request){
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
    
        $tipodeseleccion = "";
    
        switch ($tipoFiltro) {
            case 'DiarioMesas':
                $ventas = Consumo::whereDay('created_at', $dia)
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->where('TipoConsumo','Mesa')
                                ->get();
                $mesas = collect($ventas)->groupBy('ambiente_mesa_id')->map(function ($group) {
                    return [
                        'mesa' => $group->first()->ambiente_mesa_id,
                        'ventas' => $group->map(function ($venta) {
                            return [
                                'fecha_venta' => $venta->fecha_venta,
                                'fecha_cierre' => $venta->FechaCierre,
                                'label' => "Consumo # {$venta->id}",
                                'total' => $venta->total,
                            ];
                        })
                    ];
                })->values()
                ->sortBy('mesa')
                ->values();
                $tipodeseleccion = "Diario";
                $countmesas = $ventas->count();
                $cantidadmesas = $mesas->count();
                $total = $ventas->sum('total');
            break;
            case 'MensualMesas':
                $ventas = Consumo::whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->where('TipoConsumo','Mesa')
                                ->get();
                $mesas = collect($ventas)->groupBy('ambiente_mesa_id')->map(function ($group) {
                    return [
                        'mesa' => $group->first()->ambiente_mesa_id,
                        'ventas' => $group->map(function ($venta) {
                            return [
                                'fecha_venta' => $venta->fecha_venta,
                                'fecha_cierre' => $venta->FechaCierre,
                                'label' => "Consumo # {$venta->id}",
                                'total' => $venta->total,
                            ];
                        })
                    ];
                })->values()
                ->sortBy('mesa')
                ->values();
                $tipodeseleccion = "Mensual";
                $countmesas = $ventas->count();
                $cantidadmesas = $mesas->count();
                $total = $ventas->sum('total');
            break;
            case 'AnualMesas':
                $ventas = Consumo::whereYear('created_at', $anio)->where('TipoConsumo','Mesa')->get();
                $mesas = collect($ventas)->groupBy('ambiente_mesa_id')->map(function ($group) {
                    return [
                        'mesa' => $group->first()->ambiente_mesa_id,
                        'ventas' => $group->map(function ($venta) {
                            return [
                                'fecha_venta' => $venta->fecha_venta,
                                'fecha_cierre' => $venta->FechaCierre,
                                'label' => "Consumo # {$venta->id}",
                                'total' => $venta->total,
                            ];
                        })
                    ];
                })
                ->values()
                ->sortBy('mesa')
                ->values();
                $tipodeseleccion = "Anual";
                $countmesas = $ventas->count();
                $cantidadmesas = $mesas->count();
                $total = $ventas->sum('total');
            break;
        }
    
        return response()->json([
            'mesas' => $mesas,
            'tipodeseleccion' => $tipodeseleccion,
            'anio' => $anio,
            'mes' => $mes,
            'dia' => $dia,
            'cantidadregistro' => $countmesas,
            'cantidadmesas' => $cantidadmesas,
            'totalsum' => $total
        ]);
    }
    
    public function ReporteMesaDownloadPdf(Request $request){
        $datos = $request->input('datos');

        $html = view('admin.reporte.reporte-mesa-pdf', compact('datos'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $output = $dompdf->output();
        $fileName = 'reporte-mesas.pdf';
        $filePath = public_path($fileName);

        file_put_contents($filePath, $output);

        return response()->json(['url' => url($fileName)]);
    }

    public function ReporteFiltrarDatosProductos(Request $request){
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $RankingProductos = $request->input('RankingProductos');
        $RankingVentas = $request->input('RankingVentas');
        $CategoriaProductos = $request->input('CategoriaProductos');

        $tipodeseleccion = "";
                
        switch ($tipoFiltro) {
            case 'DiarioProductos':
                $ventas = DetalleConsumo::select(
                                'productos.id',
                                'productos.NombreProducto',
                                'productos.CodigoProducto',
                                'productos.PrecioProducto',
                                DB::raw('SUM(detalle_consumos.cantidad) as cantidad_vendida')
                            )
                            ->join('productos', 'detalle_consumos.producto_id', '=', 'productos.id')
                            ->when($CategoriaProductos && $CategoriaProductos !== 'Todo', function ($query) use ($CategoriaProductos) {
                                return $query->where('productos.categoria_id', $CategoriaProductos);
                            })
                            ->whereDay('detalle_consumos.created_at', $dia)
                            ->whereMonth('detalle_consumos.created_at', $mes)
                            ->whereYear('detalle_consumos.created_at', $anio)
                            ->groupBy('productos.id', 'productos.NombreProducto', 'productos.CodigoProducto', 'productos.PrecioProducto')
                            ->when($RankingVentas === 'MasVentas', function ($query) {
                                return $query->orderBy('cantidad_vendida', 'desc');
                            })
                            ->when($RankingVentas === 'MenosVentas', function ($query) {
                                return $query->orderBy('cantidad_vendida', 'asc');
                            })
                            ->take($RankingProductos)
                            ->get()
                            ->map(function ($item) {
                                $item->color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                                return $item;
                            });
                $tipodeseleccion = "Diario";
                
            break;
            case 'MensualProductos':
                $ventas = DetalleConsumo::select(
                            'productos.id',
                            'productos.NombreProducto',
                            'productos.CodigoProducto',
                            'productos.PrecioProducto',
                            DB::raw('SUM(detalle_consumos.cantidad) as cantidad_vendida')
                        )
                        ->join('productos', 'detalle_consumos.producto_id', '=', 'productos.id')
                        ->when($CategoriaProductos && $CategoriaProductos !== 'Todo', function ($query) use ($CategoriaProductos) {
                            return $query->where('productos.categoria_id', $CategoriaProductos);
                        })
                        ->whereMonth('detalle_consumos.created_at', $mes)
                        ->whereYear('detalle_consumos.created_at', $anio)
                        ->groupBy('productos.id', 'productos.NombreProducto', 'productos.CodigoProducto', 'productos.PrecioProducto')
                        ->when($RankingVentas === 'MasVentas', function ($query) {
                            return $query->orderBy('cantidad_vendida', 'desc');
                        })
                        ->when($RankingVentas === 'MenosVentas', function ($query) {
                            return $query->orderBy('cantidad_vendida', 'asc');
                        })
                        ->take($RankingProductos)
                        ->get()
                        ->map(function ($item) {
                            $item->color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                            return $item;
                        });
            $tipodeseleccion = "Mensual";

            break;
            case 'AnualProductos':
                $ventas = DetalleConsumo::select(
                            'productos.id',
                            'productos.NombreProducto',
                            'productos.CodigoProducto',
                            'productos.PrecioProducto',
                            DB::raw('SUM(detalle_consumos.cantidad) as cantidad_vendida')
                        )
                        ->join('productos', 'detalle_consumos.producto_id', '=', 'productos.id')
                        ->when($CategoriaProductos && $CategoriaProductos !== 'Todo', function ($query) use ($CategoriaProductos) {
                            return $query->where('productos.categoria_id', $CategoriaProductos);
                        })
                        ->whereYear('detalle_consumos.created_at', $anio)
                        ->groupBy('productos.id', 'productos.NombreProducto', 'productos.CodigoProducto', 'productos.PrecioProducto')
                        ->when($RankingVentas === 'MasVentas', function ($query) {
                            return $query->orderBy('cantidad_vendida', 'desc');
                        })
                        ->when($RankingVentas === 'MenosVentas', function ($query) {
                            return $query->orderBy('cantidad_vendida', 'asc');
                        })
                        ->take($RankingProductos)
                        ->get()
                        ->map(function ($item) {
                            $item->color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                            return $item;
                        });
            $tipodeseleccion = "Anual";

            break;
        }
    
        return response()->json([
            'ventas' => $ventas,
            'tipodeseleccion' => $tipodeseleccion,
        ]);
    }
}   
