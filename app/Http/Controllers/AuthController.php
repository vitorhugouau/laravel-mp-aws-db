<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

   
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        
        if ($user->email_verified_at == null) {

            return redirect()->route('verification.showForm')->with('error', 'Por favor, verifique seu email antes de continuar.');
        }

        if ($user->role == 'admin') {
            return redirect()->route('biblioteca');
        }

        return redirect()->route('biblioteca');
    }

    // Caso as credenciais estejam erradas, redireciona de volta com erro
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
