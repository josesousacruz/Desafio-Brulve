<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntregadorController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\StatusPedidoController;
use App\Http\Controllers\TipoVeiculoController;

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

// Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuario', UsuarioController::class);
    Route::resource('entregador', EntregadorController::class);
    Route::resource('pedido', PedidoController::class);

    Route::put('/pedido/proximo-status/{id}', [PedidoController::class, 'atualizarStatus'])->name('pedido.atualizar-status');

    Route::get('/entregadores-disponiveis', [EntregadorController::class, 'entregadoresDisponiveis'])->name('entregador.disponivel');
    Route::get('/entregadores-disponiveis/{id}', [EntregadorController::class, 'entregadoresDisponiveisPorTipoVeiculo'])->name('entregador.disponivel.veiculo');

// });

Route::resource('status-pedido', StatusPedidoController::class)->except(['create', 'edit']);
Route::resource('tipo-veiculo', TipoVeiculoController::class)->except(['create', 'edit']);
require __DIR__.'/auth.php';
