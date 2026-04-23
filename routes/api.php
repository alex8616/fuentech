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
use App\Http\Controllers\VentaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ArqueoCajaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CajaRestauranteController;
use App\Http\Controllers\CajaTarjetaController;
use App\Http\Controllers\CajaDepositoController;
use App\Http\Controllers\CajaDolarController;
use App\Http\Controllers\PersonaController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-pruebas', [ProductoController::class, 'GetPrueba']);


Route::get('/get-productos', [ProductoController::class, 'GetProducto']);
Route::get('/get-productos-categoria/{categoria}', [ProductoController::class, 'GetProductoCategoria']);
Route::get('/get-productos-seleccionado/{producto}', [ProductoController::class, 'GetProductoSeleccionado']);
Route::post('/update-productos-seleccionado', [ProductoController::class, 'UpdateProductoSeleccionado']);
Route::get('/get-productos-favorite', [ProductoController::class, 'GetProductoFavorite']);
Route::get('/get-productos-favorite-stock', [ProductoController::class, 'GetProductoFavoriteStock']);

Route::post('/registrar-producto', [ProductoController::class, 'RegistrarProducto'])->middleware('auth');
Route::post('/verificar-nombre-producto', [ProductoController::class, 'verificarNombreProducto']);
Route::post('/verificar-nombre-similar', [ProductoController::class, 'verificarNombreSimilar']);

Route::get('/producto-register-true/{producto}', [ProductoController::class, 'ProductoEstadoTrue']);
Route::get('/producto-register-false/{producto}', [ProductoController::class, 'ProductoEstadoFalse']);
Route::post('/actualizar-producto', [ProductoController::class, 'ActualizarProducto']);
Route::get('/get-productos-subcategoria/{subcategoria}', [ProductoController::class, 'GetProductoSubCategoria']);
Route::get('/get-productos-stock', [ProductoController::class, 'GetProductoStock']);
Route::post('/actualizar-producto-stock', [ProductoController::class, 'ActualizarProductoStock']);
Route::get('/get-productos-autocompleta', [ProductoController::class, 'getProductosAutoCompleta']);
Route::post('/import-productos', [ProductoController::class, 'import'])->name('productos.import');
Route::get('/producto-modificador-update/{producto}', [ProductoController::class, 'ProductoModificador']);
Route::get('/eliminar-grupomodificador', [ProductoController::class, 'EliminarDetalleReceta']);
Route::get('/get-all-proveedor/{proveedor}', [ProductoController::class, 'GetallProveedor']);
Route::get('/get-all-data', [ProductoController::class, 'GetAllData']);
Route::get('/get-all-disponibles', [ProductoController::class, 'GetAllDisponible']);
Route::get('/get-all-pocostock', [ProductoController::class, 'GetAllPocoStock']);
Route::get('/get-all-agotados', [ProductoController::class, 'GetAllAgotadoStock']);
Route::get('/get-all-sinstock', [ProductoController::class, 'GetAllSinStockDefinido']);
Route::get('/get-movimientos-stock', [ProductoController::class, 'GetMovimientos']);
Route::get('/get-movimiento-seleccionado/{id}', [ProductoController::class, 'GetMovimientoSeleccionado']);
Route::get('/get-movimientos-cantidad', [ProductoController::class, 'GetMovimientosCantidad']);
Route::get('/filtrar-datos', [ProductoController::class, 'filtrarDatos']);
Route::get('/get-venta-seleccionado/{id}', [ConsumoController::class, 'GetVentaSeleccionado']);
Route::get('/get-productos-seleccionado-stock/{producto}', [ProductoController::class, 'GetProductoSeleccionadoStock']);
Route::post('/registrar-ingreso-stock', [ProductoController::class, 'RegistrarIngresoStock']);
Route::post('/registrar-faltante-stock', [ProductoController::class, 'RegistrarFaltanteStock']);
Route::get('/get-detallestock-seleccionado/{id}', [ProductoController::class, 'GetDetalleStockSeleccionado']);
Route::get('/get-kardex-ultimo-registros', [ProductoController::class, 'GetKardexUltimoRegistro']);
Route::post('/registrar-solucion-kardex', [ProductoController::class, 'RegistrarSolucionKardex']);
Route::get('/genrar-pdf-pendiente-kardex/{id}', [ProductoController::class, 'GetGenerarPdfKardex']);

