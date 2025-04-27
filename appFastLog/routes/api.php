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
            return Pedido::all();
        });
        
        Route::get('/pedido/{id}', function ($id) {
            $pedido = Pedido::find($id);
            if(!$pedido)
                return response()->json(['message' => 'Pedido não encontrado!'], 404);

            return Pedido::find($id);
        });
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
