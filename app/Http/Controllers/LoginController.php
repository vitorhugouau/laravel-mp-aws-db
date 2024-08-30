<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function store(Request $request){
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'Campo Obrigatório',
            'email.email' => 'Email Inválido',
            'password' => 'Campo Obrigatório'
        ]);

        // var_dump('login');
    }
    public function destroy(){
        var_dump('logout');
    }
}