Route::get('/get-categorias', [CategoriaController::class, 'GetCategoria']);
Route::get('/get-subcategorias/{id}', [CategoriaController::class, 'GetSubCategoria']);
Route::post('/registrar-categoria', [CategoriaController::class, 'RegistrarCategoria'])->middleware('auth');
Route::post('/registrar-subcategoria', [CategoriaController::class, 'RegistrarSubCategoria'])->middleware('auth');
Route::get('/get-categoria-seleccionado/{categoria}', [CategoriaController::class, 'GetCategoriaSeleccionado']);
Route::get('/get-subcategoria-seleccionado/{subcategoria}', [CategoriaController::class, 'GetSubCategoriaSeleccionado']);
Route::post('/actualizar-categoria', [CategoriaController::class, 'ActualizarCategoria']);
Route::post('/categorias/actualizar-estado', [CategoriaController::class, 'actualizarEstado']);
Route::get('/get-categoria-menu-online', [CategoriaController::class, 'GetPorCategoriaMenuOnline']);

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
Route::post('/import-ingredientes', [IngredienteController::class, 'import'])->name('ingredientes.import');
Route::get('/get-ingredientes-stock', [IngredienteController::class, 'GetIngredienteStock']);
Route::get('/get-ingredientes-seleccionado/{ingrediente}', [IngredienteController::class, 'GetIngredienteSeleccionado']);
Route::post('/actualizar-ingrediente-stock', [IngredienteController::class, 'ActualizarIngredienteStock']);
///Route::get('/get-ingredientes-proveedor/{proveedor}', [IngredienteController::class, 'GetIngredienteProveedor']);


Route::post('/registrar-receta', [RecetaController::class, 'RegistrarReceta'])->middleware('auth');

Route::post('/registrar-modificadore', [ModificadoreController::class, 'RegistrarModificadore'])->middleware('auth');
Route::get('/get-modificadores', [ModificadoreController::class, 'GetModificadores']);
Route::get('/get-modificador-seleccionado/{modificador}', [ModificadoreController::class, 'GetModificadorSeleccionado']);
Route::post('/actualizar-modificador', [ModificadoreController::class, 'ActualizarModificador']);
Route::post('/registrar-detalle-modificador', [ModificadoreController::class, 'RegistrarDetalleModificador'])->middleware('auth');
Route::post('/actualizar-detallemodificar', [ModificadoreController::class, 'ActualizarDetalleModificador']);
Route::post('/eliminar-detallemodificador', [ModificadoreController::class, 'EliminarDetalleModificador']);
Route::get('/get-producto-asociado/{id}', [ModificadoreController::class, 'GetProductoAsociado']);
Route::post('/actualizar-modificador-consumo', [ModificadoreController::class, 'ActualizarModificadorConsumo']);
Route::post('/eliminar-modificador-consumo', [ModificadoreController::class, 'EliminarModificadorConsumo']);
Route::post('/registrar-modificador-consumo', [ModificadoreController::class, 'RegistrarModificadorConsumo']);

Route::post('/registrar-modificador-consumo-mostrador', [ModificadoreController::class, 'RegistrarModificadorConsumoMostrador']);
Route::get('/get-modificador-seleccionado-mostrador/{modificador}', [ModificadoreController::class, 'GetModificadorSeleccionadoMostrador']);
Route::post('/actualizar-modificador-consumo-mostrador', [ModificadoreController::class, 'ActualizarModificadorConsumoMostrador']);
Route::post('/eliminar-modificador-consumo-mostrador', [ModificadoreController::class, 'EliminarModificadorConsumoMostrador']);

Route::get('/get-cocinas', [CocinaController::class, 'GetCocina']);

Route::get('/get-ambientes', [AmbienteController::class, 'GetAmbiente']);
Route::get('/get-ambiente-seleccionado/{ambiente}', [AmbienteController::class, 'GetAmbienteSeleccionado']);

Route::post('/registrar-mesa', [AmbienteMesaController::class, 'registrarMesa'])->name('registrar-mesa')->middleware('auth');
Route::get('/get-mesa-editar/{mesa}', [AmbienteMesaController::class, 'GetMesaSeleccionado']);
Route::post('/actualizar-posicion-mesa', [AmbienteMesaController::class, 'actualizarPosicion'])->name('mesa.actualizar_posicion');
Route::post('/actualizar-nombre-mesa', [AmbienteMesaController::class, 'actualizarNombreMesa'])->name('mesa.actualizar_nombremesa');


