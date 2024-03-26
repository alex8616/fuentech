<?php

namespace App\Http\Controllers;

use App\Models\AmbienteMesa;
use App\Models\Cliente;
use App\Models\ClienteTemporal;
use App\Models\Consumo;
use App\Models\DescuentoConsumo;
use App\Models\DetalleConsumo;
use App\Models\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ConsumoController extends Controller
{

    public function RegistrarConsumo(Request $request){
        $user = Auth::user(); 

        if ($user) {
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
                'ocupado' => 'true'
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
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('ambiente_mesa_id',$mesa)->where('ocupado','true')->where('TipoConsumo','Mesa')->get();
        return response()->json($consumo);
    }

    public function GetMesaConsumo($id){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Mesa')->get();
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
                $consumoId = $producto['Idconsumo'];
                $productoId = $producto['Idproducto'];
                $cantidad = $producto['cantidad'];
                $comentario = $producto['comentario'];
                $precio = $producto['precio'];
    
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
    
                $consumo = Consumo::findOrFail($consumoId);
                $consumo->subTotal += $precio * $cantidad;
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
        $detalleConsumo = DetalleConsumo::findOrFail($detalle);
        if ($detalleConsumo->eliminado == 'true') {
            return response()->json(['message' => 'El DetalleConsumo ya fue eliminado.']);
        }
        $idConsumo = $detalleConsumo->consumo_id;
        DB::beginTransaction();

        try {
            $detalleConsumo->eliminado = 'true';
            $detalleConsumo->comentarioeliminado = $request->comentario;
            $detalleConsumo->save();

            $consumo = Consumo::findOrFail($idConsumo);

            if ($consumo->subTotal >= $detalleConsumo->total) {
                $consumo->subTotal -= $detalleConsumo->total;
                $consumo->total = $consumo->total - $consumo->subTotal;
                $consumo->save();
                $subTotal = $consumo->subTotal;

                $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$consumo->id)->get();
                foreach ($descuentoPorcentaje as $descuento) {
                    if($descuento->TipoDescuento == 'porcentaje'){
                        $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                        $descuento->TotalDescuento = $totalDescuento;
                        $descuento->save();
                    }
                }
                
            $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
            $valorfinal = $consumo->subTotal - $SumDescuentoSubtotal;
            Consumo::where('id', $consumo->id)->update(['total' => $valorfinal]);


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
        $datos = $request->all();
        $pagos = $datos['pagos'];
        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipo'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['cantidad'],
                'consumo_id' => $id,
            ]);
        }

        $consumo = Consumo::where('id',$id)->first();
        $consumo->ocupado = 'false';
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
        try {
            foreach ($request->all() as $producto) {
                $consumoId = $producto['Idconsumo'];
                $productoId = $producto['Idproducto'];
                $cantidad = $producto['cantidad'];
                $comentario = $producto['comentario'];
                $precio = $producto['precio'];
    
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
    
                $consumo = Consumo::findOrFail($consumoId);
                $consumo->subTotal += $precio * $cantidad;
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
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Mostrador')->get();
        return response()->json($consumo);
    }

    public function CerrarMostrador(Request $request, $id){
        //return response()->json($id);
        $datos = $request->all();
        $pagos = $datos['pagos'];
        foreach ($pagos as $pago) {
            $CreatePago = Pagos::create([
                'TipoPago' =>  $pago['tipo'],
                'FechaDePago' => now(),
                'TotalPago' => $pago['cantidad'],
                'consumo_id' => $id,
            ]);
        }

        $consumo = Consumo::where('id',$id)->first();
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
                    'EstadoDelivery' => 'Preparacion'
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
                    'EstadoDelivery' => 'Preparacion'
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
                    'EstadoDelivery' => 'Preparacion'
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

    public function GetDelivryCosumo($id){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function GetPreparandoDelivery($id){
        $consumo = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('id',$id)->where('ocupado','true')->where('TipoConsumo','Delivery')->get();
        return response()->json($consumo);
    }

    public function RegistrarDetalleConsumoDelivery(Request $request){
        try {
            foreach ($request->all() as $producto) {
                $consumoId = $producto['Idconsumo'];
                $productoId = $producto['Idproducto'];
                $cantidad = $producto['cantidad'];
                $comentario = $producto['comentario'];
                $precio = $producto['precio'];
    
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
    
                $consumo = Consumo::findOrFail($consumoId);
                $consumo->subTotal += $precio * $cantidad;
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

    public function GenerarComandaMesa($mesa){
        $user = Auth::user();
        $consumos = Consumo::with(['cliente','camarero','detalleconsumos.producto','descuentoconsumos'])->where('ambiente_mesa_id',$mesa)->where('ocupado','true')->where('TipoConsumo','Mesa')->get();
        //return response()->json($consumos);
        $pdf = PDF::loadView('admin.consumo.ConsumoMesaPDF',compact('consumos'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper(array(0,0,320,500), 'portrait');
        return $pdf->stream('Date.pdf');
    }
}

