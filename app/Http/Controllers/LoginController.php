<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;

// class LoginController extends Controller
// {

//     public function index(){
//             return view('login');
//         }

//     public function store(Request $request){

//         $credenciais = $request->validate([
//             'email' => ['required', 'email'],
//             'password' => ['required'],
//         ]);

//         if(Auth::attempt($credenciais)){
//             $request->session()->regenerate();
//             return redirect()->intended('dashboard');
//         }else{
//             return redirect()->back()->with('erro','Usuário ou senha inválida. ');
//         }
//     }







    // public function index(){
    //     return view('login');
    // }
    // public function store(Request $request){

    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ],[
    //         'email.required' => 'Campo Obrigatório',
    //         'email.email' => 'Email Inválido',
    //         'password' => 'Campo Obrigatório',
    //         'password' => 'Senha Inválida'
    //     ]);

    //     $credentials = $request->only('email', 'password');
    //     $authenticated = Auth::attempt($credentials);

    //     if(!$authenticated){
    //         return redirect()->route('login.index')->withErrors(['error'=>'email or password invalid']);
    //     }

    // }
    // public function destroy(){
    //     var_dump('logout');
    // }


