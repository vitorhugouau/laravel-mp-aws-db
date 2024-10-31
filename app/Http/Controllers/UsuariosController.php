<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Imagem;


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
    $usuarios = Usuarios::all(); 
    return view('usuarios.index', compact('usuarios')); 
}
// <------------------------------------------------------------------------------------------->
public function edit($id)
{
    $usuario = Usuarios::find($id);

    if (!$usuario) {
        return redirect()->route('usuarios.index')->with('error', 'Usuário não encontrado.');
    }

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

    public function destroy(Usuarios $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }

// <------------------------------------------------------------------------------------------->

    public function minhasCompras()
    {
        $user = Auth::user();
        $compras = Sale::where('user_id', $user->id)->with('product')->get();

        return view('compras.index', compact('compras'));
    }


// <------------------------------------------------------------------------------------------->

public function show($id)
{
    // Encontra a compra pelo ID
    $compra = Sale::with('product')->findOrFail($id);

    // Verifica se o usuário está autenticado
    $user = Auth::user();

    if ($user) {
        
        $imagem_id = $compra->product_id; 
        $payment_id = $compra->payment_id; 
        $status = $compra->status; 

       
        $imagem = Imagem::find($imagem_id);

       
        return view('compras.show', compact('compra', 'payment_id', 'status', 'imagem'));
    }

    return redirect()->route('biblioteca')->with('error', 'Você precisa estar logado para visualizar suas compras.');
}

public function show1($id)
    {

        $compra = Sale::with('product')->findOrFail($id);

        return view('compras.show', compact('compra'));
    }
}
