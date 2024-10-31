<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Middleware\AdminAuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
use App\Models\Imagem;
use App\Http\Controllers\ImagemController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SaleController;

// Route::get('/register', [UsuariosController::class, 'create'])->name('usuarios.create');
// Route::post('/register', [UsuariosController::class, 'store'])->name('usuarios.store');

// ------------------------------------------------------------------------------------------------------------------------- 
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);


Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');


// auth 
Route::middleware('auth')->group(function () {

    Route::get('/biblioteca', function () {
        $imagens = Imagem::all();
        return view('biblioteca.biblioteca', compact('imagens'));
    })->name('biblioteca');

    Route::get('/adm', [AdminController::class, 'showLoginForm'])->name('adm.login');
    Route::post('/adm', [AdminController::class, 'login'])->name('adm.login.post');
    Route::post('/logoutAdm', [AuthController::class, 'logoutAdm'])->name('logoutAdm');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

    Route::get('/pagamento/{id}', [PagamentoController::class, 'mostrarTelaDePagamento'])->name('mostrarPagamento');

    Route::post('/mercadopago/create', [MercadoPagoController::class, 'createPaymentPreference'])->name('mercadopago.create');
    
    Route::get('/mercadopago/success', [MercadoPagoController::class, 'paymentSuccess'])->name('mercadopago.success');
    
    Route::get('/mercadopago/failure', function () {
        return "Falha no pagamento!";
    })->name('mercadopago.failure');

    Route::get('/mercadopago/{id}', [MercadoPagoController::class, 'getPreferenceById'])->name('mercadopago.get');

    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    
});

// middleware 
Route::middleware([AdminAuthMiddleware::class])->group(function () {

    Route::get('/imagensEdit/{id}', [ImagemController::class, 'edit'])->name('imagens.edit');
    Route::post('/imagens/{id}', [ImagemController::class, 'update'])->name('imagens.update');

    Route::get('/imagensTable', [ImagemController::class, 'indexTable'])->name('imagens.table');
    Route::delete('/imagens/{id}', [ImagemController::class, 'destroy'])->name('imagens.destroy');

    Route::get('/uploads', function () {
        return view('adm.add_biblioteca.upload_imagem');
    })->name('uploads');

    Route::get('/imagens', [ImagemController::class, 'index'])->name('imagens.index');

    Route::post('/upload', [ImagemController::class, 'store'])->name('imagem-store');

    Route::get('/control', function () {
        return view('adm.control');
    })->name('control');

    Route::get('/control_biblioteca', function () {
        return view('adm.add_biblioteca.add-biblioteca');
    })->name('control_biblioteca');

    Route::resource('sales', SaleController::class);
    
    // ---------------------------------------------------------------------------------------------------------------------------------
    
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    
    Route::get('/usuarios/{id}/edit', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    
    Route::put('/usuarios/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
    
    Route::delete('/usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
    
    // ---------------------------------------------------------------------------------------------------------------------------------
    
    Route::get('/clientes-table', [ClienteController::class, 'index2'])->name('clientes.index2');

    Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');

    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    
});    




Route::get('/minhas-compras', [UsuariosController::class, 'minhasCompras'])->name('minhas.compras');

Route::get('/compras/{id}', [UsuariosController::class, 'show'])->name('compras.show');




