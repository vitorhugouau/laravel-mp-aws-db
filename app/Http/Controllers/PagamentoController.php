<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagem; // Supondo que você tenha um modelo de Imagem

class PagamentoController extends Controller
{
    public function mostrarTelaDePagamento($id)
    {
        $imagem = Imagem::find($id); // Encontra a imagem com base no ID
        return view('pagamento.pagamento', compact('imagem'));
    }

}
