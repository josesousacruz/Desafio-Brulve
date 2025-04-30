<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/token', [\App\Http\Controllers\Api\AuthController::class, 'refreshToken'])->middleware(['auth']);

    /**
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/v1/pedido",
     *     operationId="listPedidos",
     *     tags={"Pedidos"},
     *     summary="Lista todos os pedidos",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pedidos retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="numeroPedido", type="string"),
     *                 @OA\Property(property="destinatarioNome", type="string"),
     *                 @OA\Property(property="destinatarioTelefone", type="string"),
     *                 @OA\Property(property="destinatarioEndereco", type="string"),
     *                 @OA\Property(property="itemDescricao", type="string"),
     *                 @OA\Property(property="status_pedido_id", type="integer"),
     *                 @OA\Property(property="entregador", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    Route::middleware(['auth:sanctum', 'abilities:pedido:read'])->group(function () {
        Route::get('/pedido', [\App\Http\Controllers\Api\PedidoApiController::class, 'index']);
        Route::get('/pedido/{id}', [\App\Http\Controllers\Api\PedidoApiController::class, 'show']);
    });
});