<?php

namespace App\Http\Controllers;

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
use App\Models\DetalleStockDate;
use App\Models\Caja;
use App\Models\DetalleCaja;
use App\Models\ServicioConsumo;
use App\Models\ReservaSalones;
use App\Models\HospedajeHabitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Traits\CambiarEstadoTurnosTrait;

class ConsumoController extends Controller
{
    use CambiarEstadoTurnosTrait;

    public function RegistrarConsumo(Request $request){
        $registro = Consumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user(); 
        if ($user) {
            $turnoscambiadoestado = $this->CambiarEstadoTurnos();
            $turnoActivo = $turnoscambiadoestado->firstWhere('Estado', 'true');

            $consumo = Consumo::create([
                'CantidadPersonas' => $request->CantidadPersonas,
                'empresa_id' => $user->empresa_id,
                'user_id' => $user->id,
                'cliente_id' => $request->cliente_id,
                'camarero_id' => $request->camarero_id,
                'ambiente_mesa_id' => $request->ambiente_mesa_id,
                'fecha_venta' => now(),
                'total' => 0,
                'subTotal' => 0,
                'Comentario' => $request->Comentario,
                'ocupado' => 'true',
                'turno_id' => $turnoActivo->id,
            ]);
            $mesa = AmbienteMesa::where('id', $request->ambiente_mesa_id)->first();
            $mesa->estado = 'ocupado';
            $mesa->save();
            return response()->json($consumo);
        } else {
            return response()->json("user No INICIADO SESSION");
        }        
        
    }

    public function GetMesaOcupado($mesa){
        $consumo = Consumo::with(['cliente',
                                    'camarero',
                                    'detalleconsumos.producto',
                                    'detalleconsumos.producto.modificadore',
                                    'detalleconsumos.producto.modificadore.detallemodificador',
                                    'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                    'detalleconsumos.modificadordetalleconsumo',
                                    'descuentoconsumos',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'
                                    ])->where('ambiente_mesa_id',$mesa)->where('ocupado','true')->where('TipoConsumo','Mesa')->get();
        return response()->json($consumo);
    }

    public function GetMesaConsumo($id){
        $consumo = Consumo::with(['cliente',
                                'camarero',
                                'detalleconsumos.producto',
                                'detalleconsumos.producto.modificadore',
                                'detalleconsumos.producto.modificadore.detallemodificador',
                                'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                'detalleconsumos.modificadordetalleconsumo',
                                'descuentoconsumos',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                                'pagosconsumos',
                                ])
        ->where('id',$id)->where('TipoConsumo','Mesa')->get();
        return response()->json($consumo);
    }

    public function GetMesaConsumoNoDelete($id){
        $consumo = Consumo::with(['cliente', 'camarero', 'detalleconsumos.producto', 'descuentoconsumos'])
                        ->where('id', $id)
                        ->where('ocupado', true)
                        ->where('TipoConsumo', 'Mesa')
                        ->get();
    
        return response()->json($consumo);
    }


