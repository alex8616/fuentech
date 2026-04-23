<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\StockDate;
use App\Models\SubCategoria;
use App\Models\Consumo;
use App\Models\User;
use App\Models\Ingrediente;
use App\Models\Proveedore;
use App\Models\DetalleStockDate;
use App\Models\ServicioConsumo;
use App\Models\HospedajeHabitacion;
use App\Models\ReservaSalones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductosImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductoController extends Controller
{
    public function GetProducto() {
        $productos = Producto::with(['modificadore.detallemodificador.producto'])
            ->orderByRaw('CASE WHEN "FavoritoProducto" = \'true\' THEN 1 ELSE 0 END DESC')
            ->get();
    
        return response()->json($productos);
    }

    public function GetProductoStock(){
        $productos = Producto::where('ControlStock','true')->with('stockdates')->get();
        return response()->json($productos);
    }

    public function GetProductoSeleccionadoStock($producto){
        $productos = Producto::with('stockdates','stockdates.detalleStockDates','stockdates.detalleStockDates.proveedores')->where('id',$producto)->first();
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
        $productos = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente','modificadore.detallemodificador')->where('id',$producto)->first();
        return response()->json($productos);
    }

    public function GetProductoFavorite(){
        $productos = Producto::with('stockdates')
            ->where('FavoritoProducto', 'true')
            ->get()
            ->filter(function($producto) {
                if ($producto->ControlStock === 'true') {
                    // Filtra productos que tienen ControlStock = true y cantidades mayores a 0 en stockdates
                    return $producto->stockdates->contains(function($stockdate) {
                        return $stockdate->Cantidad > 0;
                    });
                } 
                // Incluye productos con ControlStock = false
                return true;
            });

        return response()->json($productos);

    }

    public function GetProductoFavoriteStock(){
        $productos = Producto::with('stockdates')
            ->where('ControlStock', 'true')
            ->get()
            ->filter(function($producto) {
                return $producto->stockdates->contains(function($stockdate) {
                    return $stockdate->Cantidad > 0;
                });
            });
    
        return response()->json($productos);
    }

    public function RegistrarProducto(Request $request){
        $registro = Producto::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $nombreExiste = Producto::where('NombreProducto', $request->Nombre)->exists();
        if ($nombreExiste) {
            return response()->json(['message' => 'El nombre del producto ya está en uso.'], 400);
        }

        $user = Auth::user(); 
        $CategoriaID = $request->Categoria;
        $categoria = Categoria::where('id',$CategoriaID)->first();
        $NombreCat = $categoria->Nombre_categoria;

        function getInitials($string, $minLength = 4) {
            $words = explode(' ', $string);
            $filteredWords = array_filter($words, function($word) use ($minLength) {
                return strlen($word) >= $minLength;
            });
            $initials = array_map(function($word) {
                return $word[0];
            }, $filteredWords);
            return implode('', $initials);
        }
        $initials = getInitials($NombreCat);
        $ultimoproducto = Producto::latest()->first();
        $idultimo = $ultimoproducto ? $ultimoproducto->id + 1 : 1;
        $idultimoPadded = str_pad($idultimo, 4, '0', STR_PAD_LEFT);
        $Codificado = $initials . '-' . $idultimoPadded;
        
        // Crear el producto
        $producto = Producto::create([
            'NombreProducto' => $request->Nombre,
            'PrecioProducto' => $request->Precio,
            'CostoProducto' => $request->Costo,
            'CantidadStock' => 0,
            'MinimoStock' => 0,
            'CodigoProducto' => $Codificado,
            'EstadoProducto' => $request->activo,
            'DescripcionProducto' => $request->Descripcion,
            'ControlStock' => $request->controlStock,
            'proveedor_id' => $request->proveedor,
            'categoria_id' => $request->Categoria,
            'sub_categoria_id' => $request->SubCategoria,
            'empresa_id' => $user->empresa_id,
        ]);

        if($producto->ControlStock == "true"){
            $stockdate = StockDate::create([
                'Cantidad' => 0,
                'StockMinimo' => 0,
                'NombreProducto' => $producto->NombreProducto,
                'producto_id' => $producto->id,
            ]);
        }
    
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
        //return response()->json($request);

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

        if($request->input("controlStock") === "true"){
            $stock = StockDate::where('producto_id',$producto->id)->first();
            if(!$stock){
                $stockdate = StockDate::create([
                    'Cantidad' => 0,
                    'StockMinimo' => 0,
                    'NombreProducto' => $producto->NombreProducto,
                    'producto_id' => $producto->id,
                ]);
            }
        }

        return response()->json($producto);
    }

    public function ActualizarProductoStock(Request $request){
        $registro = StockDate::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $producto = Producto::where('id',$request->id)->first();

        
        return response()->json($stockdate);
    }

    public function getProductosAutoCompleta(Request $request) {
        $term = $request->query('term');
        $productos = Producto::where('NombreProducto', 'like', '%'.$term.'%')->get();
        return response()->json($productos);
    }
 
    
    public function GetPrueba(){
        $productos = Consumo::with(['detalleconsumos',
                                    'detalleconsumos.producto',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador',
                                    'detalleconsumos.modificadordetalleconsumo.detallemodificador.producto'])->get();
        return response()->json($productos);
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new ProductosImport, $request->file('file'));
            return response()->json(['success' => 'Productos importados correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al importar productos: ' . $e->getMessage());
            $error = Log::error('Error al importar productos: ' . $e->getMessage());
            return response()->json($error);
        }
    }

    public function ProductoModificador(Request $request, $producto){
        $miproducto = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente','modificadore.detallemodificador')->where('id', $producto)->first();
        if (!$miproducto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
        if (!$request->has('modificadores') || !is_array($request->modificadores) || count($request->modificadores) === 0) {
            return response()->json(['error' => 'Modificadores no válidos'], 400);
        }
        $idmodf = $request->modificadores[0]['IdMod'];
        $miproducto->modificadore_id = $idmodf;
        $miproducto->save();

        $productos = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente','modificadore.detallemodificador')->where('id', $miproducto->id)->first();

        return response()->json($productos);
    }

    public function EliminarDetalleReceta(Request $request){
        $miproducto = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente','modificadore.detallemodificador')->where('id', $request->Idproducto)->first();
        $miproducto->modificadore_id = null;
        $miproducto->save();

        $productos = Producto::with('categoria','categoria.subcategorias','proveedor','receta.detallerecetas.ingrediente','modificadore.detallemodificador')->where('id', $miproducto->id)->first();

        return response()->json($productos);
    }

    public function GetallProveedor($proveedor){
        $productos = Producto::where('proveedor_id',$proveedor)->get();
        $ingredientes = Ingrediente::where('proveedor_id',$proveedor)->get();
        return response()->json([
            'productos' => $productos,
            'ingredientes' => $ingredientes
        ]);
    }
    
    public function GetAllData(){
        $productos = Producto::with('stockdates')->get();
        $ingredientes = Ingrediente::all();
        return response()->json([
            'productos' => $productos,
            'ingredientes' => $ingredientes
        ]);
    }

    public function GetAllDisponible(){
        $productos = Producto::where('CantidadStock', '>', 1)->get();
        $ingredientes = Ingrediente::where('CantidadStock', '>', 1)->get();
        return response()->json([
            'productos' => $productos,
            'ingredientes' => $ingredientes
        ]);
    }

    public function GetAllPocoStock(){
        $productos = Producto::where('CantidadStock', '<=', 'MinimoStock')->get();
        $ingredientes = Ingrediente::where('CantidadStock', '<=', 'MinimoStock')->get();
        return response()->json([
            'productos' => $productos,
            'ingredientes' => $ingredientes
        ]);
    }

    public function GetAllAgotadoStock(){
        $productos = Producto::where('CantidadStock', '==', 0)->get();
        $ingredientes = Ingrediente::where('CantidadStock', '==', 0)->get();
        return response()->json([
            'productos' => $productos,
            'ingredientes' => $ingredientes
        ]);
    }

    public function GetAllSinStockDefinido(){
        $productos = Producto::where('CantidadStock', '=', NULL)->get();
        $ingredientes = Ingrediente::where('CantidadStock', '=', NULL)->get();
        return response()->json([
            'productos' => $productos,
            'ingredientes' => $ingredientes
        ]);
    }

    public function GetMovimientos() {
        $today = \Carbon\Carbon::today();
        $movimientos = StockDate::whereDate('created_at', $today)->get();
        return response()->json($movimientos);
    }

    public function GetMovimientoSeleccionado($id){
        $movimiento = StockDate::with(['productos','ingredientes'])->where('id', $id)->first();
        $idConsumo = $movimiento->consumo_id;
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
                                    ])->where('id',$idConsumo)->get();
        return response()->json([
            'movimiento' => $movimiento, 
            'consumo' => $consumo
        ]);
    }

    public function GetMovimientosCantidad() {
        $today = Carbon::now()->toDateString();
        $movimientos = StockDate::whereDate('created_at', $today)->count();
        $day = Carbon::now()->toDateString();
        $daymore = Carbon::now()->addDay()->toDateString();

        $data = [
            'day' => $day,
            'daymore' => $daymore,
            'count' => $movimientos
        ];

        return response()->json($data);
    }

    public function filtrarDatos(Request $request){
        //return response()->json($request);

        $tipoFiltro = $request->input('tipoFiltro');
        $dia = $request->input('dia');
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $TipoStock = $request->input('TipoStock');
        $EventoStock = $request->input('EventoStock');
        $searchText = $request->input('searchText');
        
        // Filtrar los datos según el tipo de filtro
        switch ($tipoFiltro) {
            case 'DiarioStock':
                if($TipoStock == 'ProductoStock'){
                    $movimientos = StockDate::whereDay('created_at', $dia)
                                            ->whereMonth('created_at', $mes)
                                            ->whereYear('created_at', $anio)
                                            ->whereNotNull('producto_id')
                                            ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                                return $query->where('TipoStock', $EventoStock);
                                            })
                                            ->when($TipoStock !== 'TodoStock', function ($query) use ($TipoStock) {
                                                if ($TipoStock === 'ProductoStock') {
                                                    return $query->whereNotNull('producto_id');
                                                } elseif ($TipoStock === 'IngredienteStock') {
                                                    return $query->whereNotNull('ingrediente_id');
                                                } else {
                                                    return $query->where('TipoStock', $TipoStock);
                                                }
                                            })
                                            ->when($searchText !== null, function ($query) use ($searchText) {
                                                return $query->where(function ($query) use ($searchText) {
                                                    $query->whereHas('producto', function ($subQuery) use ($searchText) {
                                                        $subQuery->where('NombreProducto', $searchText);
                                                    })->orWhereHas('ingrediente', function ($subQuery) use ($searchText) {
                                                        $subQuery->where('NombreIngrediente', $searchText);
                                                    });
                                                });
                                            })
                                            ->get();
                    break;
                }elseif($TipoStock == 'IngredienteStock'){
                    $movimientos = StockDate::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->whereNotNull('ingrediente_id')
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoStock', $EventoStock);
                                        })
                                        ->when($TipoStock !== 'TodoStock', function ($query) use ($TipoStock) {
                                            if ($TipoStock === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoStock === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoStock', $TipoStock);
                                            }
                                        })
                                        ->get();
                    break;
                }else{
                    $movimientos = StockDate::whereDay('created_at', $dia)
                                        ->whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoStock', $EventoStock);
                                        })
                                        ->when($TipoStock !== 'TodoStock', function ($query) use ($TipoStock) {
                                            if ($TipoStock === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoStock === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoStock', $TipoStock);
                                            }
                                        })
                                        ->get();
                    break;
                }                
            case 'MensualStock':
                $movimientos = StockDate::whereMonth('created_at', $mes)
                                        ->whereYear('created_at', $anio)
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoStock', $EventoStock);
                                        })
                                        ->when($TipoStock !== 'TodoStock', function ($query) use ($TipoStock) {
                                            if ($TipoStock === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoStock === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoStock', $TipoStock);
                                            }
                                        })
                                        ->when($searchText, function ($query) use ($searchText) {
                                            if ($searchText !== '') {
                                                // Dividir el texto en partes
                                                $parts = explode('-', $searchText);
                                                // Verificar que se obtuvieron suficientes partes
                                                if (count($parts) >= 2) {
                                                    $type = $parts[0];
                                                    $id = $parts[1];
                                                    if ($type === 'producto') {
                                                        return $query->where('producto_id', $id);
                                                    } elseif ($type === 'ingrediente') {
                                                        return $query->where('ingrediente_id', $id);
                                                    }
                                                }
                                            }
                                        })
                                        ->get();
                break;
            case 'AnualStock':
                $movimientos = StockDate::whereYear('created_at', $anio)
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoStock', $EventoStock);
                                        })
                                        ->when($TipoStock !== 'TodoStock', function ($query) use ($TipoStock) {
                                            if ($TipoStock === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoStock === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoStock', $TipoStock);
                                            }
                                        })
                                        ->get();
                break;
            case 'RangoStock':
                $movimientos = StockDate::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                        ->when($EventoStock !== 'Evento', function ($query) use ($EventoStock) {
                                            return $query->where('TipoStock', $EventoStock);
                                        })
                                        ->when($TipoStock !== 'TodoStock', function ($query) use ($TipoStock) {
                                            if ($TipoStock === 'ProductoStock') {
                                                return $query->whereNotNull('producto_id');
                                            } elseif ($TipoStock === 'IngredienteStock') {
                                                return $query->whereNotNull('ingrediente_id');
                                            } else {
                                                return $query->where('TipoStock', $TipoStock);
                                            }
                                        })
                                        ->get();
                break;
            default:
                $movimientos = StockDate::get();
                break;
        }

        // Devolver los datos filtrados como respuesta JSON
        return response()->json($movimientos);
    }

    public function RegistrarIngresoStock(Request $request){
        //return response()->json($request);
        $proveedor = Proveedore::where('id', $request->ProveedorKardex)->first();
        if ($proveedor) {
            $detaproveedor = $proveedor->name;
        } else {
            $detaproveedor = "Sin proveedor";
        }

        $stock = StockDate::where('id', $request->IngresoStockId)->with('detalleStockDates')->first();
        $cantidadanterior = $stock->Cantidad;
        $cantidadactual = $stock->Cantidad + $request->CantidadIngreso;
        $stock->Cantidad += $request->CantidadIngreso;
        $stock->save();

        if($cantidadanterior == 0){
            $diferencia = $request->CantidadIngreso;
        }else{
            $diferencia = $request->CantidadIngreso;
        }

        $Ingreso = DetalleStockDate::create([
            'TipoStock' => "Ingreso",
            'TipoServicio' => "Adquisicion Producto",
            'StockAnterior' => $cantidadanterior,
            'StockActual' => $cantidadactual,
            'Diferencia' => $diferencia,
            'DetalleStock' => $request->DescripcionIngreso." - ".$detaproveedor,
            'FechaStock' => now(),
            'stock_dates_id' => $stock->id,
            'proveedor_id' => $request->ProveedorKardex,
        ]);        

        return response()->json($Ingreso);
    }

    public function RegistrarFaltanteStock(Request $request){
        //return response()->json($request);
        $usuario = User::where('id', $request->ResponsableFaltante)->first();
        if ($usuario) {
            $datausuario = $usuario->name;
        } else {
            $datausuario = "Sin Usuario";
            return response()->json($datausuario);
        }

        if($request->TipoAccion == "Faltante"){
            $stock = StockDate::where('id', $request->StockId)->with('detalleStockDates')->first();
            $cantidadanterior = $stock->Cantidad;
            $cantidadactual = $stock->Cantidad - $request->CantidadFaltante;
            $stock->Cantidad -= $request->CantidadFaltante;
            $stock->save();
    
            if($cantidadanterior == 0){
                $diferencia = $request->CantidadFaltante;
            }else{
                $diferencia = $request->CantidadFaltante;
            }
    
            $Ingreso = DetalleStockDate::create([
                'TipoStock' => "Faltante",
                'TipoServicio' => "Faltante",
                'EstadoStock' => "Activo",
                'FechaInicioSolucion' => now(),
                'CantidadFaltante' => $diferencia,
                'StockAnterior' => $cantidadanterior,
                'StockActual' => $cantidadactual,
                'Diferencia' => $diferencia,
                'DetalleStock' => "Faltante del producto, responsable ".$datausuario,
                'FechaStock' => now(),
                'stock_dates_id' => $stock->id,
                'user_id' => $request->ResponsableFaltante,
            ]);
        }else{
            $stock = StockDate::where('id', $request->StockId)->with('detalleStockDates')->first();
            $cantidadanterior = $stock->Cantidad;
            $cantidadactual = $stock->Cantidad + $request->CantidadFaltante;
            $stock->Cantidad += $request->CantidadFaltante;
            $stock->save();
    
            if($cantidadanterior == 0){
                $diferencia = $request->CantidadFaltante;
            }else{
                $diferencia = $request->CantidadFaltante;
            }
    
            $salida = DetalleStockDate::create([
                'TipoStock' => "Sobrante",
                'TipoServicio' => "Sobrante",
                'EstadoStock' => "Activo",
                'FechaInicioSolucion' => now(),
                'CantidadFaltante' => $diferencia,
                'StockAnterior' => $cantidadanterior,
                'StockActual' => $cantidadactual,
                'Diferencia' => $diferencia,
                'DetalleStock' => "Sobrante del producto, responsable ".$datausuario,
                'FechaStock' => now(),
                'stock_dates_id' => $stock->id,
                'user_id' => $request->ResponsableFaltante,
            ]);
        }        

        return response()->json($request);
    }

    public function GetDetalleStockSeleccionado($id){
        //$detalle = Producto::with('stockdates','stockdates.detalleStockDates','stockdates.detalleStockDates.proveedores')->where('id',$producto)->first();
        $detalle = DetalleStockDate::with('stockdates','stockdates.productos','proveedores','users')->where('id',$id)->first();

        if($detalle->TipoServicio === "Habitacion"){
            $hospedaje = HospedajeHabitacion::with(['detallehospedajes','detallehospedajes.cliente'])->where('id',$detalle->IdTipoServicio)->first();
            $servicioconsumo = ServicioConsumo::where('hospedaje_habitacion_id',$detalle->IdTipoServicio)->first();
            $consumo = Consumo::where('servicio_consumo_id',$servicioconsumo->id)->with([
                'ambientemesa',
                'cliente',
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
            ])->first();
        }
    
        if($detalle->TipoServicio === "Salon"){
            $servicioconsumo = ServicioConsumo::where('reserva_salones_id',$detalle->IdTipoServicio)->first();
            $hospedaje = ReservaSalones::with(['salon','detallereservas','clientereserva','empresareserva'])->where('id',$detalle->IdTipoServicio)->first();
            $consumo = Consumo::where('servicio_consumo_id',$servicioconsumo->id)->with([
                'ambientemesa',
                'cliente',
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
            ])->first();
        }
        
        if($detalle->TipoServicio === "Mesa" || $detalle->TipoServicio === "Mostrador" || $detalle->TipoServicio === "Delivery" || $detalle->TipoServicio === "ServicioPedido" || $detalle->TipoServicio === "Adonore" || $detalle->TipoServicio === "venta" || $detalle->TipoServicio === "Adquisicion Producto" || $detalle->TipoServicio === "Faltante" || $detalle->TipoServicio === "Sobrante"){
            $hospedaje = "";
            $consumo = Consumo::where('id',$detalle->IdTipoServicio)->with([
                'ambientemesa',
                'cliente',
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
            ])->first();
        }

        return response()->json([
                'detalle' => $detalle, 
                'consumo' => $consumo,
                'hospedaje' => $hospedaje
            ]);
    }

    public function GetKardexUltimoRegistro(){
        $kardex = DetalleStockDate::whereNotIn('TipoServicio', ['Faltante', 'Sobrante'])->take(5)->orderBy('id', 'desc')->get();
        return response()->json($kardex);
    }

    public function RegistrarSolucionKardex(Request $request){
        //return response()->json($request);

        $selectKardex = $request->input('SelectKardex'); 
        $selectKardexArray = explode(',', $selectKardex);
        $selectKardexArray = array_map('intval', $selectKardexArray);

        $detalle = DetalleStockDate::with('stockdates')->where('id',$request->input('StockId'))->first();
        $detalle->SolucionStock = $request->input('DescripcionSolucion');
        $detalle->EstadoStock = "Solucionado";
        $detalle->FechaFinSolucion = now();
        $detalle->save();
        
        return response()->json($request);

    }

    public function GetGenerarPdfKardex($id) {
        $detalles = DetalleStockDate::with(['stockdates','users','stockdates.productos'])->where('id', $id)->first();
    
        //return response()->json($detalles);

        $pdf = PDF::loadView('admin.kardex.KardexPendientePDF', compact('detalles'))
                    ->setPaper(array(0, 0, 250, 600), 'portrait');
    
        $pdfContent = $pdf->output();
        $pdfBase64 = base64_encode($pdfContent);
    
        return response()->json([
            'pdfBase64' => 'data:application/pdf;base64,' . $pdfBase64
        ]);
    }
    
    public function verificarNombreProducto(Request $request){
        $existe = Producto::where('NombreProducto', $request->input('Nombre'))->exists();
        return response()->json($existe);
    }

    public function verificarNombreSimilar(Request $request){
        $nombre = $request->input('Nombre');
        
        $productos = Producto::where('NombreProducto', 'like', '%' . $nombre . '%')
                            ->limit(5)
                            ->get(['NombreProducto']);
        
        return response()->json($productos);
    }


}

