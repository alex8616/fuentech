<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\HostalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinLoginController;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\RepartidoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\Booking\BookingReservaController;
use App\Http\Controllers\Booking\BookingDisponibilidadController;
use App\Http\Controllers\Booking\BookingConsultaController;

Route::get('/pin-login', [PinLoginController::class, 'showLoginForm'])->name('pin.login.form');
Route::post('/pin-login', [PinLoginController::class, 'login'])->name('pin.login');


/*Para Login*/
/*Route::get('/', function () {
    return redirect()->route('login');
});*/

/*Para PIN*/
Route::get('/', function () {
    return redirect()->route('pin.login');
});

Route::middleware([
    'auth:sanctum', 
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/Restaurante', function () {
        return view('Restaurante');
    })->name('Restaurante');
});

Route::get('/Restaurante', [EmpresaController::class, 'Restaurante'])->name('admin.Restaurante')->middleware('auth');
Route::get('/Ventas', [EmpresaController::class, 'Ventas'])->name('admin.Ventas')->middleware('auth');
Route::get('/Gastos', [EmpresaController::class, 'Gastos'])->name('admin.Gastos')->middleware('auth');
Route::get('/Clientes', [EmpresaController::class, 'Clientes'])->name('admin.Clientes')->middleware('auth');
Route::get('/Productos', [EmpresaController::class, 'Productos'])->name('admin.Productos')->middleware('auth');
Route::get('/Proveedores', [EmpresaController::class, 'Proveedores'])->name('admin.Proveedores')->middleware('auth');
Route::get('/Indicadores', [EmpresaController::class, 'Indicadores'])->name('admin.Indicadores')->middleware('auth');
Route::get('/Menu', [EmpresaController::class, 'MenuDigital'])->name('admin.menu.online')->middleware('auth');
Route::get('/get-user-login', [EmpresaController::class, 'GetUserLogin']);
Route::get('/ConfiguracionImpresora', [ConfiguracionController::class, 'ConfigImpresora'])->name('admin.ConfiguracionImpresora')->middleware('auth');

Route::get('/Ambientes', [AmbienteController::class, 'Ambientes'])->name('admin.ambiente.ambientes')->middleware('auth');

Route::get('/Usuarios', [UsuarioController::class, 'Usuarios'])->name('admin.user.usuarios')->middleware('auth');

Route::get('/Kardex', [EmpresaController::class, 'Kardex'])->name('admin.kardex.Kardex')->middleware('auth');

//hostal
Route::get('/Hostal', [HostalController::class, 'Hostal'])->name('admin.Hostal.Hostal')->middleware('auth');
Route::get('/Salones', [HostalController::class, 'Salones'])->name('admin.Hostal.Salones')->middleware('auth');
Route::get('/Huespedes', [HostalController::class, 'Huespedes'])->name('admin.Hostal.Huespedes')->middleware('auth');
Route::get('/Inventario', [HostalController::class, 'Inventario'])->name('admin.Hostal.Inventario')->middleware('auth');
Route::get('/MapaLugares', [HostalController::class, 'MapaLugares'])->name('admin.Hostal.MapaLugares');
Route::get('/Map-Lugares-Turisticos', [HostalController::class, 'ViewMapaLugares'])->name('admin.Hostal.RegistrarMapaLugares')->middleware('auth');
Route::get('/perfil/{id}', [UserController::class, 'perfil'])->name('perfil.show');
Route::get('/perfilasistencia/{id}', [UserController::class, 'perfilasistencia'])->name('perfilasistencia.show');
Route::get('/filtrar-datos-asistencia-user', [UserController::class, 'perfilasistencia']);

/*Control de asistencia inicio*/
Route::get('/Personal', [PersonaController::class, 'index'])->name('admin.personal.personal')->middleware('auth');
Route::get('/get-personal', [PersonaController::class, 'GetPersonal']);
Route::get('/get-personal-seleccionado/{id}', [PersonaController::class, 'GetSeleccionadoPersonal']);
Route::post('/actualizar-personal', [PersonaController::class, 'ActualizarPersonal']);

