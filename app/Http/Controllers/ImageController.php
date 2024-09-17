<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function gerarImagemComMarcaDAgua()
    {
        // Caminho da imagem original
        $imageFile = public_path('../../assets/img/imgnovas/praia.JPG');
        // Caminho da marca d'água
        $watermarkFile = public_path('images/image.png');

        // Verifica se a imagem e a marca d'água existem
        if (!file_exists($imageFile) || !file_exists($watermarkFile)) {
            abort(404, 'Imagem ou marca d\'água não encontrada.');
        }

        // Criar imagem a partir dos arquivos
        $image = imagecreatefrompng($imageFile);
        $watermark = imagecreatefrompng($watermarkFile);

        // Pega as dimensões da marca d'água
        $watermarkWidth = imagesx($watermark);
        $watermarkHeight = imagesy($watermark);

        // Copiar a marca d'água sobre a imagem (ajustando as coordenadas conforme necessário)
        imagecopy($image, $watermark, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight);

        // Definir o cabeçalho para retorno de imagem
        header('Content-type: image/png');

        // Gerar a imagem de saída
        imagepng($image);

        // Limpar a memória
        imagedestroy($image);
        imagedestroy($watermark);
    }
}
