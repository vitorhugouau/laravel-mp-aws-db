<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    // Lista todas as vendas
    // Lista todas as vendas com o usuário associado
    public function index()
    {
        $sales = Sale::with('user')->get(); // Carrega as vendas com os usuários associados
        return view('pagamento.sales', compact('sales')); // Certifique-se de que o nome da view está correto
    }


    // Exibe o formulário para criar uma nova venda
    public function create()
    {
        return view('sales.create'); // Crie uma view para o formulário de criação
    }

    // Armazena uma nova venda
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:usuarios,id', // Validação do usuário
            'product_id' => 'required|exists:imagens,id', // Validação do produto
            'payment_id' => 'required|string',
            'status' => 'required|string',
        ]);

        Sale::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'payment_id' => $request->payment_id,
            'status' => $request->status,
        ]);

        return redirect()->route('sales.index')->with('success', 'Venda criada com sucesso!');
    }

    // Exibe o formulário para editar uma venda existente
    public function edit($id)
    {
        $sale = Sale::findOrFail($id); // Recupera a venda pelo ID
        return view('sales.edit', compact('sale')); // Crie uma view para o formulário de edição
    }

    // Atualiza uma venda existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:usuarios,id', // Validação do usuário
            'product_id' => 'required|exists:imagens,id', // Validação do produto
            'payment_id' => 'required|string',
            'status' => 'required|string',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'payment_id' => $request->payment_id,
            'status' => $request->status,
        ]);

        return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso!');
    }

    // Exclui uma venda existente
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso!');
    }
}
