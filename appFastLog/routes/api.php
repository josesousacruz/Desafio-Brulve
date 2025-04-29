<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

Route::prefix('v1')->group(function () {
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token', ['pedido:read']);
            return ['token' => $token->plainTextToken];
        }

        return response()->json([
            'message' => 'Credenciais inválidas'
        ], 401);
    });

    Route::post('/token', function(Request $request){
        $token = $request->user()->createToken('api-token', ['pedido:read']);
        return ['token' => $token->plainTextToken];
    })->middleware(['auth']);

    Route::middleware(['auth:sanctum', 'abilities:pedido:read'])->group(function () {
        Route::get('/pedido', function () {
            return Pedido::select('pedido.id', 'pedido.numeroPedido', 'pedido.destinatarioNome', 'pedido.destinatarioTelefone','pedido.destinatarioEndereco', 'pedido.itemDescricao','pedido.status', 'entregador.nome as entregador')
                ->join('entregador', 'pedido.entregador_id', '=', 'entregador.id')
                ->get();
        });
        
        Route::get('/pedido/{id}', function ($id) {
            $pedido = Pedido::select('pedido.id', 'pedido.numeroPedido', 'pedido.destinatarioNome', 'pedido.destinatarioTelefone','pedido.destinatarioEndereco', 'pedido.itemDescricao','pedido.status', 'entregador.nome as entregador')
                ->join('entregador', 'pedido.entregador_id', '=', 'entregador.id')
                ->where('pedido.id', $id)
                ->first();

            if(!$pedido)
                return response()->json(['message' => 'Pedido não encontrado!'], 404);

            return $pedido;
        });
    });
});