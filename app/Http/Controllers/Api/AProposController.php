<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\APropos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AProposController extends Controller
{
    // 🔹 Récupérer le contenu "À propos"
    public function index()
    {
        $aPropos = APropos::first(); // un seul enregistrement
        return response()->json($aPropos);
    }

    // 🔹 Créer ou mettre à jour
   public function store(Request $request)
{
    $data = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'email' => 'nullable|email',
        'whatsapp' => 'nullable|string',
        'facebook' => 'nullable|string',
        'instagram' => 'nullable|string',
    ]);

    // Gestion de l'image
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('a_propos', 'public');
        $data['image'] = $path;
    }

    $aPropos = APropos::first();

    if ($aPropos) {
        $aPropos->update($data);
        $status = 200; // update
    } else {
        $aPropos = APropos::create($data);
        $status = 201; // create
    }

    return response()->json($aPropos, $status);
}


    // 🔹 Afficher le détail (optionnel si besoin)
    public function show($id)
    {
        $aPropos = APropos::findOrFail($id);
        return response()->json($aPropos);
    }
}
