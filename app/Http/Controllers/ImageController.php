<?php

namespace App\Http\Controllers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\ImgApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
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

    
}
