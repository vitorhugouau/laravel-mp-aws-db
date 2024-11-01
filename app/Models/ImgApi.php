<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgApi extends Model
{
    use HasFactory;

    // Define a tabela associada a este model
    protected $table = 'imgApi';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'url_original',
        'url_marca_dagua',
        'valor',
    ];
}
