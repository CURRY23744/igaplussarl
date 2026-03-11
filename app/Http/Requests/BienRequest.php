<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BienRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    $rules = [
        'titre' => 'required|string|max:255',
        'type' => 'required|in:Terrain,Maison,Appartement,Villa',
        'statut' => 'required|in:À vendre,À louer',
        'prix' => 'required|integer',
        'ville' => 'required|string|max:255',
        'quartier' => 'required|string|max:255',
        'description' => 'required|string',
        'contact_whatsapp' => 'required|string',
        'medias' => 'nullable|array',
        'medias.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240', // max 10MB
    ];

    switch ($this->type) {
        case 'Terrain':
            $rules['superficie'] = 'required|numeric';
            break;

        case 'Appartement':
            $rules['nombre_chambres'] = 'required|integer';
            $rules['nombre_salles_bain'] = 'required|integer';
            $rules['etage'] = 'required|integer';
            break;

        case 'Villa':
            $rules['nombre_chambres'] = 'required|integer';
            $rules['nombre_salles_bain'] = 'required|integer';
            $rules['nombre_cuisine'] = 'required|integer';
            $rules['nombre_salon'] = 'required|integer';
            break;
    }

    return $rules;
}
}
