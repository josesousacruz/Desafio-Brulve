<?php

namespace App\Http\Controllers;

use App\Models\StatusPedido;
use Illuminate\Http\Request;

class StatusPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StatusPedido::select('id','status')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação pode ser adicionada aqui
        return StatusPedido::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusPedido $statusPedido)
    {
        return $statusPedido;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusPedido $statusPedido)
    {
        // Validação pode ser adicionada aqui
        $statusPedido->update($request->all());
        return $statusPedido;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusPedido $statusPedido)
    {
        $statusPedido->delete();
        return response()->json(null, 204);
    }
}