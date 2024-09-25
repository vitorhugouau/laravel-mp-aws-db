<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Imagem;

class ImagemController extends Controller
{

    public function store(Request $request)
    {
        // Validação do arquivo de imagem
        $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Obtém o nome original da imagem
        $nomeImagem = $request->file('imagem')->getClientOriginalName();
    
        // Converte a imagem para base64
        $imagemBase64 = base64_encode(file_get_contents($request->file('imagem')->getRealPath()));
    
        // Salva a imagem no banco de dados como base64
        Imagem::create([
            'nome' => $nomeImagem,
            'imagem' => $imagemBase64,  // Armazena a imagem como string base64
        ]);
    
        return redirect()->route('uploads')->with('success', 'Imagem enviada com sucesso!');
    }
    

public function show($id)
{
    // Busca a imagem no banco de dados
    $imagem = Imagem::findOrFail($id);

    // Retorna a imagem com o cabeçalho correto
    return response($imagem->imagem)
           ->header('Content-Type', 'image/jpeg'); // Ajuste o tipo de conteúdo conforme necessário
}


}