Route::get('/get-clientes', [ClienteController::class, 'GetCliente']);
Route::get('/Search-Client', [ClienteController::class, 'SearchClient']);
Route::post('/registrar-cliente', [ClienteController::class, 'RegistrarCliente'])->middleware('auth');
Route::get('/get-cliente-seleccionado/{id}', [ClienteController::class, 'GetClienteSeleccionado']);
Route::get('/get-clientes-list', [ClienteController::class, 'GetClienteList']);
Route::get('/get-cuentas-list', [ClienteController::class, 'GetCuentaList']);
Route::post('/registrar-cuenta-corriente', [ClienteController::class, 'RegistrarCuentaCorrienta'])->middleware('auth');
Route::get('/get-cuenta-seleccionado/{id}', [ClienteController::class, 'GetCuentaSeleccionado']);
Route::get('/filtrar-datos-cuenta', [ClienteController::class, 'FiltrarDatosCuenta']);
Route::post('/delete-cuenta', [ClienteController::class, 'DeleteCuenta'])->name('delete-cuenta')->middleware('auth');

Route::get('/get-proveedores-list', [ProveedoreController::class, 'GetProveedorList']);
Route::get('/get-proveedores-list-select', [ProveedoreController::class, 'GetProveedorListSelect']);
Route::get('/get-proveedor', [ProveedoreController::class, 'GetProveedor']);
Route::get('/get-proveedor-seleccionado/{id}', [ProveedoreController::class, 'GetProveedorSeleccionado']);
Route::post('/registrar-proveedor', [ProveedoreController::class, 'RegistrarProveedor'])->middleware('auth');
Route::post('/registrar-cuenta-proveedor', [ProveedoreController::class, 'RegistrarCuentaProveedor'])->middleware('auth');
Route::get('/filtrar-datos-cuenta-proveedor', [ProveedoreController::class, 'FiltrarDatosCuentaProveedor']);
Route::get('/get-cuenta-seleccionado-proveedor/{id}', [ProveedoreController::class, 'GetCuentaSeleccionadoProveedor']);
Route::post('/delete-cuenta-proveedor', [ProveedoreController::class, 'DeleteCuentaProveedor'])->name('delete-cuenta-proveedor')->middleware('auth');

Route::get('/get-camarero', [CamareroController::class, 'GetCamarero']);

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
Route::get('/get-mesa-comanda/{mesa}', [ConsumoController::class, 'GenerarComandaMesa']);
Route::get('/get-mostrador-comanda/{consumo}', [ConsumoController::class, 'GenerarComandaMostrador']);
Route::get('/get-delivery-preparando/{id}', [ConsumoController::class, 'GenerarComandaDeliveryPreparando']);

Route::post('/guardar-costo-envio/{id}', [ConsumoController::class, 'guardarCostoEnvio']);
Route::get('/get-delivery-entregar', [ConsumoController::class, 'GetDeliveryEntregar']);
Route::get('/get-delivery-enviar', [ConsumoController::class, 'GetDeliveryEnviar']);
Route::get('/get-delivery-completo', [ConsumoController::class, 'GetDeliveryCompleto']);
Route::get('/registrar-cortesia-detalle-consumo/{id}', [ConsumoController::class, 'RegistrarCortesiaDetalleConsumo']);

Route::post('/registrar-servicio-pedido', [ConsumoController::class, 'RegistrarServicioPedido']);
Route::get('/filtrar-datos-get-servicio-pedido', [ConsumoController::class, 'FiltrarGetServicioPedido']);
Route::get('/filtrar-datos-get-venta-suelta', [ConsumoController::class, 'FiltrarGetVentaSuelta']);

Route::post('/registrar-venta-suelta', [ConsumoController::class, 'RegistrarVentaSuelta']);


