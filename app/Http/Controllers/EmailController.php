<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiteTemplateEmail;

class EmailController extends Controller
{
   
    public function showForm()
    {
        return view('email.form');
    }

   
    public function sendEmail(Request $request)
    {
        $dados = [
            'nome' => $request->input('nome'),
            'mensagem' => $request->input('mensagem'),
        ];

        Mail::to($request->input('email'))->send(new SiteTemplateEmail($dados));

        return back()->with('success', 'Email enviado com sucesso!');
    }

   
    public function sendTemplateEmail(Request $request)
    {
        $dados = [
            'nome' => $request->input('nome')
        ];

        Mail::to($request->input('email'))->send(new SiteTemplateEmail($dados));

        return back()->with('success', 'Email enviado com o template do site!');
    }
}
