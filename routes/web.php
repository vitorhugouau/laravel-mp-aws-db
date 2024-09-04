<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/', [HomeController::class, 'usuarios'])->name('usuarios');


Route::get('/register', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/register', [UsuariosController::class, 'store'])->name('usuarios.store');


Route::GET('/biblioteca', function () {
    return view('biblioteca.biblioteca');
})->middleware('auth')->name('biblioteca');


Route::get('/adm', function () {
    return view('adm.adm');
})->middleware('auth')->name('adm');



Route::get('/home', function () {
    return view('home');
})->name('home');



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rota protegida
Route::get('/dashboard', function () {
    return 'Você está logado!';
})->middleware('auth');




// Route::get('/login', function () {
//     return view('login');
// })->name('login');

