<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImgApi;
use App\Models\Desconto;
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


        $uploadedFileOriginal = Cloudinary::upload($request->file('image')->getRealPath());
        $urlOriginal = $uploadedFileOriginal->getSecurePath();

        $uploadedFileWatermarked = Cloudinary::upload($request->file('image')->getRealPath(), [
            'transformation' => [
                'overlay' => 'imagem_principal',
                'gravity' => 'center',
                'x' => 100,
                'y' => 100,
                'opacity' => 50,
            ],
            'folder' => 'watermarked_images',
            'public_id' => uniqid() . '_watermarked'
        ]);
        $urlMarcaDagua = $uploadedFileWatermarked->getSecurePath();

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

        $urlMarcaDaguaBanner = ImgApi::whereBetween('id', [8, 11])->get();

        $urlMarcaDaguaMeio = ImgApi::whereBetween('id', [1, 4])->get();

        $urlMarcaDaguaVenda = ImgApi::whereBetween('id', [6, 8])->get();

        $urlMarcaDaguaFinal = ImgApi::whereBetween('id', [7, 11])->get();

        foreach ($urlMarcaDaguaVenda as $imagem) {
            $imagem->valor_parcelado = $imagem->valor / 10; // Divide o valor por 12
        }

        // $discounts = Desconto::inRandomOrder()->first()->valores;
        $discounts = Desconto::whereBetween('id', [8, 8])->get();

        $discountValue = $discounts->random();



        return view('biblioteca.biblioteca', compact(
            'urlMarcaDagua',
            'urlMarcaDaguaBanner',
            'urlMarcaDaguaVenda',
            'urlMarcaDaguaMeio',
            'urlMarcaDaguaFinal',
            'discountValue'
        ));

    }



    // public function showDiscount()
    // {

    //     $discountValue = Desconto::inRandomOrder()->first();

    //     return view('biblioteca.biblioteca', compact('discountValue'));
    // }
}