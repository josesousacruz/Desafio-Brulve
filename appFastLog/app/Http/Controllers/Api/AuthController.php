<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Server(
 *     url="http://localhost/api/",
 *     description="API Local Server"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     operationId="login",
     *     tags={"Autenticação"},
     *     summary="Realiza autenticação do usuário e retorna um token de acesso",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@exemplo.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|laravel_sanctum_token_hash")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciais inválidas")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
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
    }

    /**
     * @OA\Post(
     *     path="/api/v1/token",
     *     operationId="refreshToken",
     *     tags={"Autenticação"},
     *     summary="Gera um novo token de acesso para um usuário autenticado",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Token gerado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="novo_token_de_acesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Não autorizado")
     *         )
     *     )
     * )
     */
    public function refreshToken(Request $request)
    {
        $token = $request->user()->createToken('api-token', ['pedido:read']);
        return ['token' => $token->plainTextToken];
    }
}