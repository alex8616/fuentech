<?php

use App\Http\Controllers\HostalController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\HospedajeHabitacionController;
use App\Http\Controllers\ClienteHostalController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\GrupoHospedajeController;
use App\Http\Controllers\SalonesController;
use App\Http\Controllers\ReporteFullController;
use App\Http\Controllers\LugarTuristicoController;
use App\Http\Controllers\CategoriRecursoController;
use App\Http\Controllers\Booking\BookingReservaController;
use App\Http\Controllers\Booking\BookingDisponibilidadController;
use App\Http\Controllers\Booking\BookingConsultaController;
use App\Http\Controllers\Booking\BookingCalendarioController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/get-habitaciones', [HabitacionController::class, 'GetHabitaciones']);
Route::get('/get-habitaciones-select', [HabitacionController::class, 'GetHabitacionesSelect']);
Route::post('/cambiar-estado-habitacion-hospedaje', [HabitacionController::class, 'CambiarEstadoHabitacionHospedaje']);
Route::post('/cambiar-estado-habitacion-hospedaje-sucio', [HabitacionController::class, 'CambiarEstadoHabitacionHospedajeSucio']);
Route::post('/cambiar-estado-habitacion-hospedaje-mantenimiento-problema', [HabitacionController::class, 'CambiarEstadoHabitacionMantenimientoProblema']);
Route::get('/get-problemas-habitacion/{id}', [HabitacionController::class, 'GetProblemasHabitacion']);
Route::post('/cambiar-estado-habitacion-hospedaje-mantenimiento-solucion', [HabitacionController::class, 'CambiarEstadoHabitacionMantenimientoSolucion']);
Route::post('/cambiar-estado-habitacion-hospedaje-mantenimiento-sucio', [HabitacionController::class, 'CambiarEstadoHabitacionHospedajeMantenimientoSucio']);
Route::get('/get-hospedajes-all', [HabitacionController::class, 'GetHuespedesAll']);
Route::get('/get-habitaciones-ocupadas', [HabitacionController::class, 'GetHabitacionesOcupadas']);
Route::post('/cambiar-consumo-habitacion', [HabitacionController::class, 'CambiarConsumoHabitacion']);
Route::get('/pendiente-habitacion-hospedaje/{id}', [HabitacionController::class, 'PendienteHabitacionHospedaje']);
Route::get('/pendiente-habitacion-hospedaje-get', [HabitacionController::class, 'GetPendienteHabitacionHospedaje']);
Route::get('/pendiente-habitacion-hospedaje-select/{id}', [HabitacionController::class, 'SelectPendienteHabitacionHospedaje']);
Route::post('/concluir-deuda-hospedaje-cerrar/{id}', [HospedajeHabitacionController::class, 'ConcluirDeudaHospedajeCerrar']);
Route::get('/get-habitaciones-libres', [HabitacionController::class, 'GetHabitacionesLibres']);
Route::post('/registrar-cambio-habitacion', [HabitacionController::class, 'RegistrarCambioHabitacion']);


