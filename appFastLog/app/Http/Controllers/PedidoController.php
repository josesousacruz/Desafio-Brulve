<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Traits\ValidationMessages;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * @OA\Tag(
 *     name="Pedidos",
 *     description="API Endpoints de gerenciamento de pedidos"
 * )
 *
 * @OA\Schema(
 *     schema="Pedido",
 *     required={"numeroPedido", "destinatarioNome", "destinatarioEndereco", "destinatarioTelefone", "itemDescricao", "entregador_id", "status_pedido_id"},
 *     @OA\Property(property="id", type="integer", format="int64", description="ID do pedido"),
 *     @OA\Property(property="numeroPedido", type="string", maxLength=50, description="Número único do pedido"),
 *     @OA\Property(property="destinatarioNome", type="string", maxLength=100, description="Nome do destinatário"),
 *     @OA\Property(property="destinatarioEndereco", type="string", maxLength=200, description="Endereço de entrega"),
 *     @OA\Property(property="destinatarioTelefone", type="string", description="Telefone do destinatário"),
 *     @OA\Property(property="itemDescricao", type="string", maxLength=500, description="Descrição do item a ser entregue"),
 *     @OA\Property(property="entregador_id", type="integer", description="ID do entregador responsável"),
 *     @OA\Property(property="status_pedido_id", type="integer", description="ID do status do pedido"),
 * )
 */
class PedidoController extends Controller
{
    use ValidationMessages;
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/pedidos",
     *     summary="Lista todos os pedidos",
     *     tags={"Pedidos"},
     *     security={"bearerAuth": {}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pedidos retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pedido")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        if($request->expectsJson()){
            $pedidos = Pedido::with('entregador', 'statusPedido:id,status')->get();
            return DataTables::of($pedidos)
            ->addIndexColumn()
            ->make(true);
        }

        return view('pedido.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Método não implementado.'], 501);
    }

    public function store(Request $request)
    {
        try {
                $validate = $request->validate([
                'numeroPedido' => 'required|string|max:50|unique:pedido',
                'destinatarioNome' => 'required|string|max:100',
                'destinatarioEndereco' => 'required|string|max:200',
                'destinatarioTelefone' => 'required|phone:BR',
                'itemDescricao' => 'required|string|max:500',
                'entregador_id' => 'required|exists:entregador,id'
            ], $this->getPedidoValidationMessages());

        $pedido = Pedido::create($validate);
        return response()->json($pedido);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/pedidos/{id}",
     *     summary="Retorna um pedido específico",
     *     tags={"Pedidos"},
     *     security={"bearerAuth": {}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do pedido",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pedido encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Pedido")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pedido não encontrado"
     *     )
     * )
     */
    public function show(Request $request, string $id)
    {
        $pedido = Pedido::with('entregador', 'statusPedido')->find($id);
        if(!$pedido){
            return response()->json(['message' => 'Pedido não encontrado!'], 404);
        }

        return response()->json($pedido);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        return response()->json(['message' => 'Método não implementado.'], 501);
    }

    public function update(Request $request, string $id)
    {
        $pedido = Pedido::find($id);
        
        if(!$pedido){
            return response()->json(['message' => 'Pedido não encontrado!'], 404);
        }

        try {
            $validate = $request->validate([
            'numeroPedido' => 'required|string|max:50|unique:pedido,numeroPedido,'.$pedido->id,
            'destinatarioNome' => 'required|string|max:100',
            'destinatarioEndereco' => 'required|string|max:200',
            'destinatarioTelefone' => 'required|phone:BR',
            'itemDescricao' => 'required|string|max:500',
            'entregador_id' => 'required|exists:entregador,id,deleted_at,NULL',
            'status_pedido_id' => 'required|exists:status_pedido,id'
        ], $this->getPedidoValidationMessages());

        $pedido->update($validate);
        return response()->json($pedido);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy(string $id)
    {
        $pedido = Pedido::find($id);

        if(!$pedido){
            return response()->json(['message' => 'Pedido não encontrado!'], 404);
        }

        // Assumindo que 'entrega realizada' tem ID 5 na tabela status_pedido
        if($pedido->status_pedido_id == 5){
            return response()->json(['message' => 'Não é possível remover pedidos concluidos!'], 400);
        }
        
        $pedido->delete();
        return response()->json(['message' => 'Pedido removido com sucesso!']);
    }

    public function atualizarStatus(Request $request, string $id){
        $pedido = Pedido::select('id','status_pedido_id')->find($id);
        if(!$pedido){
            return response()->json(['message' => 'Pedido não encontrado!'], 404);
        }

        if($pedido->status_pedido_id < 5){
            $pedido->status_pedido_id = $pedido->status_pedido_id + 1;
            $pedido->save();
            return response()->json($pedido);
        }else if($pedido->status_pedido_id == 5){
            return response()->json(['message' => 'Não é possível atualizar pedidos concluidos!'], 400);
        }else if($pedido->status_pedido_id == 6){
            return response()->json(['message' => 'Não é possível atualizar pedidos cancelados!'], 400);
        } 
        return response()->json($pedido);
    }
}
