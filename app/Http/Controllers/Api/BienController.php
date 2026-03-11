<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BienRequest;
use App\Models\Bien;
use App\Models\ImageBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BienController extends Controller
{
    // 🔹 Liste de tous les biens
    public function index()
    {
        $biens = Bien::with('medias')->get();
        return response()->json($biens);
    }

    // 🔹 Création d’un bien
    public function store(BienRequest $request)
    {
        $bien = Bien::create($request->validated());

        // Upload images/videos
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $media) {
                $path = $media->store('biens', 'public');
                ImageBien::create([
                    'bien_id' => $bien->id,
                    'media_type' => $media->getClientOriginalExtension() === 'mp4' ? 'video' : 'image',
                    'media_path' => $path,
                    'is_main' => false, // optionnel : tu peux ajouter une logique pour la principale
                ]);
            }
        }

        return response()->json($bien, 201);
    }

    // 🔹 Détail d’un bien
    public function show($id)
    {
        $bien = Bien::with('medias')->findOrFail($id);
        return response()->json($bien);
    }

    // 🔹 Update
    public function update(BienRequest $request, $id)
    {
        $bien = Bien::findOrFail($id);
        $bien->update($request->validated());
        return response()->json($bien);
    }

    // 🔹 Supprimer
    public function destroy($id)
    {
        $bien = Bien::findOrFail($id);
        $bien->delete();
       return response()->json(['message' => 'Bien supprimé avec succès'], 200);
    }

public function setMainImage(Request $request, $id)
{
    $request->validate([
        'image_id' => 'required|exists:image_biens,id',
    ]);

    $bien = Bien::findOrFail($id);

    // Mettre à false toutes les images
    $bien->medias()->update(['is_main' => false]);

    // Mettre à true l'image choisie
    $image = ImageBien::findOrFail($request->image_id);
    $image->is_main = true;
    $image->save();

    return response()->json([
        'message' => 'Image principale définie avec succès',
        'main_image' => $image,
    ]);
}

public function addMedia(Request $request, $id)
{
    $bien = Bien::findOrFail($id);

    $request->validate([
        'media' => 'required|file|mimes:jpg,jpeg,png,mp4|max:10240', // max 10MB
    ]);

    $media = $request->file('media');
    $path = $media->store('biens', 'public');

    $imageBien = ImageBien::create([
        'bien_id' => $bien->id,
        'media_type' => $media->getClientOriginalExtension() === 'mp4' ? 'video' : 'image',
        'media_path' => $path,
        'is_main' => false,
    ]);

    return response()->json($imageBien, 201);
}

public function deleteMedia($mediaId)
{
    $media = ImageBien::findOrFail($mediaId);

    // Supprimer le fichier physique
    if (Storage::disk('public')->exists($media->media_path)) {
        Storage::disk('public')->delete($media->media_path);
    }

    $media->delete();

    return response()->json(['message' => 'Média supprimé avec succès']);
}

}
