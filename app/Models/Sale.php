<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_name', 'product_id', 'payment_id', 'status', 'value'];

    public function user()
    {
        return $this->belongsTo(Usuarios::class);
    }

    public function product()
    {
        return $this->belongsTo(Imagem::class);
    }
}

