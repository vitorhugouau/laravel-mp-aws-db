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

// ------------------------------------------------------------------------------------------------------------------------- 
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

Route::get('/register', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/register', [UsuariosController::class, 'store'])->name('usuarios.store');

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

    Route::get('/pagamento/{id}', [PagamentoController::class, 'mostrarTelaDePagamento'])->name('mostrarPagamento');

    Route::post('/mercadopago/create', [MercadoPagoController::class, 'createPaymentPreference'])->name('mercadopago.create');
    Route::get('/mercadopago/success', function () {
        return "Pagamento aprovado!";
    })->name('mercadopago.success');
    Route::get('/mercadopago/failure', function () {
        return "Falha no pagamento!";
    })->name('mercadopago.failure');

    Route::get('/mercadopago/{id}', [MercadoPagoController::class, 'getPreferenceById'])->name('mercadopago.get');
    // Route::get('/pagar', [MercadoPagoController::class, 'createPaymentPreference'])->name('pagar');

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

    Route::resource('usuarios', UsuariosController::class);

    Route::get('/control', function () {
        return view('adm.control');
    })->name('control');

    Route::get('/control_biblioteca', function () {
        return view('adm.add_biblioteca.add-biblioteca');
    })->name('control_biblioteca');


    // Route::get('/adm', function () {
    //     return view('adm.adm');
    // })->name('adm');


});



