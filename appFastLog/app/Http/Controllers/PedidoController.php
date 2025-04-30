<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Traits\ValidationMessages;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PedidoController extends Controller
{
    use ValidationMessages;
    /**
     * Display a listing of the resource.
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
                $validate = $request->validate([
                'numeroPedido' => 'required|string|max:50|unique:pedido',
                'destinatarioNome' => 'required|string|max:100',
                'destinatarioEndereco' => 'required|string|max:200',
                'destinatarioTelefone' => 'required|phone:BR',
                'itemDescricao' => 'required|string|max:500',
                'tipo_veiculo_id' => 'required|exists:tipo_veiculo,id'
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // return $request;
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
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
}
