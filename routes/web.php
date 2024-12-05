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


// .......... ENCARGADO ..........

Route::middleware(['role:encargado, admin', 'auth'])->group(function () {
    Route::get('/view-personas', [ViewController::class, 'viewpersonas'])->name('viewpersonas');

    // Crear una nueva persona
    Route::get('/personas/create', [PersonasController::class, 'create'])->name('personas.create');
    Route::post('/personas/store', [PersonasController::class, 'store'])->name('personas.store');

    // Editar una persona
    Route::get('/personas/edit/{id}', [PersonasController::class, 'edit'])->name('personas.edit');
    Route::put('/personas/update/{id}', [PersonasController::class, 'update'])->name('personas.update');

    // Eliminar una persona
    Route::delete('/personas/delete/{id}', [PersonasController::class, 'destroy'])->name('personas.destroy');

    // Rutas para editar y agregar artículos
    Route::get('/articulos/create', [ArticuloController::class, 'create'])->name('articulos.create');
    Route::post('/articulos/store', [ArticuloController::class, 'store'])->name('articulos.store');
    Route::get('/articulos/edit/{id}', [ArticuloController::class, 'edit'])->name('articulos.edit');
    Route::put('/articulos/update/{id}', [ArticuloController::class, 'update'])->name('articulos.update');
});