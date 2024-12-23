<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\VerificaMercadoPago;
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
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\MercadoPagoCard;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;



// Route::get('/register', [UsuariosController::class, 'create'])->name('usuarios.create');
// Route::post('/register', [UsuariosController::class, 'store'])->name('usuarios.store');

// ------------------------------------------------------------------------------------------------------------------------- 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');

Route::get('/', [ImageUploadController::class, 'indexTable2'])->name('biblioteca');

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

// rotas públicas (não requerem autenticação)
Route::post('/webhook', [MercadoPagoController::class, 'webhook'])->name('webhook');

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/password/res', [ResetPasswordController::class, 'reset'])->name('password.update');






Route::middleware('auth')->group(function () {

    // Route::get('/biblioteca', function () {
    //     $imagens = Imagem::all();
    //     return view('biblioteca.biblioteca', compact('imagens'));
    // })->name('biblioteca');

    Route::get('/adm', [AdminController::class, 'showLoginForm'])->name('adm.login');
    Route::post('/adm', [AdminController::class, 'login'])->name('adm.login.post');

    Route::post('/logoutAdm', [AuthController::class, 'logoutAdm'])->name('logoutAdm');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/pagamento/{id}', [PagamentoController::class, 'mostrarTelaDePagamento'])->name('mostrarPagamento');

    // ---------------------------------------------------------------------------------------------------------------------------------

    // Route::post('/mercadopago/create', [MercadoPagoController::class, 'createPaymentPreference'])->name('mercadopago.create');

    Route::get('/mercadopago/success', [MercadoPagoController::class, 'paymentSuccess'])->name('mercadopago.success');

    Route::get('/mercadopago/failure', function () {
        return "Falha no pagamento!";
    })->name('mercadopago.failure');


    Route::post('/mercadopago/create', [MercadoPagoController::class, 'testPixPayment'])->name('mercadopago.create');

    Route::post('/mercadopago/createCard', [MercadoPagoCard::class, 'createPaymentPreference'])->name('mercadopago.createCard');

    Route::get('/mercadopago/webhook', [MercadoPagoController::class, 'handleWebhook'])->name('mercadopago.webhook');
    
    Route::get('/mercadopago/pix', [MercadoPagoController::class, 'showPixPayment'])->name('mercadopago.pix');

    Route::get('/mercadopago/check-status/{externalReference}', [MercadoPagoController::class, 'checkPaymentStatus'])->name('mercadopago.check-status');

    Route::get('/mercadopago/success', [MercadoPagoController::class, 'handlePaymentSuccess'])->name('payment.success');

    // ---------------------------------------------------------------------------------------------------------------------------------

    
    Route::get('/mercadopago/successCard', [MercadoPagoCard::class, 'paymentSuccess'])->name('mercadopago.success');
    
    Route::get('/mercadopagoCard/{id}', [MercadoPagoCard::class, 'getPreferenceById'])->name('mercadopago.get');

    // ---------------------------------------------------------------------------------------------------------------------------------

    Route::get('/licenca', function () {
        return view('licenca');
    })->name('licenca');

    
    // ---------------------------------------------------------------------------------------------------------------------------------

    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    Route::get('/minhas-compras', [UsuariosController::class, 'minhasCompras'])->name('minhas.compras');

    Route::get('/compras/{id}', [UsuariosController::class, 'show'])->name('compras.show');

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

    // Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

    Route::get('/clientes-table', [ClienteController::class, 'index2'])->name('clientes.index2');

    Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');

    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    // ---------------------------------------------------------------------------------------------------------------------------------

    Route::get('/uploadImg', function () {
        return view('uploadImg');
    });

    Route::post('/uploadImg', [ImageUploadController::class, 'upload'])->name('uploadImg.image');

});


use App\Http\Controllers\EmailController;

Route::get('/email/form', [EmailController::class, 'showForm'])->name('email.form');
Route::post('/email/send', [EmailController::class, 'sendEmail'])->name('send.email');
Route::get('/enviar-email-template', [EmailController::class, 'sendTemplateEmail'])->name('send.template.email');

use App\Http\Controllers\EmailVerificationController;

// Route::get('/verificacao-email', [EmailVerificationController::class, 'showForm'])->name('show.verification.form');
Route::get('/verificacao-email', [EmailVerificationController::class, 'showForm'])->name('verification.showForm');

Route::get('/reenviar-codigo', [EmailVerificationController::class, 'resendVerificationCode'])->name('send.verification.code');

// Route::post('/enviar-codigo', [EmailVerificationController::class, 'sendVerificationCode'])->name('send.verification.code');
// Route::get('/enviar-codigo', [EmailVerificationController::class, 'sendVerificationCode'])->name('send.verification.code');

Route::post('/verificar-codigo', [EmailVerificationController::class, 'verifyCode'])->name('verify.code');