Route::post('/registrar-descuento', [DescuentoConsumoController::class, 'RegistrarDescuento'])->name('registrar-descuento')->middleware('auth');
Route::get('/get-descuento/{id}', [DescuentoConsumoController::class, 'GetDescuento'])->name('get-descuento')->middleware('auth');
Route::delete('/eliminar-descuento/{id}', [DescuentoConsumoController::class, 'eliminarDescuento']);
Route::post('/guardar-pagos-delivery', [DescuentoConsumoController::class, 'guardarPagos']);
Route::get('/get-delivery-pago/{id}', [DescuentoConsumoController::class, 'GetPagosDelivery']);
Route::delete('/delete-pago/{id}', [DescuentoConsumoController::class, 'deletePago']);
Route::get('/estado-entregar/{id}', [DescuentoConsumoController::class, 'EstadoEntregar']);
Route::get('/estado-enviar/{id}', [DescuentoConsumoController::class, 'EstadoEnviar']);
Route::get('/estado-completo/{id}', [DescuentoConsumoController::class, 'EstadoCompleto']);

Route::get('/imprimir-ticket-servicio-venta/{id}', [ConsumoController::class, 'ImprimirTicketServicioVenta']);
Route::get('/imprimir-ticket-mostrador/{id}', [ConsumoController::class, 'ImprimirTicketMostrador']);
Route::get('/imprimir-ticket-ventas-general/{id}', [ConsumoController::class, 'ImprimirTicketVentasGeneral']);
Route::get('/imprimir-ticket-venta-suelta/{id}', [ConsumoController::class, 'ImprimirTicketVentasSuelta']);

Route::post('/registrar-categoria-gastos', [GastoController::class, 'RegistrarCategoriaGasto'])->name('registrar-categoria-gastos')->middleware('auth');
Route::get('/get-categoria-gastos', [GastoController::class, 'GetCategoriaGasto']);
Route::post('/delete-categoria-gasto', [GastoController::class, 'DeleteCategoriaGasto'])->name('delete-categoria-gasto')->middleware('auth');
Route::get('/get-categoria-gasto-seleccionado/{id}', [GastoController::class, 'GetCategoriaGastoSeleccionado']);
Route::post('/registrar-gastos', [GastoController::class, 'RegistrarGasto'])->name('registrar-gastos')->middleware('auth');
Route::get('/filtrar-datos-gasto', [GastoController::class, 'FiltrarDatosGasto']);
Route::get('/get-gasto-seleccionado/{id}', [GastoController::class, 'GetGastoSeleccionado']);
Route::post('/registrar-detalle-gasto', [GastoController::class, 'RegistrarDetalleGasto'])->name('registrar-detalle-gasto')->middleware('auth');
Route::post('/delete-detalle-gasto', [GastoController::class, 'DeleteDetalleGasto'])->name('delete-detalle-gasto')->middleware('auth');

Route::post('/registrar-arqueo-caja', [ArqueoCajaController::class, 'RegistrarArqueoCaja'])->name('registrar-arqueo-caja')->middleware('auth');
Route::get('/evaluar-arqueo-caja', [ArqueoCajaController::class, 'EvaluarArqueoCaja'])->middleware('auth');
Route::get('/filtrar-datos-arqueo', [ArqueoCajaController::class, 'FiltrarDatosArqueo']);
Route::get('/get-arqueo-seleccionado/{id}', [ArqueoCajaController::class, 'GetArqueoSeleccionado']);
Route::post('/cerrar-arqueo-caja', [ArqueoCajaController::class, 'CerrarArqueoCaja'])->name('cerrar-arqueo-caja')->middleware('auth');
Route::post('/delete-arqueo-caja', [ArqueoCajaController::class, 'DeleteArqueoCaja'])->name('delete-arqueo-caja')->middleware('auth');

Route::get('/get-repartidor', [RepartidoreController::class, 'GetRepartidor']);


Route::get('/get-list-print', [ConfiguracionController::class, 'listarImpresoras']);
Route::post('/registrar-impresora', [ConfiguracionController::class, 'RegistrarImpresora'])->name('registrar-impresora')->middleware('auth');
Route::delete('/eliminar-impresora/{id}', [ConfiguracionController::class, 'eliminarImpresora'])->name('eliminar.impresora');
Route::get('/obtener-count-impresoras', [ConfiguracionController::class, 'obtenerCountImpresoras']);
Route::get('/ImpresionDate/{id}', [ConfiguracionController::class, 'ImpresionDate']);
Route::get('/generar-pdf', [ConfiguracionController::class, 'generarPDF']);
Route::get('/print-name', [ConfiguracionController::class, 'PrintName']);

