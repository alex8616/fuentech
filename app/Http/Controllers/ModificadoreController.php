<?php

namespace App\Http\Controllers;

use App\Models\DetalleModificadore;
use App\Models\Modificadore;
use Illuminate\Http\Request;
use App\Models\ModificadorDetalleConsumo;
use App\Models\DetalleConsumo;
use App\Models\Consumo;
use App\Models\DescuentoConsumo;
use Carbon\Carbon;

class ModificadoreController extends Controller
{
    public function RegistrarModificadore(Request $request){
        $registro = Modificadore::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $modificador = Modificadore::create([
            'NombreModificador' => $request->Nombre,
            'NombrePublicoModificador' => $request->NombrePublic,
            'LogicaPrecioModificador' => $request->Logica,
            'CantidadMinimaModificador' => $request->CantMin,
            'CantidadMaximaModificador' => $request->CantMax,
        ]);
        return response()->json($modificador);
    }

    public function GetModificadores(){
        $modificador = Modificadore::withCount('detallemodificador')->with(['detallemodificador.producto'])->get();
        return response()->json($modificador);
    }

    public function GetModificadorSeleccionado($modificador){
        $modificador = Modificadore::with(['detallemodificador.producto'])->findOrFail($modificador);   
        return response()->json($modificador);
    }

    public function ActualizarModificador(Request $request){
        $modificador = Modificadore::where('id',$request->id)->first();
        $modificador->NombreModificador = $request->input("nombre");
        $modificador->NombrePublicoModificador = $request->input("nombrepublic");
        $modificador->LogicaPrecioModificador = $request->input("logica");
        $modificador->CantidadMinimaModificador = $request->input("cantmin");
        $modificador->CantidadMaximaModificador = $request->input("cantmax");
        $modificador->save();
        return response()->json($modificador);
    }

    public function RegistrarDetalleModificador(Request $request){
        $registro = DetalleModificadore::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $id = $request->idModificador;
        $productos = $request->input('productos');

        foreach ($productos as $producto) {
            $detallemodificador = DetalleModificadore::create([
                'CostoDetalleModificador' => $producto['costo'],
                'MaximoDetalleModificador' => $producto['cantidadMax'],
                'modificadore_id' => $id,
                'producto_id' => $producto['id'],
            ]);
        }

        $modificadores = Modificadore::with(['detallemodificador.producto'])->where('id',$id)->first();
        return response()->json($modificadores);
    }

    public function ActualizarDetalleModificador(Request $request){
        $data = $request->all();
        $detallemodificador = DetalleModificadore::find($data['id']);
        if ($detallemodificador) {
            $detallemodificador->CostoDetalleModificador = $data['costo'];
            $detallemodificador->MaximoDetalleModificador = $data['maximo'];
            $detallemodificador->save();
            $modificadores = Modificadore::with(['detallemodificador.producto'])->where('id',$request->modificadorId)->first();
            return response()->json($modificadores);
        } else {
            return response()->json(['error' => 'Detalle de receta no encontrado'], 404);
        }
    }

    public function EliminarDetalleModificador(Request $request){
        $detallemodificadorId = $request->input('id');
        $detallemodificador = DetalleModificadore::find($detallemodificadorId);
        if ($detallemodificador) {
            $detallemodificador->delete();
            $modificadores = Modificadore::with(['detallemodificador.producto'])->where('id',$request->modificadorId)->first();
            return response()->json($modificadores);
        } else {
            return response()->json(['error' => 'No se encontró el detalle de receta con el ID proporcionado'], 404);
        }
    }

    public function GetProductoAsociado($id){
        $modificador = Modificadore::with(['producto'])->findOrFail($id);   
        return response()->json($modificador);
    }

