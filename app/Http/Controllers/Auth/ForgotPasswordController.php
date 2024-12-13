<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    // Exibe o formulário para solicitar o link de redefinição de senha
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // Retorna a view para o formulário
    }

    // Envia o link de redefinição de senha para o e-mail do usuário
    public function sendResetLinkEmail(Request $request)
    {
        // Validação do e-mail
        $request->validate([
            'email' => 'required|email|exists:usuarios,email', // Verifica se o e-mail existe na tabela users
        ]);

        // Enviar o link de redefinição de senha
        $status = Password::sendResetLink(
            $request->only('email')  // Apenas o e-mail do usuário
        );

        // Verificar se o link foi enviado com sucesso
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))  // Mensagem de sucesso
            : back()->withErrors(['email' => __($status)]);  // Mensagem de erro
    }
}
