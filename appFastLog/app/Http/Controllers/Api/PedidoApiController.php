<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoApiController extends Controller
{
    /**
     * @OAGet(
     *     path="/api/v1/pedido",
     *     operationId="listPedidos",
     *     tags={"Pedidos"},
     *     summary="Lista todos os pedidos",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OAResponse(
     *         response=200,
     *         description="Lista de pedidos retornada com sucesso",
     *         @OAJsonContent(
     *             type="array",
     *             @OAItems(
     *                 @OAProperty(property="id", type="integer"),
     *                 @OAProperty(property="numeroPedido", type="string"),
     *                 @OAProperty(property="destinatarioNome", type="string"),
     *                 @OAProperty(property="destinatarioTelefone", type="string"),
     *                 @OAProperty(property="destinatarioEndereco", type="string"),
     *                 @OAProperty(property="itemDescricao", type="string"),
     *                 @OAProperty(property="status_pedido_id", type="integer"),
     *                 @OAProperty(property="entregador", type="string")
     *             )
     *         )
     *     ),
     *     @OAResponse(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    public function index()
    {
        return Pedido::select('pedido.id', 'pedido.numeroPedido', 'pedido.destinatarioNome', 'pedido.destinatarioTelefone',
            'pedido.destinatarioEndereco', 'pedido.itemDescricao','pedido.status_pedido_id', 'entregador.nome as entregador')
            ->join('entregador', 'pedido.entregador_id', '=', 'entregador.id')
            ->get();
    }

    /**
     * @OAGet(
     *     path="/api/v1/pedido/{id}",
     *     operationId="getPedido",
     *     tags={"Pedidos"},
     *     summary="Retorna os detalhes de um pedido específico",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OAParameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do pedido",
     *         @OASchema(type="integer")
     *     ),
     *     @OAResponse(
     *         response=200,
     *         description="Detalhes do pedido retornados com sucesso",
     *         @OAJsonContent(
     *             @OAProperty(property="id", type="integer"),
     *             @OAProperty(property="numeroPedido", type="string"),
     *             @OAProperty(property="destinatarioNome", type="string"),
     *             @OAProperty(property="destinatarioTelefone", type="string"),
     *             @OAProperty(property="destinatarioEndereco", type="string"),
     *             @OAProperty(property="itemDescricao", type="string"),
     *             @OAProperty(property="status_pedido_id", type="integer"),
     *             @OAProperty(property="entregador", type="string")
     *         )
     *     ),
     *     @OAResponse(
     *         response=404,
     *         description="Pedido não encontrado",
     *         @OAJsonContent(
     *             @OAProperty(property="message", type="string", example="Pedido não encontrado!")
     *         )
     *     ),
     *     @OAResponse(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    public function show($id)
    {
        $pedido = Pedido::select('pedido.id', 'pedido.numeroPedido', 'pedido.destinatarioNome', 'pedido.destinatarioTelefone',
            'pedido.destinatarioEndereco', 'pedido.itemDescricao','pedido.status_pedido_id', 'entregador.nome as entregador')
            ->join('entregador', 'pedido.entregador_id', '=', 'entregador.id')
            ->where('pedido.id', $id)
            ->first();

        if(!$pedido)
            return response()->json(['message' => 'Pedido não encontrado!'], 404);

        return $pedido;
    }
}