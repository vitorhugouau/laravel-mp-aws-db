<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;

class AuthController extends Controller
{
    // Exibir formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Processar login
    public function login(Request $request)
    {
        // Validação dos dados
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentativa de autenticação
        // if (Auth::attempt($credentials)) {
           
        //     $request->session()->regenerate();
        //     return redirect()->intended('dashboard');
        // }else{
        //     return back()->withErrors([
        //         'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        //     ]);
        // }
        $admin = Usuarios::where('email', $credentials['email'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->ADM_SENHA)) {
            Auth::login($admin);
            $request->session()->regenerate();

            return view('home')->with('success', 'Login realizado com sucesso!');
        }else{
            return view('biblioteca.biblioteca')->with('success', 'Login realizado com sucesso!');
        }


        // if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
        //     $request->session()->regenerate();

        //     $user = Auth::user();
        //     return redirect()->intended('/home')
        //         ->with('success', 'Login realizado com sucesso!');
        // } else {
        //     return view('biblioteca.biblioteca');
        // }

        // Autenticação falhou
        
    }

    // Processar logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
