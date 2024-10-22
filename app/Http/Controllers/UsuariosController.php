<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:3|confirmed',
        ]);

        Usuarios::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
    }
// <------------------------------------------------------------------------------------------->
    public function index(){
    $usuarios = Usuarios::all(); // Obtendo todos os usuários
    return view('usuarios.index', compact('usuarios')); // Retorna a view com os usuários
}
// <------------------------------------------------------------------------------------------->
    // public function edit(Usuario $usuario)
    // {
    //     return view('adm.add_usuarios.edit', compact('usuario'));
    // }

    // Atualiza um usuário existente (U)

// <------------------------------------------------------------------------------------------->
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'senha' => 'nullable|string|min:8',
        ]);

        $usuario->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => $request->senha ? bcrypt($request->senha) : $usuario->senha,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

// <------------------------------------------------------------------------------------------->

    // Deleta um usuário (D)
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }
}
