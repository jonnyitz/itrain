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
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AccesosController;
use App\Http\Controllers\UserController;



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
Route::middleware('auth')->get('/inicio', [InicioController::class, 'index'])->name('inicio');

// Rutas para la gestión de proyectos
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos');
Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
Route::get('/proyectos/filtrar', [ProyectoController::class, 'filtrar'])->name('proyectos.filtrar');
Route::middleware('auth')->get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos');

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
Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
Route::get('/ventas/{ventaId}/pagare', [VentaController::class, 'generarPagare'])->name('ventas.pagare');
Route::post('/ventas/guardar', [VentaController::class, 'guardar'])->name('ventas.guardar');
Route::get('/ventas/{id}/cronograma', [CreditoController::class, 'generarCronogramaPdf'])->name('ventas.cronograma');


// routes/web.php
Route::get('/creditos', [CreditoController::class, 'index'])->name('creditos');

//cuotas|
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

// VENTAS
//Reportes Ventas
Route::get('/r-ventas', [ReporteVentasController::class, 'index'])->name('r.ventas');
Route::get('/reporte-ventas/pdf', [ReporteVentasController::class, 'generarPDF'])->name('generar_pdf');
Route::get('/detalle-venta/pdf', [ReporteVentasController::class, 'detalleVentaPDF'])->name('detalle_venta');
//Reportes Vendedor
Route::get('/ventas-por-vendedor', [ReporteVentasController::class, 'ventasPorVendedor'])->name('ventas_por_vendedor');
Route::get('/cuotas-por-cobrar/pdf', [ReporteVentasController::class, 'cuotasPorCobrarPDF'])->name('cuotas_por_cobrar');
//Reportes Generales
Route::get('/ventas-completadas/pdf', [ReporteVentasController::class, 'ventasCompletadasPDF'])->name('ventas_completadas');
Route::get('/ventas-anuladas/pdf', [ReporteVentasController::class, 'ventasAnuladasPDF'])->name('ventas_anuladas');
//FINANCIERO
//Reporte financiero
Route::get('/r-financieros', [ReporteFinancieroController::class, 'index'])->name('r.financieros');
Route::get('/r-financieros/filtrar', [ReporteFinancieroController::class, 'filtrar'])->name('r.financieros.filtrar');
//LOTES
//Reporte Lotes
Route::get('/r-lotes', [ReporteLotesController::class, 'index'])->name('r.lotes');
Route::get('/total-lotes', [ReporteLotesController::class, 'totalLotesPDF'])->name('total_lotes');
Route::get('/lotes-disponibles', [ReporteLotesController::class, 'lotesDisponiblesPDF'])->name('lotes_disponibles');
Route::get('/lotes-inactivos', [ReporteLotesController::class, 'lotesInactivosPDF'])->name('lotes_inactivos');
Route::get('/lotes-vendidos', [ReporteLotesController::class, 'lotesVendidosPDF'])->name('lotes_vendidos');
Route::get('/lotes-reservados', [ReporteLotesController::class, 'lotesReservadosPDF'])->name('lotes_reservados');

//CLIENTES
//Reporte Clientes
Route::get('/r-clientes', [ReporteClientesController::class, 'index'])->name('r.clientes');
Route::get('/r-clientes/pdf', [ReporteClientesController::class, 'generarPDF'])->name('clientes.pdf');

Route::resource('proyecto-ajustes', ProyectoAjustesController::class);

Route::get('/manzanas', [ManzanaController::class, 'index'])->name('manzanas');
Route::post('/manzanas', [ManzanaController::class, 'store'])->name('manzanas.store');
Route::delete('/manzanas/{id}', [ManzanaController::class, 'destroy'])->name('manzanas.destroy');


Route::get('/lotes', [LotesController::class, 'index'])->name('lotes');
Route::post('/lotes', [LotesController::class, 'store'])->name('lotes.store');
Route::delete('/lotes/{id}', [LotesController::class, 'destroy'])->name('lotes.destroy');


Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos');
Route::post('/grupos', [GrupoController::class, 'store'])->name('grupos.store');
Route::get('/grupos/export', [GrupoController::class, 'export']);

Route::get('/accesos', [AccesosController::class, 'index'])->name('accesos');


Route::get('/users', [UserController::class, 'index'])->name('users');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

