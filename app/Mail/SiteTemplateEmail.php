<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiteTemplateEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;

    public function __construct($dados)
    {
        $this->dados = $dados; // Agora aceita um array de dados
    }

    public function build()
    {
        return $this->view('email.site_template')
                    ->subject('Bem-vindo ao Nosso Site')
                    ->with('dados', $this->dados); // Passa os dados para a view
    }
}
