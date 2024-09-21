<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    protected $table = 'imagens';

    protected $fillable = ['nome', 'imagem'];

    // Se você não quiser timestamps automáticos
    public $timestamps = true;
}
