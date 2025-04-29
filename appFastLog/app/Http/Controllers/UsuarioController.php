<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ValidationMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Yajra\DataTables\Facades\DataTables;

class UsuarioController extends Controller
{
    use ValidationMessages;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->expectsJson()){
            $usuarios = User::all();
            return DataTables::of($usuarios)
            ->addIndexColumn()
            ->make(true);
        }
        

        return view('usuario.index');
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
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], $this->getUserValidationMessages());

            $validate['password'] = Hash::make($validate['password']);
            $usuario = User::create($validate);
            return response()->json($usuario);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show(Request $request, string $id)
    {
        $usuario = User::find($id);
        if(!$usuario){
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        return response()->json($usuario);
    }

    public function edit(User $usuario)
    {
        return response()->json(['message' => 'Método não implementado.'], 501);
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);
        
        if(!$usuario){
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        try {
            $validate = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$usuario->id],
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            ], $this->getUserValidationMessages());

            if (isset($validate['password'])) {
                $validate['password'] = Hash::make($validate['password']);
            } else {
                unset($validate['password']);
            }

            $usuario->update($validate);
            return response()->json($usuario);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy(Request $request, string $id)
    {
        $usuario = User::find($id);

        if(!$usuario){
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }
        
        $usuario->delete();
        return response()->json(['message' => 'Usuário removido com sucesso!']);
    }
}