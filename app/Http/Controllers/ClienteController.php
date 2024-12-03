<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
{
    $clientes = Cliente::all();  
    return view('clientes.create', compact('clientes'));
}

public function index2()
{
    $clientes = Cliente::all();  
    return view('clientes.index', compact('clientes'));
}


public function destroy($id)
{
    $cliente = Cliente::findOrFail($id);
    $cliente->delete();
    return redirect()->route('clientes.index2')->with('success', 'Registro deletado com sucesso.');
}


    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);  
        return view('clientes.edit', compact('cliente'));
    }
    

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        return redirect()->route('clientes.index2')->with('success');
    }
    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'cpf' => 'required|string|max:20',
        'datadenascimento' => 'required|date',
        'sexo' => 'required|string|max:1',
        'estadocivil' => 'required|string|max:50',
        'estado' => 'required|string|max:50',
        'logradouro' => 'required|string|max:255',
        'numero' => 'required|string|max:10',
        'complemento' => 'nullable|string|max:255',
        'cidade' => 'required|string|max:100',
        'email' => 'required|email|max:255',
    ]);

    
    Cliente::create($request->all());

    return redirect()->route('biblioteca')->with('success', 'Cliente inserido com sucesso.');
}

}