    public function RegistrarDetalleConsumo(Request $request){
        try {
            foreach ($request->all() as $producto) {
                $totalmodificador = 0;
    
                $consumoId = $producto['Idconsumo'];
                $productoId = $producto['Idproducto'];
                $cantidad = $producto['cantidad'];
                $comentario = $producto['comentario'];
                $precio = $producto['precio'];
                $modificadores = $producto['Modificadores'];                                         

                $ExiteProducto = Producto::where('id', $productoId)->first();

                if ($ExiteProducto->ControlStock == "true") {
                    $stock = StockDate::where('producto_id', $ExiteProducto->id)->first();
                    $consumo = Consumo::with(['cliente','ambientemesa'])->where('id',$consumoId)->first();
                    
                    $servicioconsumo = ServicioConsumo::where('id', $consumo->servicio_consumo_id)->first();

                    if($stock->Cantidad > 0 && $stock->Cantidad >= $cantidad){                           
                        $detalleConsumo = DetalleConsumo::create([
                            'producto_id' => $productoId,
                            'consumo_id' => $consumoId,
                            'fecha_venta' => now(),
                            'comentario' => $comentario,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'total' => $precio * $cantidad,
                            'eliminado' => 'false',
                            'comentarioeliminado' => '',
                        ]);
    
                        $cantidadanterior = $stock->Cantidad;
                        $cantidadactual = $stock->Cantidad - $cantidad;
                        $stock->Cantidad -= $cantidad;
                        $stock->save();
                        
                        if($consumo->TipoConsumo == "Mesa"){
                            $valortiposervicio = "Mesa";
                            $valordescripcion = "Consumo en la Mesa #".$consumo->ambientemesa->Name." - ".$ExiteProducto->NombreProducto;
                        }
                        if($consumo->TipoConsumo == "Mostrador"){
                            $valortiposervicio = "Mostrador";
                            $valordescripcion = "Consumo Mostrador"." - ".$ExiteProducto->NombreProducto;
                        }
                        if($consumo->TipoConsumo == "Delivery"){
                            $valortiposervicio = "Delivery";
                            $valordescripcion = "Consumo Delivery "." - ".$ExiteProducto->NombreProducto;
                        }
                        if($consumo->TipoConsumo == "ServicioPedido"){
                            $valortiposervicio = "ServicioPedido";
                            $valordescripcion = "Consumo".$consumo->TipoServicioPedido." N".$consumo->NroPedidoServicioPedido." - ".$ExiteProducto->NombreProducto;
                        }

                        $stockdate = DetalleStockDate::create([
                            'TipoStock' => "Salida",
                            'StockAnterior' => $cantidadanterior,
                            'StockActual' => $cantidadactual,
                            'Diferencia' => $cantidad,
                            'DetalleStock' => $valordescripcion,
                            'FechaStock' => now(),
                            'stock_dates_id' => $stock->id,
                            'TipoServicio' => $valortiposervicio, 
                            'IdTipoServicio' => $consumoId,
                        ]);
                    }else{
                        return response()->json("El Stock Del Producto Es Menor a La cantidad");
                    }                       
                } else {
                    $detalleConsumo = DetalleConsumo::create([
                        'producto_id' => $productoId,
                        'consumo_id' => $consumoId,
                        'fecha_venta' => now(),
                        'comentario' => $comentario,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $precio * $cantidad,
                        'eliminado' => 'false',
                        'comentarioeliminado' => '',
                    ]);
                } 
    
                foreach ($modificadores as $modificador) {
                    if ($modificador['Checkbox']) {
                        $ModificadorPrecio = $modificador['CostoDetalleModificador'];
                        $ModificadorCantidad = $modificador['Cantidad'];
    
                        $detallemodificadore = ModificadorDetalleConsumo::create([
                            'detalle_modificadore_id' => $modificador['id'],
                            'detalle_consumo_id' => $detalleConsumo->id,
                            'fecha_venta' => now(),
                            'comentario' => "nada",
                            'cantidad' => $ModificadorCantidad,
                            'precio' => $ModificadorPrecio,
                            'total' => $ModificadorCantidad * $ModificadorPrecio,
                            'eliminado' => 'false',
                            'comentarioeliminado' => '',
                        ]);
                        $totalmodificador += $ModificadorPrecio * $ModificadorCantidad;
                    }
                }
    
                $consumo = Consumo::findOrFail($consumoId);
                $consumo->subTotal += $precio * $cantidad + $totalmodificador;
                $consumo->total = $consumo->subTotal;
                $consumo->save();
    
                $descuentoPorcentaje = DescuentoConsumo::where('consumo_id', $consumoId)->get();
                foreach ($descuentoPorcentaje as $descuento) {
                    if ($descuento->TipoDescuento == 'porcentaje') {
                        $totalDescuento = ($consumo->subTotal * $descuento->MontoDescuento) / 100;
                        $descuento->TotalDescuento = $totalDescuento;
                        $descuento->save();
                    }
                }
    
                $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
                $valorfinal = $consumo->total - $SumDescuentoSubtotal;
                $consumo->total = $valorfinal;
                $consumo->save();
            }
            
            return response()->json(['message' => $consumo]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function RegistrarXd(Request $request, $detalle){
      
        return response()->json($detalleconsumo);
    }

    /* public function DeleteDetalleConsumo(Request $request, $detalle){
        $detalleconsumo = DetalleConsumo::findOrFail($detalle);
        $detalleconsumo->eliminado = 'true';
        $detalleconsumo->comentarioeliminado = $request->comentario;
        $IDconsumo = $detalleconsumo->consumo_id;
        
        $consumo = Consumo::findOrFail($IDconsumo);
        $consumo->total -= $detalleconsumo->total;
        $consumo->save();

        $detalleconsumo->save();
        return response()->json($detalleconsumo);
    } */


    public function deleteDetalleConsumo(Request $request, $detalle){
        DB::beginTransaction();
        try {
            $detalleConsumo = DetalleConsumo::findOrFail($detalle);
            $cantidad = $detalleConsumo->cantidad;
            if ($detalleConsumo->eliminado == 'true') {
                return response()->json(['message' => 'El DetalleConsumo ya fue eliminado.']);
            }

            $consumo = Consumo::with(['cliente','ambientemesa'])->where('id',$detalleConsumo->consumo_id)->first();

            if ($consumo->subTotal >= $detalleConsumo->total) {               
                $detalleConsumo->eliminado = 'true';
                $detalleConsumo->comentarioeliminado = $request->comentario;
                $detalleConsumo->save();

                $consumo->subTotal -= $detalleConsumo->total;

                $modificadorTotal = ModificadorDetalleConsumo::where('detalle_consumo_id', $detalleConsumo->id)->sum('total');
                $consumo->subTotal -= $modificadorTotal;                

                ModificadorDetalleConsumo::where('detalle_consumo_id', $detalleConsumo->id)->delete();

                $producto = Producto::find($detalleConsumo->producto_id);
                
                if ($producto && $producto->ControlStock == 'true') {                    

                    $stock = StockDate::where('producto_id', $producto->id)->first();                  
                    $servicioconsumo = ServicioConsumo::where('id', $consumo->servicio_consumo_id)->first();
                    if ($servicioconsumo) {
                        $hospedaje = HospedajeHabitacion::where('id', $servicioconsumo->hospedaje_habitacion_id)->first();
                    } else {
                        $hospedaje = null;
                    }
                    if ($servicioconsumo) {
                        $salonreserva = ServicioConsumo::where('reserva_salones_id', $servicioconsumo->reserva_salones_id)->first();
                    } else {
                        $salonreserva = null;
                    }

                    $cantidadanterior = $stock->Cantidad;
                    $cantidadactual = $stock->Cantidad + $cantidad;
                    $stock->Cantidad += $cantidad;
                    $stock->save();
                    
                    if($consumo->TipoConsumo == "Mesa"){
                        $valortiposervicio = "Mesa";
                        $valordescripcion = "Se Elimino el Consumo en la Mesa #".$consumo->ambientemesa->Name." - ".$producto->NombreProducto;
                        $ideliminado = $consumo->id;
                    }
                    if($consumo->TipoConsumo == "Mostrador"){
                        $valortiposervicio = "Mostrador";
                        $valordescripcion = "Se Elimino el Consumo en Mostrador"." - ".$producto->NombreProducto;
                        $ideliminado = $consumo->id;
                    }
                    if($consumo->TipoConsumo == "Delivery"){
                        $valortiposervicio = "Delivery";
                        $valordescripcion = "Se Elimino el Consumo en Delivery "." - ".$producto->NombreProducto;
                        $ideliminado = $consumo->id;
                    }
                    if($consumo->TipoConsumo == "ServicioPedido"){
                        $valortiposervicio = "ServicioPedido";
                        $valordescripcion = "Se Elimino el Consumo en ".$consumo->TipoServicioPedido." N".$consumo->NroPedidoServicioPedido." - ".$producto->NombreProducto;
                        $ideliminado = $consumo->id;
                    }
                    if($consumo->TipoConsumo == "Habitacion"){
                        $valortiposervicio = "Habitacion";
                        $valordescripcion = "Se Elimino el Consumo en Habitacion #".$hospedaje->habitacion_id." - ".$hospedaje->CodigoHospedaje." - ".$producto->NombreProducto;
                        $ideliminado = $hospedaje->id;
                    }
                    if($consumo->TipoConsumo == "Salon"){
                        $valortiposervicio = "Salon";
                        $valordescripcion = "Se Elimino el Consumo en Salon"." - ".$producto->NombreProducto;
                        $ideliminado = $salonreserva->id;
                    }
                    
                    $stockdate = DetalleStockDate::create([
                        'TipoStock' => "Ingreso",
                        'StockAnterior' => $cantidadanterior,
                        'StockActual' => $cantidadactual,
                        'Diferencia' => $cantidad,
                        'DetalleStock' => $valordescripcion,
                        'FechaStock' => now(),
                        'stock_dates_id' => $stock->id,
                        'TipoServicio' => $valortiposervicio, 
                        'IdTipoServicio' => $ideliminado,
                    ]);
                }

                // Aplicar descuento si es basado en porcentaje
                $descuentos = DescuentoConsumo::where('consumo_id', $consumo->id)->get();
                foreach ($descuentos as $descuento) {
                    if ($descuento->TipoDescuento == 'porcentaje') {
                        $descuento->TotalDescuento = ($consumo->subTotal * $descuento->MontoDescuento) / 100;
                        $descuento->save();
                    }
                }

                $totalDescuentos = $descuentos->sum('TotalDescuento');
                $consumo->total = $consumo->subTotal - $totalDescuentos;
                $consumo->save();

                DB::commit();

                return response()->json($detalleConsumo);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'La cantidad a restar supera el total del Consumo.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al eliminar el DetalleConsumo.']);
        }
    }

    public function CerrarMesa(Request $request, $id){
        //return response()->json("el id es ".$id);

        $user = Auth::user();        
        
        $registro = Pagos::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $datos = $request->all();
        $pagos = $datos['pagos'];
        $consumo = Consumo::with(['cliente','ambientemesa'])->where('id',$id)->first();

        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipo'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['cantidad'],
                'consumo_id' => $id,
            ]);

            $caja = Caja::latest()->first();
            $ingresoAcumulado = 0;
            $egresoAcumulado = 0;

            if($caja){
                if($CreatePago->TipoPago == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalRestaurante'),
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Consumo Restaurante Mesa #" . $consumo->ambientemesa->Name . " - " . $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);

                    $caja->caja_restaurante_ingreso += $CreatePago->TotalPago;
                    $caja->save();

                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalRestaurante'))->where('Eliminado','false')->get();

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
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Consumo Restaurante Mesa #" . $consumo->ambientemesa->Name . " - " . $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);

                    $caja->caja_tarjetas_ingreso += $CreatePago->TotalPago;
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
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Consumo Restaurante Mesa #" . $consumo->ambientemesa->Name . " - " . $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);

                    $caja->caja_depositos_ingreso += $CreatePago->TotalPago;
                    $caja->save();
                    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
            }

        }

        $consumo = Consumo::where('id',$id)->first();
        $consumo->ocupado = "false";
        $consumo->FechaCierre = now();
        $mesa = AmbienteMesa::where('id',$consumo->ambiente_mesa_id)->first();
        $mesa->estado = 'libre';
        $consumo->save();
        $mesa->save();
        return response()->json($mesa);
        
    }

