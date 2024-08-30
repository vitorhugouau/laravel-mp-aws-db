<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function usuarios(){
        $dados = usuarios::all()->toArray();
        print_r($dados);
    }

    public function novo(){
        $dados = new usuarios;
        $dados->usuarios_nome = "Vitor";
        $dados->usuarios_sobrenome = 'Hugo';
        $dados->usuarios_email = 'vitor@gmail.com';
        $dados->usuarios_senha = '123';

    }
}