Route::get('/get-users', [VentaController::class, 'GetUser']);
Route::get('/filtrar-datos-ventas', [VentaController::class, 'FiltrarDatosVentas']);
Route::get('/filtrar-datos-ventas-pdf', [VentaController::class, 'FiltrarDatosVentasPdf']);
Route::get('/get-all-consumo', [VentaController::class, 'GetConsumoAll']);
Route::get('/get-ventas-cantidad', [VentaController::class, 'GetVentaCantidad']);


Route::get('/get-movimientoscajas-cantidad', [MovimientoController::class, 'GetMovimientosCajasCantidad']);
Route::get('/get-all-movimientocajas', [MovimientoController::class, 'GetMovimientoCajaAll']);
Route::get('/get-movimientocaja-seleccionado/{id}', [MovimientoController::class, 'GetMovimientoSeleccionado']);
Route::get('/delete-movimientocaja-seleccionado/{id}', [MovimientoController::class, 'DeleteMovimientoSeleccionado']);
Route::post('/registrar-movimientocaja', [MovimientoController::class, 'RegistrarMovimientoCaja'])->middleware('auth');


Route::get('/reporte-get-mesas', [ReporteController::class, 'ReporteMesasGet']);
Route::get('/filtrar-datos-reporte-mesas', [ReporteController::class, 'ReporteFiltrarDatos']);
Route::post('/reporte-mesa-download-pdf', [ReporteController::class, 'ReporteMesaDownloadPdf']);
Route::get('/filtrar-datos-reporte-productos', [ReporteController::class, 'ReporteFiltrarDatosProductos']);
Route::get('/get-turnos', [TurnoController::class, 'GetTurnoAll']);
//Route::get('/get-cambiar-estado-turnos', [TurnoController::class, 'CambiarEstadoTurnos']);

//pruebas xddd
Route::get('/scrape', [ConfiguracionController::class, 'scrape']);

//usuarios
Route::post('/login', [Usercontroller::class, 'login']);
Route::put('/update-consumo/{id}', [ConsumoController::class, 'ActualizarDatos']);
Route::get('/get-consumo', [ConsumoController::class, 'GetConsumoMesaAll']);

Route::middleware('auth')->get('/user', [ConfiguracionController::class, 'getLoggedInUser']);
Route::post('/actualizar-impresora', [ConfiguracionController::class, 'ActualizarImpresora']);
Route::get('/get-print-seleccionado/{id}', [ConfiguracionController::class, 'GetPrintSeleccionado']);

//cajas
Route::get('/get-cajas', [CajaController::class, 'GetCajas']);
Route::post('/registrar-caja', [CajaController::class, 'RegistrarCaja'])->middleware('auth');
Route::get('/get-cajas/{id}', [CajaController::class, 'GetCajasSeleccionado']);
Route::get('/CajaChica/{id}', [CajaController::class, 'CajaChica']);

Route::post('/registrar-novedades', [CajaController::class, 'RegistrarNovedad'])->middleware('auth');
Route::get('/get-libro-novedades', [CajaController::class, 'GetLibroNovedades']);
Route::get('/filtrar-datos-novedades', [CajaController::class, 'FiltrarDatosNovedades']);
Route::get('/get-libro-novedades-select/{id}', [CajaController::class, 'GetLibroNovedadesSelect']);
Route::post('/actualizar-novedades', [CajaController::class, 'ActualizarNovedades']);
Route::get('/filtrar-datos-caja-hostal', [CajaController::class, 'FiltrarCajaHostal']);
Route::get('/get-articulos-caja', [CajaController::class, 'GetArticuloCaja']);
Route::post('/registrar-detalle-hostal', [CajaController::class, 'RegistrarDetalleHostal']);
Route::get('/get-detalle-caja-select/{id}', [CajaController::class, 'GetDetalleCajaSelect']);
Route::post('/cerrar-caja', [CajaController::class, 'CerrarCaja']);
Route::get('/get-detalle-caja-select-edit/{id}', [CajaController::class, 'GetDetalleCajaSelectEdit']);
Route::post('/actualizar-caja-hostal', [CajaController::class, 'ActualizarCajaHostal']);
Route::post('/eliminar-caja-hostal', [CajaController::class, 'EliminarCajaHostal']);

