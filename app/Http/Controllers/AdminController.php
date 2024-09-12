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
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Dados de autenticação
        // $credentials = $request->only('email', 'password');

        // Tenta fazer o login
        echo "<pre>";
        var_dump($credentials);
        echo "</pre>";
        if (Auth::attempt(credentials: $credentials)) {
            // Se o login for bem-sucedido, redireciona o usuário
            // return redirect()->intended('control');
            var_dump('asdfiwf');
            return redirect()->view('/control');
        }

        // Se o login falhar, retorna de volta com uma mensagem de erro
    }
}
