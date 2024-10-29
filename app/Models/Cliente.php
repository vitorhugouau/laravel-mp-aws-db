<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Define a tabela associada, caso o nome da tabela seja diferente do plural do modelo (opcional)
    protected $table = 'clientes';

    // Defina os campos que podem ser atribuídos em massa
    protected $fillable = [
        'nome',
        'cpf',
        'datadenascimento',
        'sexo',
        'estadocivil',
        'estado',
        'logradouro',
        'numero',
        'complemento',
        'cidade',
        'email'
    ];
}
