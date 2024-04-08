<?php

use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\AmbienteMesaController;
use App\Http\Controllers\CamareroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CocinaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\DescuentoConsumoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\RepartidoreController;
use App\Http\Controllers\CategoriaIngredienteController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\ModificadoreController;
use App\Http\Controllers\RecetaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-productos', [ProductoController::class, 'GetProducto']);
Route::get('/get-productos-categoria/{categoria}', [ProductoController::class, 'GetProductoCategoria']);
Route::get('/get-productos-seleccionado/{producto}', [ProductoController::class, 'GetProductoSeleccionado']);
Route::post('/update-productos-seleccionado', [ProductoController::class, 'UpdateProductoSeleccionado']);
Route::get('/get-productos-favorite', [ProductoController::class, 'GetProductoFavorite']);
Route::post('/registrar-producto', [ProductoController::class, 'RegistrarProducto'])->middleware('auth');
Route::get('/producto-register-true/{producto}', [ProductoController::class, 'ProductoEstadoTrue']);
Route::get('/producto-register-false/{producto}', [ProductoController::class, 'ProductoEstadoFalse']);
Route::post('/actualizar-producto', [ProductoController::class, 'ActualizarProducto']);
Route::get('/get-productos-subcategoria/{subcategoria}', [ProductoController::class, 'GetProductoSubCategoria']);
Route::get('/get-productos-stock', [ProductoController::class, 'GetProductoStock']);
Route::post('/actualizar-producto-stock', [ProductoController::class, 'ActualizarProductoStock']);
Route::get('/get-productos-autocompleta', [ProductoController::class, 'getProductosAutoCompleta']);

Route::get('/get-categorias', [CategoriaController::class, 'GetCategoria']);
Route::get('/get-subcategorias/{id}', [CategoriaController::class, 'GetSubCategoria']);
Route::post('/registrar-categoria', [CategoriaController::class, 'RegistrarCategoria'])->middleware('auth');
Route::post('/registrar-subcategoria', [CategoriaController::class, 'RegistrarSubCategoria'])->middleware('auth');
Route::get('/get-categoria-seleccionado/{categoria}', [CategoriaController::class, 'GetCategoriaSeleccionado']);
Route::get('/get-subcategoria-seleccionado/{subcategoria}', [CategoriaController::class, 'GetSubCategoriaSeleccionado']);
Route::post('/actualizar-categoria', [CategoriaController::class, 'ActualizarCategoria']);


Route::get('/get-categoria-ingredientes', [CategoriaIngredienteController::class, 'GetCategoriaIngrediente']);
Route::get('/get-categoria-ingredientes-seleccionado/{categoria}', [CategoriaIngredienteController::class, 'GetCategoriaSeleccionado']);
Route::post('/registrar-ingrediente-categoria', [CategoriaIngredienteController::class, 'RegistrarCategoria'])->middleware('auth');
Route::post('/actualizar-categoria-ingrediente', [CategoriaIngredienteController::class, 'ActualizarCategoria']);


Route::get('/get-ingrediente-categoria/{categoria}', [IngredienteController::class, 'GetIngredienteCategoria']);
Route::get('/get-ingrediente-seleccionado/{ingrediente}', [IngredienteController::class, 'GeIngredienteSeleccionado']);
Route::post('/actualizar-ingrediente', [IngredienteController::class, 'ActualizarIngrediente']);
Route::post('/registrar-ingrediente', [IngredienteController::class, 'RegistrarIngrediente'])->middleware('auth');
Route::get('/get-ingrediente', [IngredienteController::class, 'GetIngrediente']);
Route::post('/actualizar-detallereceta', [IngredienteController::class, 'ActualizarDetalleReceta']);
Route::post('/eliminar-detallereceta', [IngredienteController::class, 'EliminarDetalleReceta']);


Route::post('/registrar-receta', [RecetaController::class, 'RegistrarReceta'])->middleware('auth');

Route::post('/registrar-modificadore', [ModificadoreController::class, 'RegistrarModificadore'])->middleware('auth');
Route::get('/get-modificadores', [ModificadoreController::class, 'GetModificadores']);
Route::get('/get-modificador-seleccionado/{modificador}', [ModificadoreController::class, 'GetModificadorSeleccionado']);
Route::post('/actualizar-modificador', [ModificadoreController::class, 'ActualizarModificador']);
Route::post('/registrar-detalle-modificador', [ModificadoreController::class, 'RegistrarDetalleModificador'])->middleware('auth');
Route::post('/actualizar-detallemodificar', [ModificadoreController::class, 'ActualizarDetalleModificador']);
Route::post('/eliminar-detallemodificador', [ModificadoreController::class, 'EliminarDetalleModificador']);
Route::get('/get-producto-asociado/{id}', [ModificadoreController::class, 'GetProductoAsociado']);


Route::get('/get-cocinas', [CocinaController::class, 'GetCocina']);

Route::get('/get-ambientes', [AmbienteController::class, 'GetAmbiente']);
Route::get('/get-ambiente-seleccionado/{ambiente}', [AmbienteController::class, 'GetAmbienteSeleccionado']);

