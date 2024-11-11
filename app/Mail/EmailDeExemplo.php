<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailDeExemplo extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function build()
    {
        return $this->view('email.form')
                    ->from('sebo-magnata-0y@icloud.com', 'Vitor')
                    ->subject('Assunto do Email')
                    ->with(['dados' => $this->dados]);
    }
}