Route::post('personal.store', [PersonaController::class, 'store'])->name('admin.personal.store')->middleware('auth');
Route::get('personal/edit/{id}', [PersonaController::class, 'edit'])->name('personal.edit')->middleware('auth');
Route::put('updatepersonal/{id}', [PersonaController::class, 'updatepersonal'])->name('updatepersonal')->middleware('auth');
Route::delete('/personal/{id}', [PersonaController::class, 'eliminar'])->name('eliminarpersonal')->middleware('auth');
Route::get('personal/data', [PersonaController::class, 'data'])->name('personal.data');
Route::get('personal.AsistenciaHoja', [PersonaController::class, 'AsistenciaHoja'])->name('admin.personal.AsistenciaHoja')->middleware('auth');
Route::get('/Asistencia_Biometrico', [PersonaController::class, 'Biometrico']);
Route::get('admin.personal.full', [PersonaController::class, 'RegisterPersonalFull'])->name('admin.personal.full');

Route::get('/Asistencia_Biometrico_Personal', [PersonaController::class, 'PersonalBiometrico']);
Route::post('/Registrar-personal', [PersonaController::class, 'RegistrarPersonal']);
Route::get('/imagen-cliente', [PersonaController::class, 'ImagenCliente']);
Route::get('/carpetas-usuarios', [PersonaController::class, 'obtenerCarpetasUsuarios']);
Route::get('/storage/biometrico/{carpeta}', [PersonaController::class, 'obtenerImagenesCarpeta']);
Route::get('/get-descriptors', [PersonaController::class, 'GetDescriptors']);
Route::post('/Registrar-Ingreso-Salida', [PersonaController::class, 'RegistrarIngresoSalida']);
Route::get('/get-registros', [PersonaController::class, 'GetRegistros']);
Route::post('/Hora-Extra', [PersonaController::class, 'RegistrarHoraExtra']);
Route::get('/get-pin', [PersonaController::class, 'GetPin']);
Route::post('/Registrar-Ingreso-Salida-Pin', [PersonaController::class, 'RegistrarIngresoSalidaPin']);
Route::get('/Horarios-Asistencia', [PersonaController::class, 'HorarioAsistencia'])->name('admin.personal.HorarioAsistencia');
Route::post('/Registrar-por-Pin', [PersonaController::class, 'RegistrarPorPin']);
Route::get('/detalle-registro-por-Pin/{id}', [PersonaController::class, 'DetalleRegistroPorPin']);
Route::post('/actulizar-informacion-persona-detalle', [PersonaController::class, 'ActualicarInformacionPersona']);
Route::post('/eliminar-persona-detalle', [PersonaController::class, 'EliminarInformacionPersona']);
/*Control de asistencia fin*/


Route::get('/image-upload', [RepartidoreController::class, 'index']);
Route::post('/analyze-image', [RepartidoreController::class, 'analyzeImage']);

Route::get('/chat', [RepartidoreController::class, 'index']);
Route::post('/chat/send', [RepartidoreController::class, 'sendMessage']);
Route::post('/extract-text', [RepartidoreController::class, 'extractText']);

Route::get('/ocr', function () {
    return view('ocr');
});
Route::get('/upload', [RepartidoreController::class, 'showUploadForm']);
Route::post('/upload', [RepartidoreController::class, 'upload']);


Route::get('/hora', [ConfiguracionController::class, 'GetHora']);
Route::post('/crear-backup', [BackupController::class, 'crearBackup'])->name('crear.backup');
Route::get('/pruebas', [BackupController::class, 'Pruebas'])->name('admin.Pruebas');
Route::post('/enviar-backup', [BackupController::class, 'enviarBackupPorCorreo'])->name('enviar.backup');


Route::get('/alcira', [EnvioController::class, 'alcira']);
Route::get('/envios', [EnvioController::class, 'index']);
Route::post('/envios', [EnvioController::class, 'store']);
Route::get('/envios/pdf/{id}', [EnvioController::class, 'generarPDF'])->name('envios.pdf');
Route::get('/envios/lista', [EnvioController::class, 'lista'])->name('envios.lista');
Route::get('/envio-get/{id}', [EnvioController::class, 'GetEnvioSelect']);
Route::put('/envio-update/{id}', [EnvioController::class, 'updateEnvio']);
Route::get('/envios/pdf-reporte', [EnvioController::class, 'pdfReporte']);


Route::get('/q/info', function(){
    return view('qr.info');
});

Route::get('/reservas-tukos', [BookingConsultaController::class, 'PagePrincipal']);
Route::get('/buscar', [BookingConsultaController::class, 'BuscarDisponibilidad']);

Route::get('/admin/calendario-disponibilidad', [BookingDisponibilidadController::class,'index'])->name('admin.calendario-disponibilidad');
Route::post('/admin/calendario-actualizar', [BookingDisponibilidadController::class,'update']);