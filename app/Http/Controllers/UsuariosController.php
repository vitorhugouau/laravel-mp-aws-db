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
public function edit($id)
{
    // Busca o usuário pelo ID
    $usuario = Usuarios::find($id);

    // Verifica se o usuário existe
    if (!$usuario) {
        return redirect()->route('usuarios.index')->with('error', 'Usuário não encontrado.');
    }

    // Retorna a view de edição com os dados do usuário
    return view('usuarios.edit', compact('usuario'));
}


// <------------------------------------------------------------------------------------------->
    public function update(Request $request, Usuarios $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:3',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

// <------------------------------------------------------------------------------------------->

    // Deleta um usuário (D)
    public function destroy(Usuarios $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }
}
