<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageRealisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'realisation_id',
        'image_path',
    ];

    public function realisation()
    {
        return $this->belongsTo(Realisation::class);
    }
}
