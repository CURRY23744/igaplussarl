<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'lieu',
        'date_realisation',
        'statut',
    ];

    public function images()
    {
        return $this->hasMany(ImageRealisation::class);
    }

     /**
     * Relation : une réalisation a plusieurs documents
     */
    public function documents()
    {
        return $this->hasMany(RealisationDocument::class);
    }
}