Route::post('/registrar-ocupar-habitacion', [HospedajeHabitacionController::class, 'OcuparHabitacionHospedaje']);
Route::get('/get-habitacion-ocupada/{id}', [HospedajeHabitacionController::class, 'GetHabitacionOcupada']);
Route::post('/update-ocupar-habitacion', [HospedajeHabitacionController::class, 'UpdateHabitacionOcupada']);
Route::post('/agregar-hospedaje-clientes', [HospedajeHabitacionController::class, 'AgregarHospedajeCliente']);
Route::post('/eliminar-detalle-hospedaje-cliente', [HospedajeHabitacionController::class, 'EliminarDetalleHospedajeCliente']);
Route::post('/registrar-servicio-desayuno-hostal', [HospedajeHabitacionController::class, 'RegistrarServicioDesayunoHostal']);
Route::post('/registrar-servicio-lavado-hostal', [HospedajeHabitacionController::class, 'RegistrarServicioLavadoHostal']);
Route::post('/entregar-servicio-lavado', [HospedajeHabitacionController::class, 'EntregarServicioLavadoHostal']);
Route::post('/actualizar-servicio-desayuno-hostal-postenvio', [HospedajeHabitacionController::class, 'ActualizarServicioDesayunoHostal']);
Route::post('/actualizar-servicio-lavado-hostal-postenvio', [HospedajeHabitacionController::class, 'ActualizarServicioLavadoHostal']);
Route::get('/get-consumo-hospedaje/{id}', [HospedajeHabitacionController::class, 'GetConsumoHospedaje']);
Route::post('/registrar-consumo-hospedaje', [HospedajeHabitacionController::class, 'RegistrarConsumoHospedaje'])->middleware('auth');
Route::get('/get-consumo/{id}', [HospedajeHabitacionController::class, 'GetConsumo']);
Route::post('/cerrar-consumo-habitacion-postenvio', [HospedajeHabitacionController::class, 'CerrarConsumoHabitacion'])->middleware('auth');
Route::post('/cerrar-consumo-reserva-salon-postenvio', [HospedajeHabitacionController::class, 'CerrarConsumoReservaSalon'])->middleware('auth');
Route::post('/registrar-detalle-consumo-hospedaje', [HospedajeHabitacionController::class, 'RegistrarDetalleConsumoHospedaje'])->middleware('auth');
Route::post('/registrar-detalle-consumo-reserva-salon', [HospedajeHabitacionController::class, 'RegistrarDetalleConsumoReservaSalon'])->middleware('auth');
Route::delete('/consumo-hospedaje-delete/{id}', [HospedajeHabitacionController::class, 'ConsumoHospedajeDelete']);
Route::get('/get-consumo-select-private/{id}', [HospedajeHabitacionController::class, 'GetConsumoSelectPrivate']);
Route::post('/registrar-adelanto-hospedaje', [HospedajeHabitacionController::class, 'RegistrarAdelantoHospedaje'])->middleware('auth');
Route::post('/registrar-detalle-hostal', [HospedajeHabitacionController::class, 'RegistrarDetalleHospedaje'])->middleware('auth');
Route::post('/concluir-hospedaje-cerrar/{id}', [HospedajeHabitacionController::class, 'ConcluirHospedajeCerrar']);
Route::get('/imprimir-informacion-hospedaje/{id}', [HospedajeHabitacionController::class, 'ImprimirInformacionHospedaje']);
Route::get('/imprimir-servicios-hospedaje/{id}', [HospedajeHabitacionController::class, 'ImprimirServiciosHospedaje']);
Route::get('/imprimir-consumos-hospedaje/{id}', [HospedajeHabitacionController::class, 'ImprimirConsumosHospedaje']);
Route::get('/imprimir-servicio-desayuno/{id}', [HospedajeHabitacionController::class, 'ImprimirServicioDesayuno']);
Route::get('/imprimir-consumo-hospedaje/{id}', [HospedajeHabitacionController::class, 'ImprimirConsumoHospedaje']);
Route::get('/imprimir-informacion-hospedaje-grupo/{id}', [HospedajeHabitacionController::class, 'ImprimirInformacionHospedajeGrupo']);


Route::get('/get-clientes-hostal', [ClienteHostalController::class, 'GetClientesHostal']);
Route::post('/registrar-cliente-hostal', [ClienteHostalController::class, 'RegistrarClienteHostal']);
Route::get('/get-cliente-hostal-seleccionado/{id}', [ClienteHostalController::class, 'GetClienteHostalSeleccionado']);
Route::get('/get-clientes-hostal-paginate', [ClienteHostalController::class, 'GetClienteHostalPaginate']);
Route::get('/get-clientes-salon-paginate', [ClienteHostalController::class, 'GetClienteSalonPaginate']);
Route::get('/get-cliente-salon-seleccionado/{id}', [ClienteHostalController::class, 'GetClienteSalonSeleccionado']);
Route::post('/registrar-cliente-salon', [ClienteHostalController::class, 'RegistrarClienteSalon']);


Route::post('/registrar-reserva-habitacion', [ReservaController::class, 'ReservarHabitacionHospedaje']);
Route::post('/cancelar-reserva-habitacion', [ReservaController::class, 'CancelarReservasHabitacion']);
Route::get('/reservas-habitaciones', [ReservaController::class, 'ReservarHabitaciones']);
Route::get('/filtrar-datos-reservas', [ReservaController::class, 'FiltrarDatosReservas']);
Route::get('/get-reserva-seleccionado/{id}', [ReservaController::class, 'GetReservaSeleccionado']);
Route::post('/registrar-reserva-adelanto', [ReservaController::class, 'RegistrarAdelantoReserva']);
Route::post('/actualizar-reserva-habitacion', [ReservaController::class, 'ActualizarReserva']);
Route::get('/concluir-reserva-habitacion/{id}', [ReservaController::class, 'ConcluirReservaHabitacion']);
Route::get('/get-datos-reservas-habitaciones', [ReservaController::class, 'GetDatosReservasHabitacion']);

