<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use App\Models\DescuentoConsumo;
use Illuminate\Http\Request;

class DescuentoConsumoController extends Controller
{
    public function RegistrarDescuento(Request $request){

        $consumo = Consumo::where('id',$request->id)->first();
        $total = $consumo->subTotal;
        if($request->porcentaje != 0){
            $totalDescuento = ($total * $request->porcentaje) / 100;
            $Descuento = DescuentoConsumo::create([
                'TipoDescuento' => 'porcentaje',
                'FechaDescuento' => now(),
                'MontoDescuento' => $request->porcentaje,
                'TotalDescuento' => $totalDescuento,
                'consumo_id' => $request->id,
            ]);
        }else{
            $Descuento = DescuentoConsumo::create([
                'TipoDescuento' => 'total',
                'FechaDescuento' => now(),
                'MontoDescuento' => $request->monto,
                'TotalDescuento' => $request->monto,
                'consumo_id' => $request->id,
            ]);            
        }

        $descuentoPorcentaje = DescuentoConsumo::where('consumo_id',$request->id)->get();
        $SumDescuentoSubtotal = $descuentoPorcentaje->sum('TotalDescuento');
        $valorfinal = $consumo->subTotal - $SumDescuentoSubtotal;
        $dateconsumo = Consumo::where('id', $request->id)->update(['total' => $valorfinal]);
        //return response()->json($dateconsumo);
        return response()->json($Descuento);
    }

    public function GetDescuento($id){
        $descuento = DescuentoConsumo::where('consumo_id',$id)->get();
        return response()->json($descuento);
    }

    public function eliminarDescuento($id){
        try {
            $descuento = DescuentoConsumo::findOrFail($id);
            $consumo = Consumo::where('id',$descuento->consumo_id)->first();
            $consumo->total += $descuento->TotalDescuento;
            $consumo->save();
            $descuento->delete();
            return response()->json($consumo);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