Route::post('/registrar-mesa', [AmbienteMesaController::class, 'registrarMesa'])->name('registrar-mesa')->middleware('auth');
Route::get('/get-mesa-editar/{mesa}', [AmbienteMesaController::class, 'GetMesaSeleccionado']);
Route::post('/actualizar-posicion-mesa', [AmbienteMesaController::class, 'actualizarPosicion'])->name('mesa.actualizar_posicion');


Route::get('/get-clientes', [ClienteController::class, 'GetCliente']);
Route::get('/Search-Client', [ClienteController::class, 'SearchClient']);


Route::get('/get-camarero', [CamareroController::class, 'GetCamarero']);

Route::get('/get-proveedor', [ProveedoreController::class, 'GetProveedor']);

Route::post('/registrar-consumo', [ConsumoController::class, 'RegistrarConsumo'])->name('registrar-consumo')->middleware('auth');
Route::get('/get-mesa-ocupado/{mesa}', [ConsumoController::class, 'GetMesaOcupado']);
Route::post('/registrar-detalle-consumo', [ConsumoController::class, 'RegistrarDetalleConsumo'])->name('registrar-detalle-consumo')->middleware('auth');
Route::post('/cerrar-mesa/{id}', [ConsumoController::class, 'CerrarMesa']);
Route::get('/get-mesa-consumo/{id}', [ConsumoController::class, 'GetMesaConsumo']);
Route::get('/get-mostrador-consumo-all', [ConsumoController::class, 'GetMostradorConsumoAll']);
Route::get('/get-mostrador-consumo/{id}', [ConsumoController::class, 'GetMostradorConsumo']);
Route::post('/registrar-consumo-mostrador', [ConsumoController::class, 'RegistrarConsumoMostrador'])->name('registrar-consumo-mostrador')->middleware('auth');
Route::post('/registrar-detalle-consumo-mostrador', [ConsumoController::class, 'RegistrarDetalleConsumoMostrador'])->name('registrar-detalle-consumo-mostrador')->middleware('auth');
Route::get('/get-consumo-ocupado-mostrador/{id}', [ConsumoController::class, 'GetMostrador']);
Route::post('/cerrar-mostrador/{id}', [ConsumoController::class, 'CerrarMostrador']);
Route::get('/get-mostrador-consumo-all-cerrado', [ConsumoController::class, 'GetMostradorConsumoAllCerrado']);
Route::match(['get', 'post'], '/delete-detalle-consumo/{detalle}', [ConsumoController::class, 'DeleteDetalleConsumo']);
Route::get('/get-mesa-consumo-no-delete/{id}', [ConsumoController::class, 'GetMesaConsumoNoDelete']);
Route::get('/get-mostrador-consumo-cerrado/{id}', [ConsumoController::class, 'GetMostradorConsumoCerrado']);
Route::post('/registrar-consumo-delivery', [ConsumoController::class, 'RegistrarConsumoDelivery'])->name('registrar-consumo-delivery')->middleware('auth');
Route::get('/get-delivery-preparacion', [ConsumoController::class, 'GetDeliveryPreparacion']);
Route::get('/get-delivery-consumo/{id}', [ConsumoController::class, 'GetDelivryCosumo']);
Route::get('/get-consumo-preparando-delivery/{id}', [ConsumoController::class, 'GetPreparandoDelivery']);
Route::post('/registrar-detalle-consumo-delivery', [ConsumoController::class, 'RegistrarDetalleConsumoDelivery'])->name('registrar-detalle-consumo-mostrador')->middleware('auth');
Route::get('/get-mesa-comanda/{mesa}', [ConsumoController::class, 'GenerarComandaMesa']);

Route::post('/registrar-descuento', [DescuentoConsumoController::class, 'RegistrarDescuento'])->name('registrar-descuento')->middleware('auth');
Route::get('/get-descuento/{id}', [DescuentoConsumoController::class, 'GetDescuento'])->name('get-descuento')->middleware('auth');
Route::delete('/eliminar-descuento/{id}', [DescuentoConsumoController::class, 'eliminarDescuento']);

Route::get('/get-repartidor', [RepartidoreController::class, 'GetRepartidor']);


Route::get('/get-list-print', [ConfiguracionController::class, 'listarImpresoras']);
Route::post('/registrar-impresora', [ConfiguracionController::class, 'RegistrarImpresora'])->name('registrar-impresora')->middleware('auth');
Route::delete('/eliminar-impresora/{id}', [ConfiguracionController::class, 'eliminarImpresora'])->name('eliminar.impresora');
Route::get('/obtener-count-impresoras', [ConfiguracionController::class, 'obtenerCountImpresoras']);
Route::get('/ImpresionDate/{id}', [ConfiguracionController::class, 'ImpresionDate']);
Route::get('/generar-pdf', [ConfiguracionController::class, 'generarPDF']);
Route::get('/print-name', [ConfiguracionController::class, 'PrintName']);
