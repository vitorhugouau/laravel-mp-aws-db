<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImgApi;

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

        ImgApi::create([
            'nome' => $nomeImagem,
            'imagem' => $imagemBase64, 
            'valor' => $request->input('valor'), 
        ]);

        return redirect()->route('control')->with('success', 'ImgApi enviada com sucesso!');
    }

    public function show($id)
    {
        $imagem = ImgApi::findOrFail($id);

        return response($imagem->url_original)
            ->header('Content-Type', 'image/jpeg'); 
    }

    public function index()
    {
        
        $imagens = ImgApi::all();

        return view('imagens.index', compact('imagens'));
    }

    public function indexTable()
    {
    
        $imagens = ImgApi::all();

        return view('imagens.table', compact('imagens'));
    }

    public function destroy($id)
    {
        $imagem = ImgApi::findOrFail($id);
        $imagem->delete();
        return redirect()->route('imagens.table')->with('success', 'ImgApi excluída com sucesso.');
    }

    public function edit($id)
    {
        $imagem = ImgApi::findOrFail($id); 
        return view('imagens.edit', compact('imagem'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255', 
            'valor' => 'required|numeric|min:0', 
        ]);

        $imagem = ImgApi::findOrFail($id); 
        $imagem->nome = $request->input('nome'); 
        $imagem->valor = $request->input('valor'); 
        $imagem->save(); 

        return redirect()->route('imagens.table')->with('success', 'Registro atualizado com sucesso!');
    }
    
}
