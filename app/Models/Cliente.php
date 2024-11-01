<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

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
