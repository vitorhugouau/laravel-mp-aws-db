<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    // Especificar os campos que podem ser preenchidos em massa
    protected $fillable = [
        'external_reference',
        'payer_name',
        'payer_email',
        'status',
    ];
}
