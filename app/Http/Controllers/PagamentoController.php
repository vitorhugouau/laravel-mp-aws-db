<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagem; 
use App\Models\ImgApi;
class PagamentoController extends Controller
{
    public function mostrarTelaDePagamento($id)
    {
        $imagem = ImgApi::find($id); 
        return view('pagamento.pagamento', compact('imagem'));
    }

}
