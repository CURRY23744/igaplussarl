<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APropos extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'image',
        'email',
        'whatsapp',
        'facebook',
        'instagram',
    ];
}
