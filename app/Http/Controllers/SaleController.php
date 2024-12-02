<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    
    public function index()
    {
        $sales = Sale::with('user')->get();
        return view('pagamento.sales', compact('sales')); 
    }

    public function create()
    {
        return view('sales.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:usuarios,id', 
            'product_id' => 'required|exists:imagens,id', 
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

    
    public function edit($id)
    {
        $sale = Sale::findOrFail($id); 
        return view('sales.edit', compact('sale')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:usuarios,id', 
            'product_id' => 'required|exists:imagens,id',
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

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso!');
    }
}