    public function ActualizarModificadorConsumo(Request $request){
        /*$registro = ModificadorDetalleConsumo::where('updated_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }*/

        $data = $request;
        $idModificador = $data->id;
        $ModiDetalleConsumo = ModificadorDetalleConsumo::findOrFail($idModificador);

        $detalleconsumo = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();
        $consumo = Consumo::where('id',$detalleconsumo->consumo_id)->first();
        $totalanterior = $ModiDetalleConsumo->total;
        $totalconsumo = $consumo->subTotal;
        $totalvaloranterior = $totalconsumo - $totalanterior;
        $consumo->subTotal = $totalvaloranterior;
        $consumo->total = $consumo->subTotal;
        $consumo->save();

        $ModiDetalleConsumo->cantidad = $data->cantidad;
        $ModiDetalleConsumo->total = $data->total;
        $ModiDetalleConsumo->save();
        $totalnuevo = $data->total;
        $totalconsumonuevo = $consumo->subTotal;
        $totalvalornuevo = $totalnuevo + $totalconsumonuevo;
        $consumo->subTotal = $totalvalornuevo;
        $consumo->total = $consumo->subTotal;
        $consumo->save();

        $detalleconsumoId = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();

        $subTotal = $consumo->subTotal;
        $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$detalleconsumoId->consumo_id)->get();

        foreach ($descuentoPorcentaje as $descuento) {
            if($descuento->TipoDescuento == 'porcentaje'){
                $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                $descuento->TotalDescuento = $totalDescuento;
                $descuento->save();
            }
        }

        $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
        $valorfinal = $consumo->total - $SumDescuentoSubtotal;
        Consumo::where('id', $detalleconsumoId->consumo_id)->update(['total' => $valorfinal]);
        
