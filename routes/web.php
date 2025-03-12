    <?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\DashboardController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ConcertController;
    use App\Http\Controllers\EventoController;
    use App\Http\Controllers\TicketController;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\PedidosController;
    use App\Http\Controllers\LugarController;
    use App\Models\Evento;
    use App\Models\Pedido;
    use App\Http\Controllers\LugarPosicionController;
    use App\Http\Controllers\EntradaController;


    // ✅ Ruta pública para todos los usuarios (Muestra el carrusel con eventos)
/*     Route::get('/', function () {
        $eventos = Evento::all();
        return view('welcome', compact('eventos'));
    }); */

    Route::get('/', [ClienteController::class, 'index'])->name('home');

    // ✅ Ruta protegida para el Dashboard (Solo accesible si el usuario está autenticado)
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });


    // ✅ Otras rutas...

    Route::resource('lugares', LugarController::class);

    Route::get('/lugares/{lugar}/posiciones', [LugarController::class, 'getPosiciones']);

    // Route::resource('lugares-posiciones', LugarPosicionController::class);


    Route::get('/concerts/create', [ConcertController::class, 'create'])->name('concerts.create');
    Route::get('/concerts/index', [ConcertController::class, 'index'])->name('concerts.index');
    Route::post('/concerts', [ConcertController::class, 'store'])->name('concerts.store');

    Route::resource('eventos', EventoController::class);

    Route::get('/carrito', [PedidosController::class, 'index'])->name('carrito.index');
    Route::delete('/carrito/eliminar/{id}', [PedidosController::class, 'eliminar'])->name('carrito.eliminar');
    Route::get('/pedido/confirmar', [PedidosController::class, 'confirmarPedido'])->name('pedido.confirmar');

    Route::middleware('auth')->group(function () {
        Route::get('/eventos/{evento}/comprar', [TicketController::class, 'showPurchaseForm'])->name('tickets.purchase');
        Route::post('/eventos/{evento}/comprar', [TicketController::class, 'processPurchase'])->name('tickets.process');
    });

    // Ruta para ver el detalle de la entrada y el QR (simulando el método de pago ficticio)
    Route::get('/pedidos/{pedido}/detalle', [TicketController::class, 'showTicketDetail'])->name('tickets.detail');

    // Ruta para el proceso de escaneo (por ejemplo, desde la app del organizador)
    Route::post('/entradas/{entrada}/escanear', [TicketController::class, 'scanTicket'])->name('tickets.scan');

    Route::get('/consumirEntrada/{codigo}', [TicketController::class, 'scanTicket'])->name('entradas.use');

    Route::get('/generate-qr/{codigo}', [EntradaController::class, 'generateQR'])->name('generate.qr');
    Route::get('/mis-entradas', [TicketController::class, 'myTickets'])->name('tickets.user')->middleware('auth');
    Route::get('/download-qr/{codigo}', [EntradaController::class, 'downloadQR'])->name('download.qr');

    require __DIR__.'/auth.php';