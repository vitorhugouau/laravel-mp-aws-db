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


Route::get('/home', function () {
    return view('home');
})->name('home');


Route::get('/register', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/register', [UsuariosController::class, 'store'])->name('usuarios.store');


// Rota protegida
// Route::get('/dashboard', function () {
//     return 'Você está logado!';
// })->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('adm.dashboard');
    })->name('dashboard');
});

Route::get('/uploads', function () {
    return view('adm.add_biblioteca.upload_imagem');
})->name('uploads');


Route::get('/imagens', [ImagemController::class, 'index'])->name('imagens.index');


Route::get('/teste', function () {
    return view('biblioteca.png');
})->name('teste');

Route::get('/control_biblioteca', function () {
    return view('adm.add_biblioteca.add-biblioteca');
})->name('control_biblioteca');


Route::get('/imagensTable', [ImagemController::class, 'indexTable'])->name('imagens.table');
Route::delete('/imagens/{id}', [ImagemController::class, 'destroy'])->name('imagens.destroy');

Route::get('/teste', function () {
    return view('biblioteca.png');
})->name('teste');


Route::get('/imagensEdit/{id}', [ImagemController::class, 'edit'])->name('imagens.edit');
Route::post('/imagens/{id}', [ImagemController::class, 'update'])->name('imagens.update');


// Route::get('/adm', function () {
//     return view('adm.adm');
// })->middleware('auth')->name('adm');



Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

// ------------------------------------------------------------------------------------------------------------------------- 


Route::middleware('auth')->group(function () {
    Route::get('/biblioteca', function () {
        $imagens = Imagem::all(); 
    
        return view('biblioteca.biblioteca', compact('imagens'));
    })->name('biblioteca');

    Route::get('/adm', [AdminController::class, 'showLoginForm'])->name('adm.login');
    Route::post('/adm', [AdminController::class, 'login'])->name('adm.login.post');
    Route::post('/logoutAdm', [AuthController::class, 'logoutAdm'])->name('logoutAdm');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



// Route::get('/usuarios', function () 
// { return view('adm.add_usuarios.index');
// })->name('usuarios');

Route::post('/upload', [ImagemController::class, 'store'])->name('imagem-store');


Route::resource('usuarios', UsuariosController::class);


// Route::middleware([AdminAuth::class, 'AuthAdmin'])->group(function () {
Route::middleware([AdminAuthMiddleware::class])->group(function () {

    Route::get('/control', function () 
    { return view('adm.control');
    })->name('control');

    
    // Route::get('/adm', function () {
    //     return view('adm.adm');
    // })->name('adm');

    // Route::get('/admin/dashboard', function () {
    //     return view('adm.dashboard');
    // })->name('admin.dashboard');

});





