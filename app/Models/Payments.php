<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_reference',
        'payer_name',
        'payer_email',
        'status',
        'imagem_id', 
        'user_id',  
    ];

    // Relacionamento correto com Usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'user_id'); // Relacionamento correto com user_id
    }

}
