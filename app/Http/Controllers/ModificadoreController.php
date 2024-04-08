<?php

namespace App\Http\Controllers;

use App\Models\DetalleModificadore;
use App\Models\Modificadore;
use Illuminate\Http\Request;

class ModificadoreController extends Controller
{
    public function RegistrarModificadore(Request $request){
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
}
