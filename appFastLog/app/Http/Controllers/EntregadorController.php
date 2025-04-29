<?php

namespace App\Http\Controllers;

use App\Models\Entregador;
use App\Models\Pedido;
use App\Models\TipoVeiculo;
use App\Traits\ValidationMessages;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EntregadorController extends Controller
{
    use ValidationMessages;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->expectsJson()){
            $entregadores = Entregador::with('tipoVeiculo:id,tipo');
            return DataTables::of($entregadores)
            ->addIndexColumn()
            ->make(true);
        }

        return view('entregador.index');
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
                'nome' => 'required|string|max:100',
                'telefone' => 'required|phone:BR',
                'tipo_veiculo_id' => 'required|exists:tipo_veiculo,id',
            ], $this->getEntregadorValidationMessages());
           
            $entregador = Entregador::create($validate);
            return response()->json($entregador);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $entregador = Entregador::find($id);
        if(!$entregador){
            return response()->json(['message' => 'Entregador não encontrado!!'], 404);
        }

        return response()->json($entregador);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entregador $entregador)
    {
        return response()->json(['message' => 'Método não implementado.'], 501);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $entregador = Entregador::find($id);
        
        if(!$entregador){
            return response()->json(['message' => 'Entregador não encontrado!!'], 404);
        }

        try {
            $validate = $request->validate([
                'nome' => 'required|string|max:100',
                'telefone' => 'required|phone:BR',
                'tipo_veiculo_id' => 'required|exists:tipo_veiculo,id',
            ], $this->getEntregadorValidationMessages());

            $entregador->update($validate);
            return response()->json($entregador);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $entregador = Entregador::find($id);

        if(!$entregador){
            return response()->json(['message' => 'Entregador não encontrado!!'], 404);
        }

        #Verificar se há pedidos com status diferente de concluido
        if($entregador->pedidos()->where('status', '!=', 'entrega realizada')->exists()){
            return response()->json(['message' => 'Não é possível remover entregador com pedidos em andamento!!'], 400);
        }
        
        $entregador->delete();
        return response()->json(['message' => 'Entregador removido com sucesso!!']);
    }

    public function entregadoresDisponiveis()
    {
        $entregadores_disponiveis = Entregador::select('id','nome','telefone')->whereDoesntHave('pedidos', function($query) {
            $query->whereIn('status_pedido_id', [2,3,4]);
        })->get();
        
        return response()->json($entregadores_disponiveis);
    }

    public function entregadoresDisponiveisPorTipoVeiculo(Request $request, string $tipo_veiculo_id)
    {

        if(TipoVeiculo::find($tipo_veiculo_id) == null){
            return response()->json(['message' => 'Tipo de veiculo não encontrado!!'], 404);
        }
        $entregadores_disponiveis = Entregador::select('id','nome','telefone')->whereDoesntHave('pedidos', function($query) {
            $query->whereIn('status_pedido_id', [2,3,4]);
        });
        if($tipo_veiculo_id){
            $entregadores_disponiveis->where('tipo_veiculo_id', $tipo_veiculo_id);
        }
        $entregadores_disponiveis = $entregadores_disponiveis->get();

        return response()->json($entregadores_disponiveis);
    }
}
