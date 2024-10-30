<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagem; 

class PagamentoController extends Controller
{
    public function mostrarTelaDePagamento($id)
    {
        $imagem = Imagem::find($id); 
        return view('pagamento.pagamento', compact('imagem'));
    }

}
