<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BienRequest;
use App\Models\Bien;
use App\Models\ImageBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BienController extends Controller
{
    // 🔹 Liste des biens
    public function index()
    {
        $biens = Bien::with('medias')->latest()->get();
        return view('admin.biens.index', compact('biens'));
    }

    // 🔹 Formulaire de création
    public function create()
    {
        return view('admin.biens.create');
    }

    // 🔹 Stocker un nouveau bien
    public function store(BienRequest $request)
    {
        // Création du bien
        $bien = Bien::create($request->validated());

        // Upload médias
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $media) {
                $path = $media->store('biens', 'public');
                ImageBien::create([
                    'bien_id' => $bien->id,
                    'media_type' => $media->getClientOriginalExtension() === 'mp4' ? 'video' : 'image',
                    'media_path' => $path,
                    'is_main' => false,
                ]);
            }
        }

        // Rediriger vers la liste des biens
        return redirect()->route('admin.biens.index')
                         ->with('success', 'Bien créé avec succès !');
    }

    // 🔹 Formulaire d’édition
    public function edit(Bien $bien)
    {
        return view('admin.biens.edit', compact('bien'));
    }

    // 🔹 Mettre à jour le bien
    public function update(BienRequest $request, Bien $bien)
    {
        $bien->update($request->validated());

        // Upload nouveaux médias si présents
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $media) {
                $path = $media->store('biens', 'public');
                ImageBien::create([
                    'bien_id' => $bien->id,
                    'media_type' => $media->getClientOriginalExtension() === 'mp4' ? 'video' : 'image',
                    'media_path' => $path,
                    'is_main' => false,
                ]);
            }
        }

        return redirect()->route('admin.biens.index')
                         ->with('success', 'Bien mis à jour avec succès !');
    }

    // 🔹 Supprimer un bien
    public function destroy(Bien $bien)
    {
        // Supprimer les médias
        foreach ($bien->medias as $media) {
            if (Storage::disk('public')->exists($media->media_path)) {
                Storage::disk('public')->delete($media->media_path);
            }
            $media->delete();
        }

        $bien->delete();

        return redirect()->route('admin.biens.index')
                         ->with('success', 'Bien supprimé avec succès !');
    }

    public function deleteMedia(ImageBien $media)
    {
        // Supprimer le fichier
        if (Storage::disk('public')->exists($media->media_path)) {
            Storage::disk('public')->delete($media->media_path);
        }

        // Supprimer en base
        $media->delete();

        return redirect()->back()->with('success', 'Média supprimé avec succès.');
    }
}
