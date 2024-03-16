<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/mivista', [EmpresaController::class, 'vista'])->name('admin.index')->middleware('auth');
Route::get('/mivista1', [EmpresaController::class, 'vista1'])->name('admin.index1')->middleware('auth');
Route::get('/mivista2', [EmpresaController::class, 'vista2'])->name('admin.index2')->middleware('auth');
Route::get('/mivista3', [EmpresaController::class, 'vista3'])->name('admin.index3')->middleware('auth');
Route::get('/mivista4', [EmpresaController::class, 'vista4'])->name('admin.index4')->middleware('auth');
Route::get('/get-user-login', [EmpresaController::class, 'GetUserLogin']);
Route::get('/ConfiguracionImpresora', [EmpresaController::class, 'ConfigImpresora'])->name('admin.ConfiguracionImpresora')->middleware('auth');
