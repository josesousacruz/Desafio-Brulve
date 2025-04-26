<?php

namespace App\Http\Controllers;

use App\Models\Entregador;
use App\Traits\ValidationMessages;
use Illuminate\Http\Request;

class EntregadorController extends Controller
{
    use ValidationMessages;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->expectsJson()){
            $entregadores = Entregador::all();
            return response()->json($entregadores);
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
                'tipoVeiculo' => 'required|in:bicicleta,caminhão,van,motocicleta',
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
    public function show(Request $request)
    {
        $entregador = Entregador::find($request->id);
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
    public function update(Request $request)
    {
        $entregador = Entregador::find($request->id);
        
        if(!$entregador){
            return response()->json(['message' => 'Entregador não encontrado!!'], 404);
        }

        try {
            $validate = $request->validate([
                'nome' => 'required|string|max:100',
                'telefone' => 'required|phone:BR',
                'tipoVeiculo' => 'required|in:bicicleta,caminhão,van,motocicleta',
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
    public function destroy(Request $request)
    {
        $entregador = Entregador::find($request->id);

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
}
