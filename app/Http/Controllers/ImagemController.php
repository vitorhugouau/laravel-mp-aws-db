<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImagemController extends Controller
{
    public function store(Request $request)
    {
        // Validação do arquivo de imagem
        $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Converte a imagem para binário
        $imagem = file_get_contents($request->file('imagem'));

        // Salva no banco de dados
        DB::table('imagens')->insert([
            'nome' => $request->file('imagem')->getClientOriginalName(),
            'imagem' => $imagem,
        ]);

        return back()->with('success', 'Imagem enviada com sucesso!');
    }
}
