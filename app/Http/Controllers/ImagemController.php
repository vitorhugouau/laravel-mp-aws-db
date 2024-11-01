<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagem;

class ImagemController extends Controller
{
    public function store(Request $request)
    {
       
        $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'valor' => 'required|numeric|min:0', 
        ]);

        $nomeImagem = $request->file('imagem')->getClientOriginalName();

        $imagemBase64 = base64_encode(file_get_contents($request->file('imagem')->getRealPath()));

        Imagem::create([
            'nome' => $nomeImagem,
            'imagem' => $imagemBase64, 
            'valor' => $request->input('valor'), 
        ]);

        return redirect()->route('control')->with('success', 'Imagem enviada com sucesso!');
    }

    public function show($id)
    {
        $imagem = Imagem::findOrFail($id);

        return response($imagem->imagem)
            ->header('Content-Type', 'image/jpeg'); 
    }

    public function index()
    {
        
        $imagens = Imagem::all();

        return view('imagens.index', compact('imagens'));
    }

    public function indexTable()
    {
    
        $imagens = Imagem::all();

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
        $imagem = Imagem::findOrFail($id); 
        return view('imagens.edit', compact('imagem'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255', 
            'valor' => 'required|numeric|min:0', 
        ]);

        $imagem = Imagem::findOrFail($id); 
        $imagem->nome = $request->input('nome'); 
        $imagem->valor = $request->input('valor'); 
        $imagem->save(); 

        return redirect()->route('imagens.table')->with('success', 'Registro atualizado com sucesso!');
    }
    
}
