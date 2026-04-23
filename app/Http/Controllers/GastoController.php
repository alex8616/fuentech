<?php

namespace App\Http\Controllers;
use App\Models\CategoriaGasto;
use App\Models\Gasto;
use App\Models\DetalleGasto;
use App\Models\Producto;
use App\Models\ArqueoCaja;
use App\Models\StockDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function RegistrarCategoriaGasto(Request $request){
        $categoriagasto = CategoriaGasto::create([
            'Nombre_categoria' => $request->NombreCategoria,
            'Estado' => $request->CheckActivo,
        ]);

        return response()->json($categoriagasto);
    }

    public function GetCategoriaGasto(){
        $categoriagastos = CategoriaGasto::get();
        return response()->json($categoriagastos);
    }

    public function DeleteCategoriaGasto(Request $request){
        return response()->json($request);

        $categoriagastos = CategoriaGasto::where('id',$request->id);
        return response()->json($categoriagastos);
    }

    public function GetCategoriaGastoSeleccionado($id){
        $categoriagasto = CategoriaGasto::where("id",$id)->get();
        return response()->json($categoriagasto);
    }

    public function RegistrarGasto(Request $request){
        $user = Auth::user(); 
        if ($user) {
            $gasto = Gasto::create([
                'FechaRegistro' => $request->Fecha,
                'Importe' => $request->Importe,
                'MedioDePago' => $request->MedioDePagoGasto,
                'TipoConprobante' => $request->TipoComprobante,
                'NumeroComprobante' => $request->NroComprobante,
                'UsarArqueo' => $request->CheckArqueo,
                'Comentario' => $request->Comentario,
                'proveedor_id' => $request->ProveedorGasto,
                'categoria_gasto_id' => $request->CategoriaGasto,
                'user_id' => $user->id,
            ]);

            if($request->CheckArqueo == "true"){
                if($request->MedioDePagoGasto == "Efectivo"){
                    $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                    $ActivoArqueo->Segun_SistemaEgresoEfectivo += $request->Importe;
                    $ActivoArqueo->Segun_SistemaEgresoEfectivo = number_format($ActivoArqueo->Segun_SistemaEgresoEfectivo, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotalEgreso += $request->Importe;
                    $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                    $ActivoArqueo->TotalGastoEgresoEfectivo += $request->Importe;
                    $ActivoArqueo->TotalGastoEgresoEfectivo = number_format($ActivoArqueo->TotalGastoEgresoEfectivo, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotal += $request->Importe;
                    $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                    
                    $ActivoArqueo->save();
                }
    
                if($request->MedioDePagoGasto == "Tarjeta"){
                    $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                    $ActivoArqueo->Segun_SistemaEgresoTarjeta += $request->Importe;
                    $ActivoArqueo->Segun_SistemaEgresoTarjeta = number_format($ActivoArqueo->Segun_SistemaEgresoTarjeta, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotalEgreso += $request->Importe;
                    $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                    $ActivoArqueo->TotalGastoEgresoTarjeta += $request->Importe;
                    $ActivoArqueo->TotalGastoEgresoTarjeta = number_format($ActivoArqueo->TotalGastoEgresoTarjeta, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotal += $request->Importe;
                    $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                    
                    $ActivoArqueo->save();
                }
    
                if($request->MedioDePagoGasto == "Deposito/QR"){
                    $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();
                    $ActivoArqueo->TotalMovimientoCajaEgresoDepositoQR += $request->Importe;
                    $ActivoArqueo->TotalMovimientoCajaEgresoDepositoQR = number_format($ActivoArqueo->TotalMovimientoCajaEgresoDepositoQR, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotalEgreso += $request->Importe;
                    $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                    $ActivoArqueo->TotalGastoEgresoDepositoQR += $request->Importe;
                    $ActivoArqueo->TotalGastoEgresoDepositoQR = number_format($ActivoArqueo->TotalGastoEgresoDepositoQR, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotal += $request->Importe;
                    $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                    
                    $ActivoArqueo->save();
                }
            }
            return response()->json($gasto);
        } else {
            return response()->json("user No INICIADO SESSION");
        }
    }

    public function FiltrarDatosGasto(Request $request){
        //return response()->json($request);
        $ingreso = 0;
        $salida = 0; 
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoCategoria = $request->input('TipoCategoria');
        $TipoComprobante = $request->input('TipoComprobante');
        $TipoDePago = $request->input('TipoDePago');
        $TipoProveedor = $request->input('TipoProveedor');

        $ingresoSum = 0;
        $salidaSum = 0;

        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioGasto':
                $gasto = Gasto::with(['user','categoriagasto','proveedor'])
                                ->whereDay('created_at', $dia)
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->when($TipoCategoria !== 'TodoCategoria', function ($query) use ($TipoCategoria) {
                                    return $query->where('categoria_gasto_id', $TipoCategoria);
                                })
                                ->when($TipoComprobante !== 'TodoComprobante', function ($query) use ($TipoComprobante) {
                                    return $query->where('TipoConprobante', $TipoComprobante);
                                })
                                ->when($TipoDePago !== 'TodoMetodoPago', function ($query) use ($TipoDePago) {
                                    return $query->where('MedioDePago', $TipoDePago);
                                })
                                ->when($TipoProveedor !== 'TodoProveedor', function ($query) use ($TipoProveedor) {
                                    return $query->where('proveedor_id', $TipoProveedor);
                                })
                                ->get();
            
                $countgastos = $gasto->count();
                $suma = $gasto->sum('Importe');
                $totalSum = round($suma, 2);
            break;
            case 'MensualGasto':
                $gasto = Gasto::with(['user','categoriagasto','proveedor'])
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->when($TipoCategoria !== 'TodoCategoria', function ($query) use ($TipoCategoria) {
                                    return $query->where('categoria_gasto_id', $TipoCategoria);
                                })
                                ->when($TipoComprobante !== 'TodoComprobante', function ($query) use ($TipoComprobante) {
                                    return $query->where('TipoConprobante', $TipoComprobante);
                                })
                                ->when($TipoDePago !== 'TodoMetodoPago', function ($query) use ($TipoDePago) {
                                    return $query->where('MedioDePago', $TipoDePago);
                                })
                                ->when($TipoProveedor !== 'TodoProveedor', function ($query) use ($TipoProveedor) {
                                    return $query->where('proveedor_id', $TipoProveedor);
                                })
                                ->get();
            
                $countgastos = $gasto->count();
                $suma = $gasto->sum('Importe');
                $totalSum = round($suma, 2);
            break;
            case 'AnualGasto':
                $gasto = Gasto::with(['user','categoriagasto','proveedor'])
                                ->whereYear('created_at', $anio)
                                ->when($TipoCategoria !== 'TodoCategoria', function ($query) use ($TipoCategoria) {
                                    return $query->where('categoria_gasto_id', $TipoCategoria);
                                })
                                ->when($TipoComprobante !== 'TodoComprobante', function ($query) use ($TipoComprobante) {
                                    return $query->where('TipoConprobante', $TipoComprobante);
                                })
                                ->when($TipoDePago !== 'TodoMetodoPago', function ($query) use ($TipoDePago) {
                                    return $query->where('MedioDePago', $TipoDePago);
                                })
                                ->when($TipoProveedor !== 'TodoProveedor', function ($query) use ($TipoProveedor) {
                                    return $query->where('proveedor_id', $TipoProveedor);
                                })
                                ->get();
            
                $countgastos = $gasto->count();
                $suma = $gasto->sum('Importe');
                $totalSum = round($suma, 2);
            break;
            case 'RangoGasto':
                $gasto = Gasto::with(['user','categoriagasto','proveedor'])
                                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                ->when($TipoCategoria !== 'TodoCategoria', function ($query) use ($TipoCategoria) {
                                    return $query->where('categoria_gasto_id', $TipoCategoria);
                                })
                                ->when($TipoComprobante !== 'TodoComprobante', function ($query) use ($TipoComprobante) {
                                    return $query->where('TipoConprobante', $TipoComprobante);
                                })
                                ->when($TipoDePago !== 'TodoMetodoPago', function ($query) use ($TipoDePago) {
                                    return $query->where('MedioDePago', $TipoDePago);
                                })
                                ->when($TipoProveedor !== 'TodoProveedor', function ($query) use ($TipoProveedor) {
                                    return $query->where('proveedor_id', $TipoProveedor);
                                })
                                ->get();
            
                $countgastos = $gasto->count();
                $suma = $gasto->sum('Importe');
                $totalSum = round($suma, 2);
                
            break;
        }

        return response()->json([
            'gastos' => $gasto,
            'totalSum' => $totalSum,
            'cantidadregistros' => $countgastos,
        ]);
    }

    public function GetGastoSeleccionado($id){
        $gasto = Gasto::with(['user','categoriagasto','proveedor','detallegasto','detallegasto.productos'])->where("id",$id)->get();
        return response()->json($gasto);
    }

    public function RegistrarDetalleGasto(Request $request){
        //return response()->json($request);

        $detalles = $request->input('detalles');
        $id = 0;
        foreach ($detalles as $detalle) {
            $id = $detalle['idgasto'];
            $gasto = DetalleGasto::create([
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['costo'],
                'total' => $detalle['cantidad']*$detalle['costo'],
                'stock' => $detalle['stockIncrement'],
                'gasto_id' => $detalle['idgasto'],
                'producto_id' => $detalle['id'],
            ]);

            $producto = Producto::find($detalle['id']);
            if ($producto) {
                if ($detalle['stockIncrement']) {
                    $valoractual = $producto->CantidadStock+$detalle['cantidad'];

                    $stockdate = StockDate::create([
                        'Cantidad' => $detalle['cantidad'],
                        'TipoStock' => "Ingreso",
                        'StockAnterior' => $producto->CantidadStock,
                        'StockActual' => $valoractual,
                        'Diferencia' => ($valoractual - $producto->CantidadStock)*(1),
                        'NombreProducto' =>  $producto->NombreProducto,
                        'DetalleStock' => "Detalle de Gasto Creado - Stock Anterior ".$producto->CantidadStock." y estock actualizado ".$request->input("cantidad"),
                        'FechaStock' => now(),
                        'producto_id' => $producto->id,
                    ]);

                    $producto->CantidadStock += $detalle['cantidad'];
                    $producto->save();
                }
            }
        }

        $gasto = Gasto::with(['user','categoriagasto','proveedor','detallegasto','detallegasto.productos'])->where("id",$id)->get();

        return response()->json($gasto);
    }

    public function DeleteDetalleGasto(Request $request){
        $id = $request->detalleId;
        $detallegasto = DetalleGasto::where("id",$id)->first();
        $detallegasto->eliminado = "true";
        $detallegasto->save();        

        $gasto = Gasto::with(['user','categoriagasto','proveedor','detallegasto','detallegasto.productos'])->where("id",$detallegasto->gasto_id)->get();
        return response()->json($gasto);
    }
    
}
