<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealisationRequest;
use App\Models\Realisation;
use App\Models\ImageRealisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealisationController extends Controller
{
    public function index()
    {
        $realisations = Realisation::with('images')->get();
        return response()->json($realisations);
    }

    public function store(RealisationRequest $request)
    {
        $realisation = Realisation::create($request->validated());

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('realisations', 'public');
                ImageRealisation::create([
                    'realisation_id' => $realisation->id,
                    'image_path' => $path,
                ]);
            }
        }

        return response()->json($realisation, 201);
    }

    public function show($id)
    {
        $realisation = Realisation::with('images')->findOrFail($id);
        return response()->json($realisation);
    }

    public function update(RealisationRequest $request, $id)
    {
        $realisation = Realisation::findOrFail($id);
        $realisation->update($request->validated());
        return response()->json($realisation);
    }

    public function destroy($id)
    {
        $realisation = Realisation::findOrFail($id);
        $realisation->delete();
        return response()->json(['message' => 'Réalisation supprimée']);
    }

    public function addImage(Request $request, $id)
    {
        $realisation = Realisation::findOrFail($id);

        $request->validate([
            'image' => 'required|image|max:5120', // max 5MB
        ]);

        $image = $request->file('image');
        $path = $image->store('realisations', 'public');

        $imageRealisation = ImageRealisation::create([
            'realisation_id' => $realisation->id,
            'image_path' => $path,
        ]);

        return response()->json($imageRealisation, 201);
    }

    public function deleteImage($imageId)
    {
        $image = ImageRealisation::findOrFail($imageId);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json(['message' => 'Image supprimée avec succès']);
    }

    }
