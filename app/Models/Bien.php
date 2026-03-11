<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'type',
        'statut',
        'prix',
        'ville',
        'quartier',
        'description',
        'disponibilite',
        'contact_whatsapp',
        'contact_nom',
        'contact_email',
        'superficie',
        'nombre_chambres',
        'nombre_salles_bain',
        'nombre_cuisine',
        'nombre_salon',
        'etage',
        'parking',
        'piscine',
        'jardin',
        'meuble',
    ];

    // Relation : Un bien peut avoir plusieurs médias
    public function medias()
    {
        return $this->hasMany(ImageBien::class);
    }

    // Relation : une seule image principale
    public function mainImage()
    {
        return $this->hasOne(ImageBien::class)->where('is_main', true);
    }

    // Lien WhatsApp formaté
    public function getWhatsappLinkAttribute()
    {
        $number = preg_replace('/[^0-9]/', '', $this->contact_whatsapp);
        return "https://wa.me/{$number}";
    }
}
