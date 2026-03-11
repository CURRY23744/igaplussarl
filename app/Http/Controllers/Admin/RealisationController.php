<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Realisation;
use App\Models\ImageRealisation;
use App\Models\RealisationDocument;
use Illuminate\Support\Facades\Storage;

class RealisationController extends Controller
{
    // ─── Liste des réalisations ───────────────────────────────────────────────
    public function index()
    {
        $realisations = Realisation::with(['images', 'documents'])->latest()->paginate(9);
        return view('admin.realisations.index', compact('realisations'));
    }

    // ─── Formulaire de création ───────────────────────────────────────────────
    public function create()
    {
        return view('admin.realisations.create');
    }

    // ─── Stocker une réalisation ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'images.*'     => 'nullable|image|max:5120',
            'documents.*'  => 'nullable|file|max:10240',
        ]);

        $realisation = Realisation::create($request->only('titre', 'description'));

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('realisations', 'public');
                ImageRealisation::create([
                    'realisation_id' => $realisation->id,
                    'image_path'     => $path,
                ]);
            }
        }

        // Upload documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('realisations/documents', 'public');
                RealisationDocument::create([
                    'realisation_id' => $realisation->id,
                    'file_path'      => $path,
                    'file_name'      => $document->getClientOriginalName(),
                    'file_type'      => $document->getMimeType(),
                    'file_size'      => $document->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.realisations.index')
                         ->with('success', 'Réalisation créée avec succès');
    }

    // ─── Formulaire d'édition ─────────────────────────────────────────────────
    public function edit($id)
    {
        $realisation = Realisation::with(['images', 'documents'])->findOrFail($id);
        return view('admin.realisations.edit', compact('realisation'));
    }

    // ─── Mettre à jour ────────────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $realisation = Realisation::findOrFail($id);

        $request->validate([
            'titre'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'images.*'     => 'nullable|image|max:5120',
            'documents.*'  => 'nullable|file|max:10240',
        ]);

        $realisation->update($request->only('titre', 'description'));

        // Upload nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('realisations', 'public');
                ImageRealisation::create([
                    'realisation_id' => $realisation->id,
                    'image_path'     => $path,
                ]);
            }
        }

        // Upload nouveaux documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('realisations/documents', 'public');
                RealisationDocument::create([
                    'realisation_id' => $realisation->id,
                    'file_path'      => $path,
                    'file_name'      => $document->getClientOriginalName(),
                    'file_type'      => $document->getMimeType(),
                    'file_size'      => $document->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.realisations.index')
                         ->with('success', 'Réalisation mise à jour avec succès');
    }

    // ─── Supprimer une réalisation ────────────────────────────────────────────
    public function destroy($id)
    {
        $realisation = Realisation::with(['images', 'documents'])->findOrFail($id);

        // Supprimer les images du stockage
        foreach ($realisation->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Supprimer les documents du stockage
        foreach ($realisation->documents as $document) {
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();
        }

        $realisation->delete();

        return redirect()->route('admin.realisations.index')
                         ->with('success', 'Réalisation supprimée avec succès');
    }

    // ─── Supprimer une image spécifique ──────────────────────────────────────
    public function deleteImage($imageId)
    {
        $image = ImageRealisation::findOrFail($imageId);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Image supprimée avec succès');
    }

    // ─── Supprimer un document spécifique ────────────────────────────────────
    public function deleteDocument($documentId)
    {
        $document = RealisationDocument::findOrFail($documentId);

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document supprimé avec succès');
    }
}