Route::post('/registrar-grupo-hospedaje', [GrupoHospedajeController::class, 'RegistrarGrupoHospedaje']);
Route::get('/filtrar-datos-grupos', [GrupoHospedajeController::class, 'FiltrarDatosGrupos']);
Route::get('/get-grupo-seleccionado/{id}', [GrupoHospedajeController::class, 'GetGrupoSeleccionado']);
Route::get('/get-habitaciones-grupo/{id}', [GrupoHospedajeController::class, 'GetHabitacionesGrupoSeleccionado']);
Route::post('/registrar-grupo-habitaciones', [GrupoHospedajeController::class, 'RegistrarGrupoHabitaciones']);
Route::get('/get-habitaciones-disponibles-grupo/{id}', [GrupoHospedajeController::class, 'GetHabitacionesDisponibleGrupo']);
Route::get('/get-hospedaje-grupos/{id}', [GrupoHospedajeController::class, 'GetHospedajeGrupo']);
Route::post('/agregar-hospedaje-cliente-grupo', [GrupoHospedajeController::class, 'AgregarHospedajeClienteGrupo']);
Route::get('/get-clientes-hospedajes/{id}', [GrupoHospedajeController::class, 'GetClienteHospedaje']);
Route::post('/eliminar-detalle-hospedaje-cliente-grupo', [GrupoHospedajeController::class, 'EliminarDetalleHospedajeClienteGrupo']);
Route::post('/eliminar-hospedaje-cliente-grupo', [GrupoHospedajeController::class, 'EliminarHospedajeClienteGrupo']);
Route::post('/registrar-adelanto-grupo', [GrupoHospedajeController::class, 'RegistrarAdelantoGrupo']);
Route::post('/actualizar-hospedaje-grupo', [GrupoHospedajeController::class, 'ActualizarHospedajeGrupo']);
Route::get('/get-grupos-habitaciones', [HabitacionController::class, 'GetGruposHabitaciones']);
Route::get('/get-habitacion-ocupada-grupo/{id}', [GrupoHospedajeController::class, 'GetHabitacionOcupadaGrupo']);
Route::get('/cambiar-estado-grupo/{id}', [GrupoHospedajeController::class, 'CambiarEstadoGrupo']);
Route::get('/get-habitacion-ocupada-grupo-info/{id}', [GrupoHospedajeController::class, 'CambiarEstadoGrupoInfo']);
Route::get('/get-consumo-habitacion-grupo/{id}', [GrupoHospedajeController::class, 'GetConsumoHabitacionGrupo']);
Route::post('/concluir-grupo-hospedaje-finalizar', [GrupoHospedajeController::class, 'FinalizarGrupoHospedaje']);


Route::get('/get-ambiente-salon', [SalonesController::class, 'GetAmbienteSalones']);
Route::post('/registrar-salon-ambiente', [SalonesController::class, 'RegistrarSalonAmbiente']);
Route::get('/get-ambiente-salon-reservas', [SalonesController::class, 'GetAmbienteSalonesReservas']);
Route::post('/registrar-reserva-salon-ambiente', [SalonesController::class, 'RegistrarReservaSalonAmbiente']);
Route::get('/filtrar-datos-reservas-salon', [SalonesController::class, 'FiltrarDatosReservaSalon']);
Route::get('/get-reserva-salon-seleccionado/{id}', [SalonesController::class, 'GetReservaSalonSeleccionado']);
Route::post('/registrar-adelanto-salon', [SalonesController::class, 'RegistrarAdelantoSalon']);
Route::get('/get-clientes-reservas', [SalonesController::class, 'GetClienteReservas']);
Route::get('/get-empresas-reservas', [SalonesController::class, 'GetEmpresaReservas']);
Route::post('/registrar-servicio-data-salon', [SalonesController::class, 'RegistrarServicioDataSalon']);
Route::post('/actualizar-data-salon', [SalonesController::class, 'ActualizarServicioDataSalon']);
Route::post('/delete-detalle-data-salon', [SalonesController::class, 'DeleteServicioDataSalon']);
Route::post('/registrar-consumo-reserva-salon', [SalonesController::class, 'RegistrarConsumoReservaSalon']);
Route::get('/get-consumo-reserva-salon/{id}', [SalonesController::class, 'GetConsumoReservaSalon']);
Route::get('/get-salon-ocupada/{id}', [SalonesController::class, 'GetSalonOcupada']);
Route::get('/concluir-reserva-salon/{id}', [SalonesController::class, 'ConcluirReservaSalon']);
Route::post('/dar-baja-reserva-salon', [SalonesController::class, 'DarBajaReservaSalon']);


