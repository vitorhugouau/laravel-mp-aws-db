<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        // Exibe o formulário de redefinição com o token e e-mail
        return view('auth.passwords.reset', ['token' => $request->token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        // Validação
        $request->validate([
            'email' => 'required|email|exists:usuarios,email', // Ajuste aqui para garantir que a tabela 'usuarios' está sendo consultada
            'password' => 'required|min:3|confirmed', // A senha deve ter pelo menos 8 caracteres
            'token' => 'required|string', 
        ]);

        // Realiza a redefinição de senha
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password); // Criptografa a nova senha
                $user->save(); // Salva a senha no banco de dados
            }
        );

        // Verificar se a redefinição de senha foi bem-sucedida
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Senha redefinida com sucesso!')
            : back()->withErrors(['email' => __($status)]);
    }
}
