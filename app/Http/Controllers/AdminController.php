<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        return view('adm.adm');
    }

    // Lida com a submissão do formulário de login
    public function login(Request $request)
    {
        // Validação dos dados de email e senha
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:1',
        ]);

        // Dados de autenticação
        $credentials = $request->only('email', 'password');

        // Tenta fazer o login
        if (Auth::attempt($credentials)) {
            // Se o login for bem-sucedido, redireciona o usuário
            return redirect()->intended('control');
        }

        // Se o login falhar, retorna de volta com uma mensagem de erro
        return back()->withErrors([
            'email' => 'As credenciais não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }
}