    public function GetMostradorConsumo($id){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Mostrador')->get();
        return response()->json($consumo);
    }

    public function GetMostradorConsumoAll(){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('ocupado','true')->where('TipoConsumo','Mostrador')->get();
        return response()->json($consumo);
    }

    public function RegistrarConsumoMostrador(Request $request){
        $registro = Consumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user(); 
        if ($user) {
            $consumo = Consumo::create([
                'CantidadPersonas' => 0,
                'empresa_id' => $user->empresa_id,
                'user_id' => $user->id,
                'cliente_id' => $request->mcliente_id,
                'camarero_id' => $request->mcamarero_id,
                'fecha_venta' => now(),
                'total' => 0,
                'subTotal' => 0,
                'Comentario' => $request->mComentario,
                'ocupado' => 'true',
                'TipoConsumo' => 'Mostrador',
            ]);
            return response()->json($consumo);
        } else {
            return response()->json("user No INICIADO SESSION");
        }                
    }

    public function RegistrarDetalleConsumoMostrador(Request $request){
        return response()->json($request->all());
        $totalmodificador = 0;
        try {
            foreach ($request->all() as $producto) {
                $consumoId = $producto['Idconsumo'];
                $productoId = $producto['Idproducto'];
                $cantidad = $producto['cantidad'];
                $comentario = $producto['comentario'];
                $precio = $producto['precio'];
                $modificadores = $producto['Modificadores'];                         
                
                $ExiteProducto = Producto::where('id',$productoId)->first();
                
                if ($ExiteProducto->ControlStock == "true"){
                    $detalleConsumo = DetalleConsumo::create([
                        'producto_id' => $productoId,
                        'consumo_id' => $consumoId,
                        'fecha_venta' => now(),
                        'comentario' => $comentario,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $precio * $cantidad,
                        'eliminado' => 'false',
                        'comentarioeliminado' => '',
                    ]);

                    $stockdate = StockDate::create([
                        'Cantidad' => $cantidad,
                        'TipoStock' => "Adición Creada",
                        'StockAnterior' => $ExiteProducto->CantidadStock,
                        'StockActual' => $ExiteProducto->CantidadStock - $cantidad,
                        'Diferencia' => $cantidad,
                        'NombreProducto' =>  $ExiteProducto->NombreProducto,
                        'DetalleStock' => "Ajuste Manual - Stock Anterior ".$ExiteProducto->CantidadStock." y estock actualizado ".$cantidad,
                        'FechaStock' => now(),
                        'producto_id' => $ExiteProducto->id,
                    ]);

                    $nuevostock = $ExiteProducto->CantidadStock - $cantidad;
                    $ExiteProducto->CantidadStock = $nuevostock;
                    $ExiteProducto->save();
                }else{
                    $detalleConsumo = DetalleConsumo::create([
                        'producto_id' => $productoId,
                        'consumo_id' => $consumoId,
                        'fecha_venta' => now(),
                        'comentario' => $comentario,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $precio * $cantidad,
                        'eliminado' => 'false',
                        'comentarioeliminado' => '',
                    ]);
                } 

                foreach ($modificadores as $modificador) {
                    $ModificadorPrecio = $modificador['CostoDetalleModificador'];
                    $ModificadorCantidad = $modificador['Cantidad'];
                    
                    // Verifica si el checkbox está marcado
                    if ($modificador['Checkbox']) { 
                        // Crea un registro utilizando los datos del modificador
                        $detallemodificadore = ModificadorDetalleConsumo::create([
                            'detalle_modificadore_id' => $modificador['id'],
                            'detalle_consumo_id' => $detalleConsumo->id,
                            'fecha_venta' => now(),
                            'comentario' => "nada",
                            'cantidad' => $modificador['Cantidad'],
                            'precio' => $modificador['CostoDetalleModificador'],
                            'total' => $modificador['Cantidad'] * $modificador['CostoDetalleModificador'],
                            'eliminado' => 'false',
                            'comentarioeliminado' => '',
                        ]);
                        // Aquí puedes realizar cualquier otra operación que necesites con $detallemodificadore
                        
                        // Suma el total de este modificador al total general
                        $totalmodificador += $ModificadorPrecio * $ModificadorCantidad;
                    }
                }

                $consumo = Consumo::findOrFail($consumoId);
                $consumo->subTotal += $precio * $cantidad;
                $consumo->subTotal += $totalmodificador;
                $subTotal = $consumo->subTotal;
                $consumo->total = $subTotal;
                $consumo->save();

                $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$consumoId)->get();
                foreach ($descuentoPorcentaje as $descuento) {
                    if($descuento->TipoDescuento == 'porcentaje'){
                        $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                        $descuento->TotalDescuento = $totalDescuento;
                        $descuento->save();
                    }
                }
                
            }
            $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
            $valorfinal = $consumo->total - $SumDescuentoSubtotal;
            Consumo::where('id', $consumoId)->update(['total' => $valorfinal]);
    
            return response()->json(['message' => 'Detalles del consumo registrados correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetMostrador($id){
        $consumo = Consumo::with(['cliente',
                                    'camarero',
                                    'detalleconsumos.producto',
                                    'detalleconsumos.producto.modificadore',
                                    'detalleconsumos.producto.modificadore.detallemodificador',
                                    'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                    'detalleconsumos.modificadordetalleconsumo',
                                    'descuentoconsumos',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'
                                    ])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Mostrador')->get();
        return response()->json($consumo);
    }

    public function CerrarMostrador(Request $request, $id){
        //return response()->json($request);

        $user = Auth::user();
        
        $registro = Pagos::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $consumo = Consumo::where('id',$id)->first();
        $datos = $request->all();
        $pagos = $datos['pagos'];
        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipo'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['cantidad'],
                'consumo_id' => $id,
            ]);

            $caja = Caja::latest()->first();
            $ingresoAcumulado = 0;
            $egresoAcumulado = 0;
            
            if($caja){
                if($CreatePago->TipoPago == "Efectivo"){
                    $detallecaja = DetalleCaja::create([
                        'user_id' => $user->id,
                        'caja_id' => $caja->id,
                        'codigo_caja_id' => config('global.GlobalRestaurante'),
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Consumo Mostrador - ". $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);

                    $caja->caja_restaurante_ingreso += $CreatePago->TotalPago;
                    $caja->save();

                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalRestaurante'))->where('Eliminado','false')->get();

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
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Consumo Mostrador - ". $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);

                    $caja->caja_tarjetas_ingreso += $CreatePago->TotalPago;
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
                        'articulo_caja_id' => 24,
                        'Articulo_description' => "Consumo Mostrador - ". $consumo->Comentario . ($consumo->cliente ? " - " . $consumo->cliente->NombreCliente : ''),
                        'Ingreso' => $CreatePago->TotalPago,
                        'Egreso' => "0.00",
                        'Fecha_registro' => now(),
                        'ServicioPrestado' => $consumo->id,
                        'TipoServicioPrestado' => 'Consumo',
                    ]);

                    $caja->caja_depositos_ingreso += $CreatePago->TotalPago;
                    $caja->save();
                    
                    $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalDeposito'))->where('Eliminado','false')->get();

                    foreach ($cajahostals as $caja) {
                        $ingresoAcumulado += $caja->Ingreso;
                        $egresoAcumulado += $caja->Egreso;
                        $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                        $caja->save();
                    }
                }
            }
        }

