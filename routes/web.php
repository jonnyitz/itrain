<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\GastoProyectoController;
use App\Http\Controllers\GastosGeneralesController;
use App\Http\Controllers\RecibosController;
use App\Http\Controllers\ProyectoAjustesController;
use App\Http\Controllers\ManzanaController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\ReporteVentasController;
use App\Http\Controllers\ReporteFinancieroController;
use App\Http\Controllers\ReporteLotesController;
use App\Http\Controllers\ReporteClientesController;



// Ruta de inicio por defecto que redirige al login
Route::get('/', function () {
    return view('login');
});

// Rutas para autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta del dashboard, protegida por el middleware 'auth'
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Ruta modificada para 'inicio', aceptando un parámetro opcional 'id' para el proyecto
Route::get('/inicio/{id?}', [InicioController::class, 'index'])->name('inicio')->middleware('auth');

// Rutas para la gestión de proyectos
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos');
Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
Route::get('/proyectos/filtrar', [ProyectoController::class, 'filtrar'])->name('proyectos.filtrar');

//contactos 
Route::get('/contactos', [ContactoController::class, 'index'])->name('contactos');
Route::post('/contactos', [ContactoController::class, 'store'])->name('contactos.store');
Route::put('/contactos/{id}', [ContactoController::class, 'update'])->name('contactos.update');
Route::get('/getContactos', [ContactoController::class, 'getContactos'])->name('getContactos');
Route::delete('/contactos/{id}', [ContactoController::class, 'destroy'])->name('contactos.destroy');
Route::get('/exportar-contactos', [ContactoController::class, 'exportToExcel'])->name('contactos.export');


// Rutas para el controlador de Ventas
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas'); // Muestra la lista de ventas
Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store'); // Almacena una nueva venta
Route::put('/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update');
Route::get('/ventas/{venta}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
Route::get('/ventas/{ventaId}/pagare', [VentaController::class, 'generarPagare'])->name('ventas.pagare');


// routes/web.php
Route::get('/creditos', [CreditoController::class, 'index'])->name('creditos');

//cuotas
Route::resource('cuotas', CuotaController::class);
// Ruta para almacenar una nueva cuota
Route::post('/cuotas', [CuotaController::class, 'store'])->name('cuotas.store');

Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones');
Route::post('/cotizaciones', [CotizacionController::class, 'store'])->name('cotizaciones.store');
// Ruta para mostrar las cotizaciones
Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones.index');





Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::get('/reservas/{id}/edit', [ReservaController::class, 'edit'])->name('reservas.edit');
Route::put('/reservas/{id}', [ReservaController::class, 'update'])->name('reservas.update');
Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');




Route::get('/conceptos', [ConceptoController::class, 'index'])->name('conceptos');
Route::post('/conceptos', [ConceptoController::class, 'store'])->name('conceptos.store');
Route::delete('/conceptos/{id}', [ConceptoController::class, 'destroy'])->name('conceptos.destroy');



Route::get('/gastos-proyecto', [GastoProyectoController::class, 'index'])->name('gastos_proyecto.index');
Route::post('/gastos-proyecto', [GastoProyectoController::class, 'store'])->name('gastos_proyecto.store');

Route::get('/gastos-generales', [GastosGeneralesController::class, 'index'])->name('gastos_generales.index');
Route::post('/gastos-generales', [GastosGeneralesController::class, 'store'])->name('gastos_generales.store');



Route::get('/recibos', [RecibosController::class, 'index'])->name('recibos');
Route::post('/recibos', [RecibosController::class, 'store'])->name('recibos.store');

// Ruta principal de la vista
Route::get('/r-ventas', [ReporteVentasController::class, 'index'])->name('r.ventas');
Route::get('/r-financieros', [ReporteFinancieroController::class, 'index'])->name('r.financieros');
Route::get('/r-financieros/filtrar', [ReporteFinancieroController::class, 'filtrar'])->name('r.financieros.filtrar');
Route::get('/r-lotes', [ReporteLotesController::class, 'index'])->name('r.lotes');
Route::get('/r-clientes', [ReporteClientesController::class, 'index'])->name('r.clientes');

Route::resource('proyecto-ajustes', ProyectoAjustesController::class);



Route::get('/manzanas', [ManzanaController::class, 'index'])->name('manzanas');
Route::post('/manzanas', [ManzanaController::class, 'store'])->name('manzanas.store');

Route::get('/lotes', [LotesController::class, 'index'])->name('lotes');
Route::post('/lotes', [LotesController::class, 'store'])->name('lotes.store');
Route::delete('/lotes/{id}', [LotesController::class, 'destroy'])->name('lotes.destroy');
