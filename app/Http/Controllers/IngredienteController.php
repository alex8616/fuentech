<?php

namespace App\Http\Controllers;

use App\Models\DetalleReceta;
use App\Models\Ingrediente;
use App\Models\Producto;
use App\Models\StockDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IngredientesImport;
use Carbon\Carbon;

class IngredienteController extends Controller
{
    public function GetIngredienteCategoria($categoria){
        $ingredientes = Ingrediente::where('categoria_ingrediente_id',$categoria)->get();
        return response()->json($ingredientes);
    }

    public function GeIngredienteSeleccionado($ingrediente){
        $ingredientes = Ingrediente::where('id',$ingrediente)->with(['proveedor','categoriaingrediente'])->first();
        return response()->json($ingredientes);
    }

    public function ActualizarIngrediente(Request $request){
        $ingrediente = Ingrediente::with('categoriaingrediente','proveedor')->where('id',$request->id)->first();
        $ingrediente->NombreIngrediente = $request->input("nombre");
        $ingrediente->UnidadIngrediente = $request->input("unidad");
        $ingrediente->CostoIngrediente = $request->input("costo");
        $ingrediente->CantidadIngrediente = $request->input("merma");
        $ingrediente->ControlStock = $request->input("controlStock");
        $ingrediente->proveedor_id = $request->input("proveedor");
        $ingrediente->categoria_ingrediente_id = $request->input("categoria");
        $ingrediente->save();
        return response()->json($ingrediente);
    }

    public function RegistrarIngrediente(Request $request){
        $registro = Ingrediente::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user(); 
    
        // Crear el producto
        $ingrediente = Ingrediente::create([
            'NombreIngrediente' => $request->Nombre,
            'UnidadIngrediente' => $request->Unidad,
            'CostoIngrediente' => $request->Costo,
            'CantidadIngrediente' => $request->Merma,
            'ControlStock' => $request->controlStock,
            'proveedor_id' => $request->proveedor,
            'categoria_ingrediente_id' => $request->Categoria,
        ]);
            
        return response()->json($ingrediente);
    }

    public function GetIngrediente(){
        $ingredientes = Ingrediente::get();
        return response()->json($ingredientes);
    }

    public function ActualizarDetalleReceta(Request $request){
        //return response()->json($request);
        $data = $request->all();
        $detallereceta = DetalleReceta::find($data['id']);
        if ($detallereceta) {
            $detallereceta->cantidadneta = $data['2'];
            $detallereceta->cantidadbruta = $data['cantidadBruta'];
            $detallereceta->unidad = $data['5'];
            $detallereceta->costo = $data['costoTotal'];
            $detallereceta->save();
            $productos = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente')->where('id',$request->producId)->first();
            return response()->json($productos);
        } else {
            return response()->json(['error' => 'Detalle de receta no encontrado'], 404);
        }
    }

    public function EliminarDetalleReceta(Request $request){
        //return response()->json($request);productoId
        $detalleRecetaId = $request->input('id');
        $detalleReceta = DetalleReceta::find($detalleRecetaId);
        if ($detalleReceta) {
            $detalleReceta->delete();
            $productos = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente')->where('id',$request->producId)->first();
            return response()->json($productos);
        } else {
            return response()->json(['error' => 'No se encontró el detalle de receta con el ID proporcionado'], 404);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new IngredientesImport, $request->file('file'));
            return response()->json(['success' => 'Productos importados correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al importar productos: ' . $e->getMessage());
            $error = Log::error('Error al importar productos: ' . $e->getMessage());
            return response()->json($error);
        }
    }
    
    public function GetIngredienteStock(){
        $ingredientes = Ingrediente::where('ControlStock','true')->get();
        return response()->json($ingredientes);
    }

    public function GetIngredienteSeleccionado($ingrediente){
        $productos = Ingrediente::with(['proveedor','categoriaingrediente'])->where('id',$ingrediente)->first();
        return response()->json($productos);
    }

    public function ActualizarIngredienteStock(Request $request){
        $registro = StockDate::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $ingrediente = Ingrediente::where('id',$request->id)->first();
        $mistockanterior = $ingrediente->CantidadStock;

        if($mistockanterior == NULL){
            $mistockanterior = 0;
        }

        $stockdate = StockDate::create([
            'Cantidad' => $request->input("cantidad"),
            'TipoStock' => "Ajuste Manual",
            'StockAnterior' => $mistockanterior,
            'StockActual' => $request->input("cantidad"),
            'Diferencia' => ($ingrediente->CantidadStock - $request->input("cantidad"))*(-1),
            'NombreProducto' =>  $ingrediente->NombreIngrediente,
            'DetalleStock' => "Ajuste Manual - Stock Anterior ".$mistockanterior." y estock actualizado ".$request->input("cantidad"),
            'FechaStock' => now(),
            'ingrediente_id' => $ingrediente->id,
        ]);

        $ingrediente->CantidadStock = $request->input("cantidad");
        $ingrediente->ComentarioStock = $request->input("comentario");
        $ingrediente->MinimoStock = $request->input("minimo");
        $ingrediente->save();
        return response()->json($stockdate);
    }
}