Route::get('/full-ventas-get', [ReporteFullController::class, 'FullVentasGet']);
Route::get('/full-ventas-get-pdf', [ReporteFullController::class, 'FullVentasGetPDF'])->name('reporte.ventas.pdf');
Route::get('/full-hostal-get', [ReporteFullController::class, 'FullHostalGet']);
Route::get('/full-hostal-get-pdf', [ReporteFullController::class, 'FullHostalGetPDF'])->name('reporte.hostal.pdf');

Route::get('/get-lugares', [LugarTuristicoController::class, 'GetLugares']);
Route::post('/registrar-lugar-turistico-hostal', [LugarTuristicoController::class, 'RegistrarLugaresTuristicos']);
Route::get('/get-lugares-turisticos-hostal', [LugarTuristicoController::class, 'GetFullLugares']);
Route::get('/get-lugares-seleccionado/{id}', [LugarTuristicoController::class, 'GetSeleccionadoLugares']);
Route::post('/actualizar-lugar-turistico-hostal', [LugarTuristicoController::class, 'ActualizarLugaresTuristicos']);


Route::post('/registrar-categoria-recurso', [CategoriRecursoController::class, 'RegistrarCategoriaRecurso']);
Route::get('/get-categoria-recurso', [CategoriRecursoController::class, 'GetCategoriaRecurso']);
Route::get('/get-categoria-recurso-seleccionado/{id}', [CategoriRecursoController::class, 'GetSeleccionadoCategoriaRecurso']);
Route::get('/get-categoria-recurso-select', [CategoriRecursoController::class, 'GetCategoriaRecursoSelect']);
Route::post('/registrar-articulo-recurso', [CategoriRecursoController::class, 'RegistrarArticuloRecurso']);
Route::get('/get-articulo-recurso', [CategoriRecursoController::class, 'GetArticuloRecurso']);
Route::get('/get-articulo-recurso-seleccionado/{id}', [CategoriRecursoController::class, 'GetSeleccionadoArticuloRecurso']);
Route::post('/eliminar-imagen', [CategoriRecursoController::class, 'eliminarImagen']);
Route::post('/articulo/{id}/actualizar-imagen', [CategoriRecursoController::class, 'actualizarImagen'])->name('articulo.actualizarImagen');
Route::post('/actualizar-articulo-recurso', [CategoriRecursoController::class, 'ActualizarArticuloRecurso']);
Route::post('/eliminar-recurso-inventario', [CategoriRecursoController::class, 'eliminarRecurso']);

Route::post('/registrar-ingreso-inventario', [CategoriRecursoController::class, 'RegistrarIngresoInventario']);
Route::post('/registrar-salida-inventario', [CategoriRecursoController::class, 'RegistrarSalidaInventario']);
Route::get('/get-filtro-articulos', [CategoriRecursoController::class, 'GetFiltroArticulos']);
Route::get('/get-filtro-articulos-PDF', [CategoriRecursoController::class, 'GetFiltroArticulosPDF']);
Route::get('/get-filtro-articulos-PDF-completo', [CategoriRecursoController::class, 'GetFiltroArticulosPDFCompleto']);

/* BOOKING */

Route::post('/booking/buscar', [BookingConsultaController::class, 'buscar']);
Route::get('/admin/calendario-data-info',[BookingCalendarioController::class,'data']);
Route::post('/admin/update-calendario',[BookingCalendarioController::class,'update']);

Route::get('/admin/calendario-data', [BookingCalendarioController::class, 'calendarioData']);
Route::post('/admin/update-calendario', [BookingCalendarioController::class, 'updateCalendario']);
Route::post('/admin/update-precio-rango', [BookingCalendarioController::class, 'updateMasivoCalendario']);
Route::post('/admin/update-cantidad-rango', [BookingCalendarioController::class, 'updateMasivoCantidad']);
Route::post('/admin/update-cerrar-dia',[BookingCalendarioController::class,'updateCerrarDia']);
Route::get('/disponibilidad', [BookingConsultaController::class, 'disponibilidad']);
Route::post('/reserva-habitacion-booking', [BookingConsultaController::class, 'EnviarReserva']);
Route::get('/reserva/estado/{codigo}', [BookingConsultaController::class, 'verEstado']);