<?php

namespace App\Http\Controllers;

use App\Models\TipoVeiculo;
use Illuminate\Http\Request;

class TipoVeiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TipoVeiculo::select('id','tipo')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação pode ser adicionada aqui
        return TipoVeiculo::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoVeiculo $tipoVeiculo)
    {
        return $tipoVeiculo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoVeiculo $tipoVeiculo)
    {
        // Validação pode ser adicionada aqui
        $tipoVeiculo->update($request->all());
        return $tipoVeiculo;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoVeiculo $tipoVeiculo)
    {
        $tipoVeiculo->delete();
        return response()->json(null, 204);
    }
}