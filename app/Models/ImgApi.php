<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgApi extends Model
{
    use HasFactory;
    
    protected $table = 'imgApi';

    protected $fillable = [
        'nome',
        'url_original',
        'url_marca_dagua',
        'valor',
    ];
    public $timestamps = true;
}
