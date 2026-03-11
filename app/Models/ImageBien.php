<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageBien extends Model
{
    use HasFactory;

    protected $fillable = [
        'bien_id',
        'media_type',
        'media_path',
        'is_main',
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}