Route::post('/registrar-detalle-restaurante', [CajaRestauranteController::class, 'RegistrarDetalleRestaurante']);
Route::get('/filtrar-datos-caja-restaurante', [CajaRestauranteController::class, 'FiltrarCajaRestaurante']);
Route::post('/actualizar-caja-restaurante', [CajaRestauranteController::class, 'ActualizarCajaRestaurante']);
Route::post('/eliminar-caja-restaurante', [CajaRestauranteController::class, 'EliminarCajaRestaurante']);
Route::get('/get-detalle-caja-restaurante-select/{id}', [CajaRestauranteController::class, 'GetDetalleCajaRestauranteSelect']);
Route::post('/registrar-detalle-tarjeta', [CajaTarjetaController::class, 'RegistrarDetalleTarjeta']);
Route::get('/filtrar-datos-caja-tarjeta', [CajaTarjetaController::class, 'FiltrarCajaTarjeta']);
Route::get('/get-detalle-caja-tarjeta-select/{id}', [CajaTarjetaController::class, 'GetDetalleCajaTarjetaSelect']);
Route::post('/actualizar-caja-tarjeta', [CajaTarjetaController::class, 'ActualizarCajaTarjeta']);
Route::post('/eliminar-caja-tarjeta', [CajaTarjetaController::class, 'EliminarCajaTarjeta']);
Route::post('/registrar-detalle-deposito', [CajaDepositoController::class, 'RegistrarDetalleDeposito']);
Route::get('/filtrar-datos-caja-deposito', [CajaDepositoController::class, 'FiltrarCajaDeposito']);
Route::get('/get-detalle-caja-deposito-select/{id}', [CajaDepositoController::class, 'GetDetalleCajaDepositoSelect']);
Route::post('/actualizar-caja-deposito', [CajaDepositoController::class, 'ActualizarCajaDeposito']);
Route::post('/eliminar-caja-deposito', [CajaDepositoController::class, 'EliminarCajaDeposito']);
Route::post('/registrar-detalle-dolar', [CajaDolarController::class, 'RegistrarDetalleDolar']);
Route::get('/filtrar-datos-caja-dolar', [CajaDolarController::class, 'FiltrarCajaDolar']);
Route::get('/get-detalle-caja-dolar-select/{id}', [CajaDolarController::class, 'GetDetalleCajaDolarSelect']);
Route::post('/actualizar-caja-dolar', [CajaDolarController::class, 'ActualizarCajaDolar']);
Route::post('/eliminar-caja-dolar', [CajaDolarController::class, 'EliminarCajaDolar']);

Route::post('/registrar-detalle-cajachica', [CajaDepositoController::class, 'RegistrarDetalleCajaChica']);
Route::get('/filtrar-datos-caja-chica', [CajaDepositoController::class, 'FiltrarCajaChica']);
Route::get('/get-detalle-caja-chica-select/{id}', [CajaDepositoController::class, 'GetDetalleCajaChicaSelect']);
Route::post('/actualizar-caja-chica', [CajaDepositoController::class, 'ActualizarCajaChica']);
Route::post('/eliminar-caja-chica', [CajaDepositoController::class, 'EliminarCajaChica']);

Route::post('/registrar-ambiente', [AmbienteController::class, 'RegistrarAmbiente']);
Route::post('/actualizar-ambiente', [AmbienteController::class, 'ActualizarAmbiente']);
Route::post('/eliminar-ambiente', [AmbienteController::class, 'EliminarAmbiente']);

Route::post('/registrar-usuario', [UsuarioController::class, 'register'])->name('registrar.usuario');
Route::get('/get-usuario', [UsuarioController::class, 'GetUsuario']);
Route::get('/get-user-seleccionado/{id}', [UsuarioController::class, 'GetSeleccionadoUsuario']);
Route::post('/actualizar-usuario', [UsuarioController::class, 'ActualizarUsuario']);

Route::get('/get-turnos', [TurnoController::class, 'GetTurnos']);
Route::get('/filtrar-datos-kardex', [TurnoController::class, 'filtrarDatosKardex']);
Route::get('/filtrar-datos-exportar-pdf-movimientos', [TurnoController::class, 'filtrarDatosKardexMovimientos']);

Route::get('/get-personas', [PersonaController::class, 'GetPersonas']);
Route::get('/get-personas-activas', [PersonaController::class, 'GetPersonasActivas']);

