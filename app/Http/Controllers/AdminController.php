<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminAuth;
use App\Models\Usuarios;
use App\Models\Adm;
use App\Models\Admin;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('adm.adm');
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        
    
        if (Auth::guard('AdminAuthMiddleware')->attempt($credentials)) {
            return redirect()->intended('control');
        }

        return back()->withErrors([
            'email' => 'As credenciais não correspondem aos nossos registros.',
        ])->withInput();
    }
}
