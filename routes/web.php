<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\PagoController;

// Redirigir la raíz al listado de clientes
Route::get('/', function () {
    return redirect()->route('clientes.index');
});

// Rutas de recursos para los 3 módulos
Route::resource('clientes', ClienteController::class);
Route::resource('creditos', CreditoController::class);
Route::resource('pagos', PagoController::class);

// Ruta adicional para comprobante de pago
Route::get('/pagos/{pago}/comprobante', [PagoController::class, 'comprobante'])
    ->name('pagos.comprobante');