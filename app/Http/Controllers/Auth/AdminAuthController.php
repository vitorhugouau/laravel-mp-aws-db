<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->all();

        
        if (Auth::attempt(array_merge($credentials, ['is_admin' => true]))) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais de administrador inválidas.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
