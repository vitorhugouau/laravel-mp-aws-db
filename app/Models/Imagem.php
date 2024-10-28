<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    protected $table = 'imagens';

    // Adicionando 'valor' ao array $fillable
    protected $fillable = ['nome', 'imagem', 'valor']; 

    // Se você não quiser timestamps automáticos, defina como false
    public $timestamps = true;
}
