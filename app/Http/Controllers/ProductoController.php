<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function GetProducto(){
        $productos = Producto::get();
        return response()->json($productos);
    }

    public function GetProductoCategoria($categoria){
        $productos = Producto::where('categoria_id',$categoria)->orderBy('FavoritoProducto', 'asc')->get();
        return response()->json($productos);
    }

    public function GetProductoSubCategoria($subcategoria){
        $productos = Producto::where('sub_categoria_id',$subcategoria)->orderBy('FavoritoProducto', 'asc')->get();
        return response()->json($productos);
    }

    public function GetProductoSeleccionado($producto){
        $productos = Producto::with('categoria','categoria.subcategorias','proveedor')->where('id',$producto)->first();
        return response()->json($productos);
    }

    public function GetProductoFavorite(){
        $productos = Producto::where('FavoritoProducto','true')->get();
        return response()->json($productos);
    }

    public function RegistrarProducto(Request $request){
        $user = Auth::user(); 
    
        // Crear el producto
        $producto = Producto::create([
            'NombreProducto' => $request->Nombre,
            'PrecioProducto' => $request->Precio,
            'CostoProducto' => $request->Costo,
            'CodigoProducto' => $request->Codigo,
            'EstadoProducto' => $request->activo,
            'DescripcionProducto' => $request->Descripcion,
            'ControlStock' => $request->controlStock,
            'proveedor_id' => $request->proveedor,
            'categoria_id' => $request->Categoria,
            'sub_categoria_id' => $request->SubCategoria,
            'empresa_id' => $user->empresa_id,
        ]);
    
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . str_replace(' ', '_', $imagen->getClientOriginalName());
            $rutaImagen = $imagen->storeAs('public/imagenes/productos', $nombreImagen);
            $rutaAlmacenamiento = str_replace('public', 'storage', $rutaImagen);
            $producto->ImagenProducto = $rutaAlmacenamiento;
            $producto->save();
        }
            
        return response()->json($producto);
    }
    

    public function ProductoEstadoTrue($producto){
        $EstadoProducto = Producto::where('id',$producto)->first();
        $EstadoProducto->FavoritoProducto = 'false';
        $EstadoProducto->save();
        return response()->json($EstadoProducto);
    }

    public function ProductoEstadoFalse($producto){
        $EstadoProducto = Producto::where('id',$producto)->first();
        $EstadoProducto->FavoritoProducto = 'true';
        $EstadoProducto->save();
        return response()->json($EstadoProducto);
    }
    
    public function UpdateProductoSeleccionado(Request $request){
        $producto = Producto::with('categoria','categoria.subcategorias','proveedor')->where('id',$request->id)->first();
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . str_replace(' ', '_', $imagen->getClientOriginalName());
            $rutaImagen = $imagen->storeAs('public/imagenes/productos', $nombreImagen);
            $rutaAlmacenamiento = str_replace('public', 'storage', $rutaImagen);
            $producto->ImagenProducto = $rutaAlmacenamiento;
            $producto->save();
        }
        return response()->json($producto);
    }

    public function ActualizarProducto(Request $request){
        $producto = Producto::with('categoria','categoria.subcategorias','proveedor')->where('id',$request->id)->first();
        $producto->NombreProducto = $request->input("nombre");
        $producto->PrecioProducto = $request->input("precio");
        $producto->CostoProducto = $request->input("costo");
        $producto->CodigoProducto = $request->input("codigo");
        $producto->proveedor_id = $request->input("proveedor");
        $producto->EstadoProducto = $request->input("activo");
        $producto->ControlStock = $request->input("controlStock");
        $producto->categoria_id = $request->input("categoria");
        $producto->sub_categoria_id = $request->input("subcategoria");
        $producto->save();
        return response()->json($producto);
    }
}