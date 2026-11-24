<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\FallaController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('equipos', EquipoController::class);

    Route::get('/fallas', [FallaController::class, 'index'])->name('fallas.index');
    Route::get('/fallas/crear', [FallaController::class, 'create'])->name('fallas.create');
    Route::post('/fallas', [FallaController::class, 'store'])->name('fallas.store');
    Route::get('/fallas/{falla}/atender', [FallaController::class, 'atender'])->name('fallas.atender');
    Route::post('/fallas/{falla}/atender', [FallaController::class, 'registrarAtencion'])->name('fallas.registrar');

    Route::get('/mantenimientos', [MantenimientoController::class, 'index'])->name('mantenimientos.index');
    Route::get('/mantenimientos/programar', [MantenimientoController::class, 'create'])->name('mantenimientos.create');
    Route::post('/mantenimientos', [MantenimientoController::class, 'store'])->name('mantenimientos.store');
    Route::get('/mantenimientos/{mantenimiento}/completar', [MantenimientoController::class, 'completar'])->name('mantenimientos.completar');
    Route::post('/mantenimientos/{mantenimiento}/completar', [MantenimientoController::class, 'registrarCierre'])->name('mantenimientos.cierre');
    Route::post('/mantenimientos/{mantenimiento}/cancelar', [MantenimientoController::class, 'cancelar'])->name('mantenimientos.cancelar');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/csv', [ReporteController::class, 'csv'])->name('reportes.csv');
});
