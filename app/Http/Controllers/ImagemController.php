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

        return redirect()->route('control')->with('success', 'Imagem enviada com sucesso!');
    }


    public function show($id)
    {
        // Busca a imagem no banco de dados
        $imagem = Imagem::findOrFail($id);

        // Retorna a imagem com o cabeçalho correto
        return response($imagem->imagem)
            ->header('Content-Type', 'image/jpeg'); // Ajuste o tipo de conteúdo conforme necessário
    }

    public function index()
    {
        // Busca todas as imagens do banco de dados
        $imagens = Imagem::all();

        // Retorna a view com as imagens
        return view('imagens.index', compact('imagens'));
    }
    public function indexTable()
    {
        // Busca todas as imagens do banco de dados
        $imagens = Imagem::all();

        // Retorna a view com as imagens
        return view('imagens.table', compact('imagens'));
    }

    public function destroy($id)
    {
        $imagem = Imagem::findOrFail($id);
        $imagem->delete();
        return redirect()->route('imagens.table')->with('success', 'Imagem excluída com sucesso.');
    }
    public function edit($id)
    {
        $imagem = Imagem::findOrFail($id); // Recupera o registro do banco de dados pelo ID
        return view('imagens.edit', compact('imagem'));
    }

    // Processa a atualização do registro
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255', // Validação do campo nome
        ]);

        $imagem = Imagem::findOrFail($id); // Busca o registro
        $imagem->nome = $request->input('nome'); // Atualiza o nome
        $imagem->save(); // Salva no banco de dados

        return redirect()->route('imagens.table')->with('success', 'Registro atualizado com sucesso!');
    }
}