        $consumo->ocupado = 'false';
        $consumo->FechaCierre = now();
        $consumo->save();

        return response()->json($consumo);
    }

    public function GetMostradorConsumoAllCerrado(){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('ocupado','false')->where('TipoConsumo','Mostrador')->orderByDesc('FechaCierre')->take(5)->get();
        return response()->json($consumo);
    }

    public function GetMostradorConsumoCerrado($id){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos','pagosconsumos'])->where('id',$id)->where('ocupado','false')->where('TipoConsumo','Mostrador')->get();
        return response()->json($consumo);
    }

    public function RegistrarConsumoDelivery(Request $request){
        //return response()->json($request);
        $user = Auth::user(); 

        if($user) {
            if($request->ClienteID == null && $request->RegistrarCliente == "true"){
                $clientes = Cliente::create([
                    'NombreCliente' => $request->ClienteNombre,
                    'TelefonoCliente' => $request->ClienteTelefono,
                    'CalleCliente' => $request->ClienteCalle,
                    'NumeroCliente' => $request->ClienteNumero,
                    'PisoCliente' => $request->ClientePiso,
                    'BarrioCliente' => $request->ClienteBarrio,
                    'EstadoCliente' => 'Activo'
                ]);
                $consumo = Consumo::create([
                    'CantidadPersonas' => 0,
                    'empresa_id' => $user->empresa_id,
                    'user_id' => $user->id,
                    'cliente_id' => $clientes->id,
                    'repartidor_id' => $request->SelectRepartidor,
                    'fecha_venta' => now(),
                    'total' => 0,
                    'subTotal' => 0,
                    'Comentario' => $request->DeliveryComentario,
                    'ocupado' => 'true',
                    'TipoConsumo' => 'Delivery',
                    'EstadoDelivery' => 'Preparacion',
                    'DeliveryComentario' => $request->DeliveryComentario,
                    'DeliveryCosto' => $request->DeliveryCosto,
                    'DeliveryTiempo' => $request->SelectTiempo,
                    'subTotal' => $request->DeliveryCosto,
                    'total' => $request->DeliveryCosto,
                ]);
            }elseif($request->ClienteID == null && $request->RegistrarCliente == "false"){
                $clientes = ClienteTemporal::create([
                    'NombreCliente' => $request->ClienteNombre,
                    'TelefonoCliente' => $request->ClienteTelefono,
                    'CalleCliente' => $request->ClienteCalle,
                    'NumeroCliente' => $request->ClienteNumero,
                    'PisoCliente' => $request->ClientePiso,
                    'BarrioCliente' => $request->ClienteBarrio,
                ]);
                $consumo = Consumo::create([
                    'CantidadPersonas' => 0,
                    'empresa_id' => $user->empresa_id,
                    'user_id' => $user->id,
                    'cliente_temporal_id' => $clientes->id,
                    'repartidor_id' => $request->SelectRepartidor,
                    'fecha_venta' => now(),
                    'total' => 0,
                    'subTotal' => 0,
                    'Comentario' => $request->DeliveryComentario,
                    'ocupado' => 'true',
                    'TipoConsumo' => 'Delivery',
                    'EstadoDelivery' => 'Preparacion',
                    'DeliveryComentario' => $request->DeliveryComentario,
                    'DeliveryCosto' => $request->DeliveryCosto,
                    'DeliveryTiempo' => $request->SelectTiempo,
                    'subTotal' => $request->DeliveryCosto,
                    'total' => $request->DeliveryCosto,
                ]);
            }elseif($request->ClienteID != null){
                $cliente = Cliente::where('id',$request->ClienteID)->first();
                $cliente->NombreCliente = $request->ClienteNombre;
                $cliente->CalleCliente = $request->ClienteCalle;
                $cliente->NumeroCliente = $request->ClienteNumero;
                $cliente->PisoCliente = $request->ClientePiso;
                $cliente->BarrioCliente = $request->ClienteBarrio;
                $cliente->save();
                $consumo = Consumo::create([
                    'CantidadPersonas' => 0,
                    'empresa_id' => $user->empresa_id,
                    'user_id' => $user->id,
                    'cliente_id' => $request->ClienteID,
                    'repartidor_id' => $request->SelectRepartidor,
                    'fecha_venta' => now(),
                    'total' => 0,
                    'subTotal' => 0,
                    'Comentario' => $request->DeliveryComentario,
                    'ocupado' => 'true',
                    'TipoConsumo' => 'Delivery',
                    'EstadoDelivery' => 'Preparacion',
                    'DeliveryComentario' => $request->DeliveryComentario,
                    'DeliveryCosto' => $request->DeliveryCosto,
                    'DeliveryTiempo' => $request->SelectTiempo,
                    'subTotal' => $request->DeliveryCosto,
                    'total' => $request->DeliveryCosto,
                ]);
            }            
            return response()->json($consumo);
        } else {
            return response()->json("user No INICIADO SESSION");
        }                
    }

    public function GetDeliveryPreparacion(){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos','clientetemporal'])->where('EstadoDelivery','Preparacion')->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function GetDeliveryEntregar(){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos','clientetemporal'])->where('EstadoDelivery','Entregar')->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function GetDeliveryEnviar(){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos','clientetemporal'])->where('EstadoDelivery','Enviado')->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function GetDeliveryCompleto(){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos','clientetemporal'])->where('EstadoDelivery','Completo')->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function GetDelivryCosumo($id){
        $consumo = Consumo::with(['cliente',
                                'clientetemporal',
                                'camarero',
                                'detalleconsumos.producto',
                                'detalleconsumos.producto.modificadore',
                                'detalleconsumos.producto.modificadore.detallemodificador',
                                'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                'detalleconsumos.modificadordetalleconsumo',
                                'descuentoconsumos',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'
                                ])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function GetPreparandoDelivery($id){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function GenerarComandaMesa($mesa){
        $user = Auth::user();
        $consumos = Consumo::with([
            'ambientemesa',
            'empresa',
            'cliente',
            'camarero',
            'detalleconsumos.producto',
            'detalleconsumos.producto.modificadore',
            'detalleconsumos.producto.modificadore.detallemodificador',
            'detalleconsumos.producto.modificadore.detallemodificador.producto',
            'detalleconsumos.modificadordetalleconsumo',
            'descuentoconsumos',
            'detalleconsumos.modificadordetalleconsumo.detallemodificador',
            'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'
        ])
        ->where('ambiente_mesa_id', $mesa)
        ->where('ocupado', 'true')
        ->where('TipoConsumo', 'Mesa')
        ->get();

        //return response()->json($consumos);

        if ($consumos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay consumos registrados para esta mesa.');
        }

        $pdf = PDF::loadView('admin.consumo.ConsumoMesaPDF', compact('consumos'))
            ->setPaper(array(0,0,250,500), 'portrait');

        return $pdf->stream('Date.pdf');
    }

    public function GenerarComandaMostrador($id){
        $user = Auth::user();
        $consumos = Consumo::with([
            'ambientemesa',
            'empresa',
            'cliente',
            'camarero',
            'detalleconsumos.producto',
            'detalleconsumos.producto.modificadore',
            'detalleconsumos.producto.modificadore.detallemodificador',
            'detalleconsumos.producto.modificadore.detallemodificador.producto',
            'detalleconsumos.modificadordetalleconsumo',
            'descuentoconsumos',
            'detalleconsumos.modificadordetalleconsumo.detallemodificador',
            'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'
        ])
        ->where('id', $id)
        ->where('ocupado', 'true')
        ->where('TipoConsumo', 'Mostrador')
        ->get();

        //return response()->json($consumos);

        if ($consumos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay consumos registrados para esta mesa.');
        }

        //return view('admin.consumo.ConsumoMostradorPDF', compact('consumos'));

        $pdf = PDF::loadView('admin.consumo.ConsumoMostradorPDF', compact('consumos'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        return $pdf->stream('Date.pdf');
    }


    public function GenerarComandaDeliveryPreparando($id){
        $user = Auth::user();
        $consumos = Consumo::with([
            'ambientemesa',
            'empresa',
            'cliente',
            'camarero',
            'detalleconsumos.producto',
            'detalleconsumos.producto.modificadore',
            'detalleconsumos.producto.modificadore.detallemodificador',
            'detalleconsumos.producto.modificadore.detallemodificador.producto',
            'detalleconsumos.modificadordetalleconsumo',
            'descuentoconsumos',
            'detalleconsumos.modificadordetalleconsumo.detallemodificador',
            'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'
        ])
        ->where('id', $id)
        ->where('ocupado', 'true')
        ->where('TipoConsumo', 'Delivery')
        ->get();

        //return response()->json($consumos);

        if ($consumos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay consumos registrados para esta mesa.');
        }

        $pdf = PDF::loadView('admin.consumo.ConsumoDeliveryPreparandoPDF', compact('consumos'))
                    ->setPaper(array(0,0,250,600), 'portrait');;

        return $pdf->stream('Date.pdf');
    }
    

    public function guardarCostoEnvio(Request $request, $id){
        $validatedData = $request->validate([
            'nuevoCosto' => 'required|numeric|min:0',
        ]);
        $consumo = Consumo::find($id);
        if (!$consumo) {
            return response()->json(['error' => 'costo no encontrado.'], 404);
        }

        //primero recuperamos el valor anterior del costo
        $ValorAnterior = $consumo->DeliveryCosto;

        //quitamos el valor al total y subtotal
        $consumo->total -= $ValorAnterior;
        $consumo->subTotal -= $ValorAnterior;
        $consumo->save();

        //primero recuperamos el valor nuevo del costo
        $ValorNuevo = $validatedData['nuevoCosto'];

        //sumamos el valor al total y subtotal
        $consumo->DeliveryCosto = $ValorNuevo;
        $consumo->total += $ValorNuevo;
        $consumo->subTotal += $ValorNuevo;
        $consumo->save();


        return response()->json(['success' => 'Costo de envío actualizado correctamente.']);
    }

    public function GetVentaSeleccionado($id){
        $consumo = Consumo::with(['cliente',
                                    'camarero',
                                    'ambientemesa',
                                    'detalleconsumos.producto',
                                    'detalleconsumos.producto.modificadore',
                                    'detalleconsumos.producto.modificadore.detallemodificador',
                                    'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                    'detalleconsumos.modificadordetalleconsumo',
                                    'descuentoconsumos',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                                    'pagosconsumos',
                                    ])->where('id',$id)->get();
        return response()->json($consumo);
    }

    public function ActualizarDatos(Request $request){
        $idConsumo = $request->id;
        $consumo = Consumo::findOrFail($idConsumo);
        $consumo->CantidadPersonas = $request->CantidadPersonas;
        $consumo->Comentario = $request->Comentario;
        $consumo->cliente_id = $request->cliente_id;
        $consumo->save();
    
        $mesa = $request->mesa_id;
    
        if ($mesa != null && $mesa != $consumo->ambiente_mesa_id) {
            $mesaambiente = AmbienteMesa::where('id', $consumo->ambiente_mesa_id)->first();
            $mesaambiente->estado = "libre";
            $mesaambiente->save();
    
            $mesanueva = AmbienteMesa::where('id', $mesa)->first();
            $mesanueva->estado = "ocupado";
            $consumo->ambiente_mesa_id = $mesa;
            $consumo->save();
            $mesanueva->save();
        }
        return response()->json(['success' => true, 'message' => 'Actualización exitosa', 'data' => $consumo]);
    }
    
    public function GetConsumoMesaAll() {
        // Obtiene la fecha actual en formato Y-m-d
        $today = now()->toDateString();
        
        // Consulta para obtener consumos de tipo 'Mesa' solo del día actual
        $consumo = Consumo::with(['cliente',
                                'camarero',
                                'detalleconsumos.producto',
                                'detalleconsumos.producto.modificadore',
                                'detalleconsumos.producto.modificadore.detallemodificador',
                                'detalleconsumos.producto.modificadore.detallemodificador.producto',
                                'detalleconsumos.modificadordetalleconsumo',
                                'descuentoconsumos',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                                'pagosconsumos',
                                ])->where('TipoConsumo', 'Mesa')
                                ->whereDate('created_at', $today) // Filtra por la fecha actual
                                ->get();
                            
        return response()->json($consumo);
    }
    
    public function RegistrarCortesiaDetalleConsumo($id){
        $dateconsumo = DetalleConsumo::where('id', $id)->first();
        
        if($dateconsumo->cortesia == "false"){
            $dateconsumo->cortesia = "true";
            $dateconsumo->totalcortesia = $dateconsumo->total;
            $dateconsumo->total = 0.00;
            $dateconsumo->save();
    
            $consumo = Consumo::where('id', $dateconsumo->consumo_id)->first();
            $sumdetalle = DetalleConsumo::where('consumo_id', $consumo->id)->where('cortesia','false')->sum('total');
            $sumdescuento = DescuentoConsumo::where('consumo_id', $consumo->id)->sum('TotalDescuento');
            $consumo->subTotal = $sumdetalle;
            $consumo->total = $sumdetalle - $sumdescuento;
            $consumo->save();
        }else{
            $dateconsumo->cortesia = "false";
            $dateconsumo->total = $dateconsumo->totalcortesia;
            $dateconsumo->totalcortesia = 0.00;            
            $dateconsumo->save();
    
            $consumo = Consumo::where('id', $dateconsumo->consumo_id)->first();
            $sumdetalle = DetalleConsumo::where('consumo_id', $consumo->id)->where('cortesia','false')->sum('total');
            $sumdescuento = DescuentoConsumo::where('consumo_id', $consumo->id)->sum('TotalDescuento');
            $consumo->subTotal = $sumdetalle;
            $consumo->total = $sumdetalle - $sumdescuento;
            $consumo->save();
        }

        return response()->json($dateconsumo);
    }

    public function RegistrarServicioPedido(Request $request){
        $registro = Consumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $fecha = Carbon::parse($request->fecha);

        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $turnoscambiadoestado = $this->CambiarEstadoTurnos();
        $turnoActivo = $turnoscambiadoestado->firstWhere('Estado', 'true');
        $consumo = Consumo::create([
            'empresa_id' => $user->empresa_id,
            'user_id' => $user->id,
            'fecha_venta' => now(),
            'total' => 0,
            'subTotal' => 0,
            'ocupado' => 'false',
            'TipoConsumo' => 'ServicioPedido',
            'turno_id' => $turnoActivo->id,
            'NroOrdenServicioPedido' => $request->adicionales['nroOrden'],
            'NroPedidoServicioPedido' => $request->adicionales['nroPedido'],
            'ClienteServicioPedido' => $request->adicionales['cliente'],
            'TipoServicioPedido' => $request->adicionales['tipodeservicio'],
            'TipoPagoServicioPedido' => $request->adicionales['tiposerviciopago']

        ]);

        foreach ($request->input('productos') as $producto) {

            $ExiteProducto = Producto::where('id', $producto['Idproducto'])->first();
            $cantidad = $producto['cantidad'];

            if ($ExiteProducto->ControlStock == "true") {
                $stock = StockDate::where('producto_id', $ExiteProducto->id)->first();

                if($stock->Cantidad > 0 && $stock->Cantidad >= $cantidad){                           
                    $detalleconsumo = DetalleConsumo::create([
                        'producto_id' => $producto['Idproducto'],
                        'consumo_id' => $consumo->id,
                        'fecha_venta' => now(),
                        'comentario' => $producto['comentario'],
                        'cantidad' => $producto['cantidad'],
                        'precio' => $producto['precio'],
                        'total' => $producto['precio'] * $producto['cantidad'],
                        'eliminado' => 'false',
                        'comentarioeliminado' => '',
                    ]);

                    $cantidadanterior = $stock->Cantidad;
                    $cantidadactual = $stock->Cantidad - $cantidad;
                    $stock->Cantidad -= $cantidad;
                    $stock->save();
                    
                    if($consumo->TipoConsumo == "ServicioPedido"){
                        $valortiposervicio = "ServicioPedido";
                        $valordescripcion = "Consumo ".$consumo->TipoServicioPedido." N".$consumo->NroPedidoServicioPedido." - ".$ExiteProducto->NombreProducto;
                    }

                    $stockdate = DetalleStockDate::create([
                        'TipoStock' => "Salida",
                        'StockAnterior' => $cantidadanterior,
                        'StockActual' => $cantidadactual,
                        'Diferencia' => $cantidad,
                        'DetalleStock' => $valordescripcion,
                        'FechaStock' => now(),
                        'stock_dates_id' => $stock->id,
                        'TipoServicio' => $valortiposervicio, 
                        'IdTipoServicio' => $consumo->id,
                    ]);
                }else{
                    return response()->json("El Stock Del Producto Es Menor a La cantidad");
                }                       
            } else {
                $detalleconsumo = DetalleConsumo::create([
                    'producto_id' => $producto['Idproducto'],
                    'consumo_id' => $consumo->id,
                    'fecha_venta' => now(),
                    'comentario' => $producto['comentario'],
                    'cantidad' => $producto['cantidad'],
                    'precio' => $producto['precio'],
                    'total' => $producto['precio'] * $producto['cantidad'],
                    'eliminado' => 'false',
                    'comentarioeliminado' => '',
                ]);
            } 
        }

        $sumdetalle = DetalleConsumo::where('consumo_id',$consumo->id)->sum('total');
        $consumo->subTotal = $sumdetalle;
        $consumo->total = $sumdetalle;
        
        $consumo->created_at = $fecha;
        $consumo->updated_at = $fecha;
        $consumo->fecha_venta = $fecha;

        $consumo->save();
        
        $pagos = Pagos::create([
            'TipoPago' => $request->adicionales['tiposerviciopago'],
            'FechaDePago' => now(),
            'TotalPago' => $sumdetalle,
            'TipoMoneda' => "Bs",
            'consumo_id' => $consumo->id,
        ]);

        $caja = Caja::latest()->first();
        if($caja){
            if($request->adicionales['tiposerviciopago'] == "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalRestaurante'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Delivery " . $consumo->TipoServicioPedido . " #" . $consumo->NroPedidoServicioPedido . " - " . $consumo->ClienteServicioPedido,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_restaurante_ingreso += $consumo->total;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalRestaurante'),)->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->adicionales['tiposerviciopago'] == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Delivery " . $consumo->TipoServicioPedido . " #" . $consumo->NroPedidoServicioPedido,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_tarjetas_ingreso += $consumo->total;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->adicionales['tiposerviciopago'] == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Delivery " . $consumo->TipoServicioPedido . " #" . $consumo->NroPedidoServicioPedido,
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_depositos_ingreso += $consumo->total;
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
    }

    public function FiltrarGetServicioPedido(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $id = $request->input('idCaja'); 
        $fechaInicio = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
       
        switch ($tipoFiltro) {
            case 'DiarioServicioPedido':
                $consumoservicio = Consumo::where('TipoConsumo','ServicioPedido')
                                ->with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])
                                ->whereDay('created_at', $dia)
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();
                                
                $totalconsumo = $consumoservicio->sum('total');
            break;
            case 'MensualidadServicioPedido':
                $consumoservicio = Consumo::where('TipoConsumo','ServicioPedido')
                                ->with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();
                
                $totalconsumo = $consumoservicio->sum('total');
            break;
            case 'RangoServicioPedido':
                $consumoservicio = Consumo::where('TipoConsumo','ServicioPedido')
                                ->with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])
                                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                ->get();
                
                $totalconsumo = $consumoservicio->sum('total');
            break;
        }

        return response()->json([
            'consumoservicio' => $consumoservicio,
            'totalconsumo' => $totalconsumo,
        ]);
    }    

    public function RegistrarVentaSuelta(Request $request){
        // Verificar si se ha enviado el formulario recientemente
        $registro = Consumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user();
        $ingresoAcumulado = 0;
        $egresoAcumulado = 0;
        $turnoscambiadoestado = $this->CambiarEstadoTurnos();
        $turnoActivo = $turnoscambiadoestado->firstWhere('Estado', 'true');

        // Verificar stock de todos los productos antes de crear el consumo
        foreach ($request->input('productos') as $producto) {
            $ExiteProducto = Producto::where('id', $producto['Idproducto'])->first();
            $cantidad = $producto['cantidad'];

            if ($ExiteProducto->ControlStock == "true") {
                $stock = StockDate::where('producto_id', $ExiteProducto->id)->first();

                if (!$stock || $stock->Cantidad < $cantidad) {
                    return response()->json([
                        'message' => "El stock del producto '{$ExiteProducto->NombreProducto}' es insuficiente para la cantidad solicitada.",
                    ], 400);
                }
            }
        }

        // Crear el consumo solo si todos los productos tienen suficiente stock
        $consumo = Consumo::create([
            'empresa_id' => $user->empresa_id,
            'user_id' => $user->id,
            'fecha_venta' => now(),
            'total' => 0,
            'subTotal' => 0,
            'ocupado' => 'false',
            'TipoConsumo' => 'VentaSuelta',
            'turno_id' => $turnoActivo->id,
            'Comentario' => $request->adicionales['comentario'],
            'TipoPagoServicioPedido' => $request->adicionales['tipoventasueltapago'],
        ]);

        $detalleproductoacumulado = "";
        foreach ($request->input('productos') as $producto) {
            $ExiteProducto = Producto::where('id', $producto['Idproducto'])->first();
            $cantidad = $producto['cantidad'];
            $stock = StockDate::where('producto_id', $ExiteProducto->id)->first();

            // Crear el detalle del consumo
            $detalleconsumo = DetalleConsumo::create([
                'producto_id' => $producto['Idproducto'],
                'consumo_id' => $consumo->id,
                'fecha_venta' => now(),
                'comentario' => $producto['comentario'],
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'total' => $producto['precio'] * $producto['cantidad'],
                'eliminado' => 'false',
                'comentarioeliminado' => '',
            ]);

            // Actualizar stock
            $cantidadanterior = $stock->Cantidad;
            $cantidadactual = $stock->Cantidad - $cantidad;
            $stock->Cantidad -= $cantidad;
            $stock->save();

            $valordescripcion = "Venta N" . $consumo->id . " - " . $ExiteProducto->NombreProducto;
            DetalleStockDate::create([
                'TipoStock' => "Salida",
                'StockAnterior' => $cantidadanterior,
                'StockActual' => $cantidadactual,
                'Diferencia' => $cantidad,
                'DetalleStock' => $valordescripcion,
                'FechaStock' => now(),
                'stock_dates_id' => $stock->id,
                'TipoServicio' => "venta",
                'IdTipoServicio' => $consumo->id,
            ]);

            $detalleproductoacumulado .= $ExiteProducto->NombreProducto . "(" . $producto['cantidad'] . ")\n";
        }

        // Calcular subtotal y total
        $sumdetalle = DetalleConsumo::where('consumo_id', $consumo->id)->sum('total');
        $consumo->subTotal = $sumdetalle;
        $consumo->total = $sumdetalle;
        $consumo->save();

        // Registrar pago
        Pagos::create([
            'TipoPago' => $request->adicionales['tipoventasueltapago'],
            'FechaDePago' => now(),
            'TotalPago' => $sumdetalle,
            'TipoMoneda' => "Bs",
            'consumo_id' => $consumo->id,
        ]);

        $caja = Caja::latest()->first();
        if($caja){
            if($request->adicionales['tipoventasueltapago'] == "Efectivo"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalRestaurante'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Venta de ".$detalleproductoacumulado.", ".$request->adicionales['comentario'],
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_restaurante_ingreso += $consumo->total;
                $caja->save();

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id',config('global.GlobalRestaurante'),)->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->adicionales['tipoventasueltapago'] == "Tarjeta"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalTarjeta'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Venta de ".$detalleproductoacumulado.", ".$request->adicionales['comentario'],
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_tarjetas_ingreso += $consumo->total;
                $caja->save();  

                $cajahostals = DetalleCaja::where('caja_id', $caja->id)->where('codigo_caja_id', config('global.GlobalTarjeta'))->where('Eliminado','false')->get();

                foreach ($cajahostals as $caja) {
                    $ingresoAcumulado += $caja->Ingreso;
                    $egresoAcumulado += $caja->Egreso;
                    $caja->Sumatoria = $ingresoAcumulado - $egresoAcumulado;
                    $caja->save();
                }
            }

            if($request->adicionales['tipoventasueltapago'] == "Deposito/QR"){
                $detallecaja = DetalleCaja::create([
                    'user_id' => $user->id,
                    'caja_id' => $caja->id,
                    'codigo_caja_id' => config('global.GlobalDeposito'),
                    'articulo_caja_id' => 24,
                    'Articulo_description' => "Venta de ".$detalleproductoacumulado.", ".$request->adicionales['comentario'],
                    'Ingreso' => $consumo->total,
                    'Egreso' => "0.00",
                    'Fecha_registro' => now(),
                    'ServicioPrestado' => $consumo->id,
                    'TipoServicioPrestado' => 'Consumo',
                ]);

                $caja->caja_depositos_ingreso += $consumo->total;
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

        return response()->json(['message' => 'Venta registrada con éxito.']);
    }


    public function FiltrarGetVentaSuelta(Request $request){
        //return response()->json($request);
        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $id = $request->input('idCaja'); 
        $fechaInicio = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
       
        switch ($tipoFiltro) {
            case 'DiarioVentaSuelta':
                $ventasuelta = Consumo::with('pagosconsumos')
                                ->where('TipoConsumo','VentaSuelta')
                                ->whereDay('created_at', $dia)
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();
                                
                $totalconsumo = $ventasuelta->sum('total');
            break;
            case 'MensualidadVentaSuelta':
                $ventasuelta = Consumo::with('pagosconsumos')
                                ->where('TipoConsumo','VentaSuelta')
                                ->whereMonth('created_at', $mes)
                                ->whereYear('created_at', $anio)
                                ->get();
                
                $totalconsumo = $ventasuelta->sum('total');
            break;
            case 'RangoVentaSuelta':
                $ventasuelta = Consumo::with('pagosconsumos')
                                ->where('TipoConsumo','VentaSuelta')
                                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                                ->get();
                
                $totalconsumo = $ventasuelta->sum('total');
            break;
        }

        return response()->json([
            'ventasuelta' => $ventasuelta,
            'totalventasuelta' => $totalconsumo,
        ]);
    }

    public function ImprimirTicketServicioVenta($id){
        $consumos = Consumo::where('id', $id)
                    ->with(['cliente',
                            'camarero',
                            'ambientemesa',
                            'detalleconsumos.producto',
                            'detalleconsumos.producto.modificadore',
                            'detalleconsumos.producto.modificadore.detallemodificador',
                            'detalleconsumos.producto.modificadore.detallemodificador.producto',
                            'detalleconsumos.modificadordetalleconsumo',
                            'descuentoconsumos',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                            'pagosconsumos',])->first();

        //return response()->json($consumos);

        $pdf = PDF::loadView('admin.consumo.PdfServicioVenta', compact('consumos'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json(['pdfBase64' => $pdfBase64]);
    }

    public function ImprimirTicketMostrador($id){
        $consumos = Consumo::where('id', $id)
                    ->with(['cliente',
                            'camarero',
                            'ambientemesa',
                            'detalleconsumos.producto',
                            'detalleconsumos.producto.modificadore',
                            'detalleconsumos.producto.modificadore.detallemodificador',
                            'detalleconsumos.producto.modificadore.detallemodificador.producto',
                            'detalleconsumos.modificadordetalleconsumo',
                            'descuentoconsumos',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                            'pagosconsumos',])->first();

        //return response()->json($consumos);

        $pdf = PDF::loadView('admin.consumo.PdfMostrador', compact('consumos'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json(['pdfBase64' => $pdfBase64]);
    }

    public function ImprimirTicketVentasGeneral($id){
        $consumos = Consumo::where('id', $id)
                    ->with(['cliente',
                            'camarero',
                            'ambientemesa',
                            'detalleconsumos.producto',
                            'detalleconsumos.producto.modificadore',
                            'detalleconsumos.producto.modificadore.detallemodificador',
                            'detalleconsumos.producto.modificadore.detallemodificador.producto',
                            'detalleconsumos.modificadordetalleconsumo',
                            'descuentoconsumos',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                            'pagosconsumos',])->first();

        //return response()->json($consumos);

        $pdf = PDF::loadView('admin.consumo.PdfMostrador', compact('consumos'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json(['pdfBase64' => $pdfBase64]);
    }

    public function ImprimirTicketVentasSuelta($id){
        $consumos = Consumo::where('id', $id)
                    ->with(['cliente',
                            'camarero',
                            'ambientemesa',
                            'detalleconsumos.producto',
                            'detalleconsumos.producto.modificadore',
                            'detalleconsumos.producto.modificadore.detallemodificador',
                            'detalleconsumos.producto.modificadore.detallemodificador.producto',
                            'detalleconsumos.modificadordetalleconsumo',
                            'descuentoconsumos',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                            'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto',
                            'pagosconsumos',])->first();

        //return response()->json($consumos);

        $pdf = PDF::loadView('admin.consumo.PdfVentaSuelta', compact('consumos'))
                    ->setPaper(array(0,0,250,500), 'portrait');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json(['pdfBase64' => $pdfBase64]);
    }
}

