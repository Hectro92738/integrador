<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VentasController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// muestra view de login 

Route::get('/', function () {
    return view('login');
});

// envio parametros de login 

Route::post('/validar-login',  [AuthController::class, 'validarLogin'])->name('validarLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/detalle-venta/{id}', [VentasController::class, 'detalleVenta'])->name('detalleVenta');
    Route::get('/status-articulo/{id}', [VentasController::class, 'statusArticulo'])->name('statusArticulo');
    Route::post('/insert-venta', [VentasController::class, 'insertVenta'])->name('insertVenta');

    // rutas para vender, y el inicio
    Route::get('/inicio', [ViewController::class, 'inicio'])->name('inicio');
    Route::get('/vender', [ViewController::class, 'vender'])->name('vender');
    Route::get('/ventas', [ViewController::class, 'ventas'])->name('ventas');


    
});

// .......... ADMIN ..........

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/gestion-productos', [ViewController::class, 'gestionProductos'])->name('gestionProductos');

    Route::get('/view-ingresos', [ViewController::class, 'viewingresos'])->name('ingresos.view');
    
});