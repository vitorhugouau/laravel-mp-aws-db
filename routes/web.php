<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/', [HomeController::class, 'usuarios'])->name('usuarios');


Route::controller(LoginController::class)->group(function(){

    Route::get('/login', 'index')->name('login.index');
    Route::post('/login', 'store')->name('login.store');
    Route::get('/logout', 'destroy')->name('login.destroy');
});


Route::get('/register', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/register', [UsuariosController::class, 'store'])->name('usuarios.store');


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/login', function () {
//     return view('login');
// })->name('login');

