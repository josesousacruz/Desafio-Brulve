<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntregadorController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UsuarioController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/entregador', [EntregadorController::class, 'index'])->name('entregadores.index');
Route::post('/entregador', [EntregadorController::class, 'store'])->name('entregadores.store');
Route::put('/entregador/{id}', [EntregadorController::class,'update'])->name('entregadores.update');
Route::delete('/entregador/{id}', [EntregadorController::class,'destroy'])->name('entregadores.destroy');
Route::get('/entregador/{id}', [EntregadorController::class,'show'])->name('entregadores.show');

Route::get('/pedido', [PedidoController::class, 'index'])->name('pedido.index');
Route::post('/pedido', [PedidoController::class, 'store'])->name('pedido.store');
Route::put('/pedido/{id}', [PedidoController::class,'update'])->name('pedido.update');
Route::delete('/pedido/{id}', [PedidoController::class,'destroy'])->name('pedido.destroy');
Route::get('/pedido/{id}', [PedidoController::class,'show'])->name('pedido.show');

Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario.index');
Route::post('/usuario', [UsuarioController::class,'store'])->name('usuario.store');
Route::put('/usuario/{id}', [UsuarioController::class,'update'])->name('usuario.update');
Route::delete('/usuario/{id}', [UsuarioController::class,'destroy'])->name('usuario.destroy');
Route::get('/usuario/{id}', [UsuarioController::class,'show'])->name('usuario.show');

require __DIR__.'/auth.php';
