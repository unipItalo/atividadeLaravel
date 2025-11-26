<?php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rotas Públicas
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Rotas Protegidas
Route::middleware(['checkauth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Produtos - CRUD completo
    Route::resource('produtos', ProdutoController::class);
    
    // Categorias - CRUD completo  
    Route::resource('categorias', CategoriaController::class);
});