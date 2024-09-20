<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/', [HomeController::class, 'usuarios'])->name('usuarios');

Route::get('/home', function () {
    return view('home');
})->name('home');


Route::get('/register', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/register', [UsuariosController::class, 'store'])->name('usuarios.store');


Route::GET('/biblioteca', function () {
    return view('biblioteca.biblioteca');
})->middleware('auth')->name('biblioteca');


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rota protegida
Route::get('/dashboard', function () {
    return 'Você está logado!';
})->middleware('auth');


Route::get('/adm', function () {
    return view('adm.adm');
})->middleware('auth')->name('adm');

Route::get('/control', function () {
    return view('adm.control');
})->middleware('auth')->name('control');


Route::get('/adm', [AdminController::class, 'showLoginForm'])->name('adm.login');
Route::post('/adm', [AdminController::class, 'login'])->name('adm.login.post');
Route::post('/logoutAdm', [AuthController::class, 'logoutAdm'])->name('logoutAdm');



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('adm.dashboard');
    })->name('dashboard');
});


Route::get('/teste', function () {
    return view('biblioteca.png');
})->name('teste');