        return response()->json($consumo);
    }
    
    public function EliminarModificadorConsumo(Request $request){
        $ModiDetalleConsumoId = $request->input('id');
        $ModiDetalleConsumo = ModificadorDetalleConsumo::find($ModiDetalleConsumoId);
        $detalleconsumo = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();
        $consumo = Consumo::where('id',$detalleconsumo->consumo_id)->first();
        $totalanterior = $ModiDetalleConsumo->total;
        $totalconsumo = $consumo->subTotal;
        $result = $totalconsumo - $totalanterior;
        if ($ModiDetalleConsumo) {
            $consumo->subTotal = $result;
            $consumo->save();
            $consumo->total = $consumo->subTotal;
            $ModiDetalleConsumo->delete();
            $consumo->save();

            $detalleconsumoId = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();

            $subTotal = $consumo->subTotal;
            $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$detalleconsumoId->consumo_id)->get();

            foreach ($descuentoPorcentaje as $descuento) {
                if($descuento->TipoDescuento == 'porcentaje'){
                    $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                    $descuento->TotalDescuento = $totalDescuento;
                    $descuento->save();
                }
            }

            $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
            $valorfinal = $consumo->total - $SumDescuentoSubtotal;
            Consumo::where('id', $detalleconsumoId->consumo_id)->update(['total' => $valorfinal]);

            return response()->json($ModiDetalleConsumo);
        } else {
            return response()->json(['error' => 'No se encontró el detalle de receta con el ID proporcionado'], 404);
        }
    }

    public function EliminarModificadorConsumoMostrador(Request $request){
        $ModiDetalleConsumoId = $request->input('id');
        $ModiDetalleConsumo = ModificadorDetalleConsumo::find($ModiDetalleConsumoId);
        $detalleconsumo = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();
        $consumo = Consumo::where('id',$detalleconsumo->consumo_id)->first();
        $totalanterior = $ModiDetalleConsumo->total;
        $totalconsumo = $consumo->subTotal;
        $result = $totalconsumo - $totalanterior;
        if ($ModiDetalleConsumo) {
            $consumo->subTotal = $result;
            $consumo->save();
            $consumo->total = $consumo->subTotal;
            $ModiDetalleConsumo->delete();
            $consumo->save();

            $detalleconsumoId = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();

            $subTotal = $consumo->subTotal;
            $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$detalleconsumoId->consumo_id)->get();

            foreach ($descuentoPorcentaje as $descuento) {
                if($descuento->TipoDescuento == 'porcentaje'){
                    $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                    $descuento->TotalDescuento = $totalDescuento;
                    $descuento->save();
                }
            }

            $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
            $valorfinal = $consumo->total - $SumDescuentoSubtotal;
            Consumo::where('id', $detalleconsumoId->consumo_id)->update(['total' => $valorfinal]);

            return response()->json($consumo);
        } else {
            return response()->json(['error' => 'No se encontró el detalle de receta con el ID proporcionado'], 404);
        }
    }

    public function RegistrarModificadorConsumo(Request $request){
        $registro = ModificadorDetalleConsumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $datos = $request->all();
        if (!empty($datos) && is_array($datos)) {
            foreach ($datos as $dato) {
                if (isset($dato['iddetallemodificadore']) && isset($dato['iddetalleconsumo']) && $dato['checkboxValue']) {
                    $iddetallemodificadore = $dato['iddetallemodificadore'];
                    $iddetalleconsumo = $dato['iddetalleconsumo'];
                    $fecha_venta = now();
                    $cantidad = $dato['cantidad'];
                    $precio = $dato['precio'];
                    $total = $dato['total'];
    
                    $detalleconsumo = ModificadorDetalleConsumo::create([
                        'detalle_modificadore_id' => $iddetallemodificadore,
                        'detalle_consumo_id' => $iddetalleconsumo,
                        'fecha_venta' => $fecha_venta,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $total,
                    ]);
                    $registrosCreados[] = $detalleconsumo;                    
                }                
            }

            $detalleconsumoId = DetalleConsumo::where('id',$iddetalleconsumo)->first();
            $consumo = Consumo::where('id',$detalleconsumoId->consumo_id)->first();

            $consumo->subTotal += $detalleconsumo->total;
            $consumo->total = $consumo->subTotal;
            $consumo->save();

            $subTotal = $consumo->subTotal;
            $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$detalleconsumoId->consumo_id)->get();

            foreach ($descuentoPorcentaje as $descuento) {
                if($descuento->TipoDescuento == 'porcentaje'){
                    $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                    $descuento->TotalDescuento = $totalDescuento;
                    $descuento->save();
                }
            }

            $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
            $valorfinal = $consumo->total - $SumDescuentoSubtotal;
            Consumo::where('id', $detalleconsumoId->consumo_id)->update(['total' => $valorfinal]);

            if (isset($registrosCreados)) {
                return response()->json($registrosCreados);
            } else {
                return response()->json(['error' => 'Los datos no están en el formato esperado'], 400);
            }
        }
        return response()->json(['error' => 'Los datos no están en el formato esperado'], 400);
    }

    public function RegistrarModificadorConsumoMostrador(Request $request){
        $registro = ModificadorDetalleConsumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $datos = $request->all();
        if (!empty($datos) && is_array($datos)) {
            foreach ($datos as $dato) {
                if (isset($dato['iddetallemodificadore']) && isset($dato['iddetalleconsumo']) && $dato['checkboxValue']) {
                    $iddetallemodificadore = $dato['iddetallemodificadore'];
                    $iddetalleconsumo = $dato['iddetalleconsumo'];
                    $fecha_venta = now();
                    $cantidad = $dato['cantidad'];
                    $precio = $dato['precio'];
                    $total = $dato['total'];
    
                    $detalleconsumo = ModificadorDetalleConsumo::create([
                        'detalle_modificadore_id' => $iddetallemodificadore,
                        'detalle_consumo_id' => $iddetalleconsumo,
                        'fecha_venta' => $fecha_venta,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $total,
                    ]);
                    $registrosCreados[] = $detalleconsumo;                    
                }                
            }

            $detalleconsumoId = DetalleConsumo::where('id',$iddetalleconsumo)->first();
            $consumo = Consumo::where('id',$detalleconsumoId->consumo_id)->first();

            $consumo->subTotal += $detalleconsumo->total;
            $consumo->total = $consumo->subTotal;
            $consumo->save();

            $subTotal = $consumo->subTotal;
            $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$detalleconsumoId->consumo_id)->get();

            foreach ($descuentoPorcentaje as $descuento) {
                if($descuento->TipoDescuento == 'porcentaje'){
                    $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                    $descuento->TotalDescuento = $totalDescuento;
                    $descuento->save();
                }
            }

            $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
            $valorfinal = $consumo->total - $SumDescuentoSubtotal;
            Consumo::where('id', $detalleconsumoId->consumo_id)->update(['total' => $valorfinal]);

            if (isset($registrosCreados)) {
                return response()->json($consumo);
            } else {
                return response()->json(['error' => 'Los datos no están en el formato esperado'], 400);
            }
        }
        return response()->json(['error' => 'Los datos no están en el formato esperado'], 400);
    }

    public function GetModificadorSeleccionadoMostrador($modificador){
        $modificador = Modificadore::with(['detallemodificador.producto'])->findOrFail($modificador);   
        return response()->json($modificador);
    }

    public function ActualizarModificadorConsumoMostrador(Request $request){
        $data = $request;
        $idModificador = $data->id;
        $ModiDetalleConsumo = ModificadorDetalleConsumo::findOrFail($idModificador);

        $detalleconsumo = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();
        $consumo = Consumo::where('id',$detalleconsumo->consumo_id)->first();
        $totalanterior = $ModiDetalleConsumo->total;
        $totalconsumo = $consumo->subTotal;
        $totalvaloranterior = $totalconsumo - $totalanterior;
        $consumo->subTotal = $totalvaloranterior;
        $consumo->total = $consumo->subTotal;
        $consumo->save();

        $ModiDetalleConsumo->cantidad = $data->cantidad;
        $ModiDetalleConsumo->total = $data->total;
        $ModiDetalleConsumo->save();
        $totalnuevo = $data->total;
        $totalconsumonuevo = $consumo->subTotal;
        $totalvalornuevo = $totalnuevo + $totalconsumonuevo;
        $consumo->subTotal = $totalvalornuevo;
        $consumo->total = $consumo->subTotal;
        $consumo->save();

        $detalleconsumoId = DetalleConsumo::where('id',$ModiDetalleConsumo->detalle_consumo_id)->first();

        $subTotal = $consumo->subTotal;
        $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$detalleconsumoId->consumo_id)->get();

        foreach ($descuentoPorcentaje as $descuento) {
            if($descuento->TipoDescuento == 'porcentaje'){
                $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                $descuento->TotalDescuento = $totalDescuento;
                $descuento->save();
            }
        }

        $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
        $valorfinal = $consumo->total - $SumDescuentoSubtotal;
        Consumo::where('id', $detalleconsumoId->consumo_id)->update(['total' => $valorfinal]);
        
        return response()->json($consumo);
    }

    public function RegistrarModificadorConsumoDelivery(Request $request){
        $registro = ModificadorDetalleConsumo::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $datos = $request->all();
        if (!empty($datos) && is_array($datos)) {
            foreach ($datos as $dato) {
                if (isset($dato['iddetallemodificadore']) && isset($dato['iddetalleconsumo']) && $dato['checkboxValue']) {
                    $iddetallemodificadore = $dato['iddetallemodificadore'];
                    $iddetalleconsumo = $dato['iddetalleconsumo'];
                    $fecha_venta = now();
                    $cantidad = $dato['cantidad'];
                    $precio = $dato['precio'];
                    $total = $dato['total'];
    
                    $detalleconsumo = ModificadorDetalleConsumo::create([
                        'detalle_modificadore_id' => $iddetallemodificadore,
                        'detalle_consumo_id' => $iddetalleconsumo,
                        'fecha_venta' => $fecha_venta,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'total' => $total,
                    ]);
                    $registrosCreados[] = $detalleconsumo;                    
                }                
            }

            $detalleconsumoId = DetalleConsumo::where('id',$iddetalleconsumo)->first();
            $consumo = Consumo::where('id',$detalleconsumoId->consumo_id)->first();

            $consumo->subTotal += $detalleconsumo->total;
            $consumo->total = $consumo->subTotal;
            $consumo->save();

            $subTotal = $consumo->subTotal;
            $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$detalleconsumoId->consumo_id)->get();

            foreach ($descuentoPorcentaje as $descuento) {
                if($descuento->TipoDescuento == 'porcentaje'){
                    $totalDescuento = ($subTotal * $descuento->MontoDescuento) / 100;
                    $descuento->TotalDescuento = $totalDescuento;
                    $descuento->save();
                }
            }

            $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
            $valorfinal = $consumo->total - $SumDescuentoSubtotal;
            Consumo::where('id', $detalleconsumoId->consumo_id)->update(['total' => $valorfinal]);

            if (isset($registrosCreados)) {
                return response()->json($consumo);
            } else {
                return response()->json(['error' => 'Los datos no están en el formato esperado'], 400);
            }
        }
        return response()->json(['error' => 'Los datos no están en el formato esperado'], 400);
    }
}