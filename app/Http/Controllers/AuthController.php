<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Session;

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
                Session::put('verification_email', $user->email);
                
                Auth::logout();
    
                return redirect()->route('verification.showForm')->with('error', 'Por favor, verifique seu email antes de continuar.');
            }
    
            return $user->role == 'admin' 
                ? redirect()->route('biblioteca')
                : redirect()->route('biblioteca');
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
