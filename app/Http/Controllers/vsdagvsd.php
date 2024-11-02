<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImgApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class ImageUploadController extends Controller
{
    protected function authenticate()
    {
        $cloudinaryUrl = env('CLOUDINARY_URL');
        $cloudinaryKey = env('CLOUDINARY_API_KEY');

        if ($cloudinaryUrl && $cloudinaryKey) {
            Log::info("Configuração do Cloudinary carregada com sucesso.");
        } else {
            throw new \Exception("A URL do Cloudinary não está definida no arquivo .env.");
        }
    }
    public function upload(Request $request)
    {
        $nomeImagem = $request->file('image')->getClientOriginalName();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'nome' => $nomeImagem,
            'valor' => 'required|numeric',
        ]);

        // Upload da imagem original para o Cloudinary
        $uploadedFileOriginal = Cloudinary::upload($request->file('image')->getRealPath());
        $urlOriginal = $uploadedFileOriginal->getSecurePath();

        // Upload da imagem com marca d'água, criando uma versão diferente
        $uploadedFileWatermarked = Cloudinary::upload($request->file('image')->getRealPath(), [
            'transformation' => [
                'overlay' => 'imagem_principal',  // substitua pelo ID da marca d'água no Cloudinary
                'gravity' => 'center',           // posição da marca d'água
                'x' => 10,
                'y' => 10,
                'opacity' => 60,
            ],
            'folder' => 'watermarked_images',        // opção para salvar em pasta específica
            'public_id' => uniqid() . '_watermarked' // identificador único para a imagem com marca d'água
        ]);
        $urlMarcaDagua = $uploadedFileWatermarked->getSecurePath();

        // Salva as informações no banco de dados
        ImgApi::create([
            'nome' => $nomeImagem,
            'url_original' => $urlOriginal,
            'url_marca_dagua' => $urlMarcaDagua,
            'valor' => $request->valor,
        ]);

        return redirect()->route('control')->with('success', 'Imagem enviada com sucesso!');
    }
    public function indexTable2()
    {
    
        $urlMarcaDagua = ImgApi::all();

        return view('biblioteca.biblioteca', compact('urlMarcaDagua'));
    }
}