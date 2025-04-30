<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

Route::prefix('v1')->group(function () {
    
    /**
     * @OA\Post(
     * path="/api/v1/login",
     * operationId="login",
     * tags={"Autenticação"},
     * summary="Realiza autenticação do usuário e retorna um token de acesso",
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         required={"email","password"},
     *         @OA\Property(property="email", type="string", format="email", example="usuario@exemplo.com"),
     *         @OA\Property(property="password", type="string", format="password", example="senha123")
     *     )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Login realizado com sucesso",
     *     @OA\JsonContent(
     *         @OA\Property(property="token", type="string", example="1|laravel_sanctum_token_hash")
     *     )
     * ),
     * @OA\Response(
     *     response=401,
     *     description="Credenciais inválidas",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Credenciais inválidas")
     *     )
     * )
     * )
     */
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

    /**
     * @OA\Post(
     * path="/api/token",
     * operationId="refreshToken",
     * tags={"Autenticação"},
     * summary="Gera um novo token de acesso para um usuário autenticado",
     * security={
     *   {"auth": {}}
     * },
     * responses={
     *   @OA\Response(
     *     response=200,
     *     description="Token gerado com sucesso",
     *     @OA\JsonContent(
     *       @OA\Property(property="token", type="string", example="novo_token_de_acesso")
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Não autorizado",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Não autorizado")
     *     )
     *   )
     * }
     * )
     */
    Route::post('/token', function(Request $request){
        $token = $request->user()->createToken('api-token', ['pedido:read']);
        return ['token' => $token->plainTextToken];
    })->middleware(['auth']);

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
        Route::get('/pedido', function () {
            return Pedido::select('pedido.id', 'pedido.numeroPedido', 'pedido.destinatarioNome', 'pedido.destinatarioTelefone','pedido.destinatarioEndereco', 'pedido.itemDescricao','pedido.status_pedido_id', 'entregador.nome as entregador')
                ->join('entregador', 'pedido.entregador_id', '=', 'entregador.id')
                ->get();
        });
        
        /**
         * @OA\Get(
         *     path="/api/v1/pedido/{id}",
         *     operationId="getPedido",
         *     tags={"Pedidos"},
         *     summary="Retorna os detalhes de um pedido específico",
         *     security={
         *         {"bearerAuth": {}}
         *     },
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="ID do pedido",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Detalhes do pedido retornados com sucesso",
         *         @OA\JsonContent(
         *             @OA\Property(property="id", type="integer"),
         *             @OA\Property(property="numeroPedido", type="string"),
         *             @OA\Property(property="destinatarioNome", type="string"),
         *             @OA\Property(property="destinatarioTelefone", type="string"),
         *             @OA\Property(property="destinatarioEndereco", type="string"),
         *             @OA\Property(property="itemDescricao", type="string"),
         *             @OA\Property(property="status_pedido_id", type="integer"),
         *             @OA\Property(property="entregador", type="string")
         *         )
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Pedido não encontrado",
         *         @OA\JsonContent(
         *             @OA\Property(property="message", type="string", example="Pedido não encontrado!")
         *         )
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Não autorizado"
         *     )
         * )
         */
        Route::get('/pedido/{id}', function ($id) {
            $pedido = Pedido::select('pedido.id', 'pedido.numeroPedido', 'pedido.destinatarioNome', 'pedido.destinatarioTelefone','pedido.destinatarioEndereco', 'pedido.itemDescricao','pedido.status_pedido_id', 'entregador.nome as entregador')
                ->join('entregador', 'pedido.entregador_id', '=', 'entregador.id')
                ->where('pedido.id', $id)
                ->first();

            if(!$pedido)
                return response()->json(['message' => 'Pedido não encontrado!'], 404);

            return $pedido;
        });
    });
});