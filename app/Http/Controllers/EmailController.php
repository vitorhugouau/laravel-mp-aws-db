<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiteTemplateEmail;

class EmailController extends Controller
{
    // Exibe o formulário de envio de email
    public function showForm()
    {
        return view('email.form');
    }

    // Processa o envio do email com nome e mensagem
    public function sendEmail(Request $request)
    {
        $dados = [
            'nome' => $request->input('nome'),
            'mensagem' => $request->input('mensagem'),
        ];

        Mail::to($request->input('email'))->send(new SiteTemplateEmail($dados));

        return back()->with('success', 'Email enviado com sucesso!');
    }

    // Processa o envio do email com template do site
    public function sendTemplateEmail(Request $request)
    {
        $dados = [
            'nome' => $request->input('nome')
        ];

        Mail::to($request->input('email'))->send(new SiteTemplateEmail($dados));

        return back()->with('success', 'Email enviado com o template do site!');
    }
}
