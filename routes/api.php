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

Route::get('/get-categorias', [CategoriaController::class, 'GetCategoria']);
Route::get('/get-subcategorias/{id}', [CategoriaController::class, 'GetSubCategoria']);
Route::post('/registrar-categoria', [CategoriaController::class, 'RegistrarCategoria'])->middleware('auth');
Route::post('/registrar-subcategoria', [CategoriaController::class, 'RegistrarSubCategoria'])->middleware('auth');
Route::get('/get-categoria-seleccionado/{categoria}', [CategoriaController::class, 'GetCategoriaSeleccionado']);
Route::get('/get-subcategoria-seleccionado/{subcategoria}', [CategoriaController::class, 'GetSubCategoriaSeleccionado']);
Route::post('/actualizar-categoria', [CategoriaController::class, 'ActualizarCategoria']);

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

Route::post('/registrar-descuento', [DescuentoConsumoController::class, 'RegistrarDescuento'])->name('registrar-descuento')->middleware('auth');
Route::get('/get-descuento/{id}', [DescuentoConsumoController::class, 'GetDescuento'])->name('get-descuento')->middleware('auth');
Route::delete('/eliminar-descuento/{id}', [DescuentoConsumoController::class, 'eliminarDescuento']);

Route::get('/get-repartidor', [RepartidoreController::class, 'GetRepartidor']);


Route::get('/get-list-print', [ConfiguracionController::class, 'listarImpresoras']);
Route::post('/registrar-impresora', [ConfiguracionController::class, 'RegistrarImpresora'])->name('registrar-impresora')->middleware('auth');
Route::delete('/eliminar-impresora/{id}', [ConfiguracionController::class, 'eliminarImpresora'])->name('eliminar.impresora');
Route::get('/obtener-count-impresoras', [ConfiguracionController::class, 'obtenerCountImpresoras']);
Route::get('/ImpresionDate/{id}', [ConfiguracionController::class, 'ImpresionDate']);