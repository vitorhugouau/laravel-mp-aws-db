<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function showLoginForm(Request $request)
    {
        return view('auth.login');
        // return view('auth.login', ['redirectTo' => $request->get('redirectTo', route('biblioteca'))]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Verificação de email
            if ($user->email_verified_at == null) {
                Session::put('verification_email', $user->email);
                Auth::logout();

                return redirect()->route('verification.showForm')->with('error', 'Por favor, verifique seu email antes de continuar.');
            }

            // Recupera o 'redirectTo' passado no formulário
            $redirectTo = $request->get('redirectTo', route('biblioteca')); // Se não houver 'redirectTo', usa a URL padrão

            // Registrar log com a URL para onde o usuário será redirecionado
            Log::info("Usuário redirecionado para: " . $redirectTo, [
                'user_id' => $user->id,
                'email' => $user->email,
                'redirect_url' => $redirectTo
            ]);
            if ($user->role == 'admin') {
                 $redirectTo = $request->get('redirectTo', route('biblioteca')); // Se não houver 'redirectTo', usa a URL padrão
            }

            return redirect()->intended($redirectTo); // Redireciona para a URL fornecida no 'redirectTo'
        }

        return redirect()->back()->withErrors(['email' => 'Credenciais inválidas']);
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logoutAdm(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
