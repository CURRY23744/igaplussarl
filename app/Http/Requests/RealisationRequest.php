<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RealisationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'lieu' => 'nullable|string|max:255',
            'date_realisation' => 'nullable|date',
            'statut' => 'required|boolean',
        ];
    }
}
