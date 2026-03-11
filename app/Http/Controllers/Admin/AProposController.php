<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\APropos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AProposController extends Controller
{
    public function index()
    {
        $apropos = APropos::first();
        return view('admin.apropos.index', compact('apropos'));
    }

    public function create()
    {
        $apropos = APropos::first();
        if ($apropos) {
            return redirect()->route('admin.apropos.edit', $apropos->id);
        }
        return view('admin.apropos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'email'       => 'nullable|email|max:255',
            'whatsapp'    => 'nullable|string|max:50',
            'facebook'    => 'nullable|url|max:255',
            'instagram'   => 'nullable|url|max:255',
        ]);

        $data = $request->only(['titre', 'description', 'email', 'whatsapp', 'facebook', 'instagram']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('apropos', 'public');
        }

        APropos::create($data);

        return redirect()->route('admin.apropos.index')
                         ->with('success', 'Section À propos créée avec succès !');
    }

    public function edit($id)
    {
        $apropos = APropos::findOrFail($id);
        return view('admin.apropos.edit', compact('apropos'));
    }

    public function update(Request $request, $id)
    {
        $apropos = APropos::findOrFail($id);

        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'email'       => 'nullable|email|max:255',
            'whatsapp'    => 'nullable|string|max:50',
            'facebook'    => 'nullable|url|max:255',
            'instagram'   => 'nullable|url|max:255',
        ]);

        $data = $request->only(['titre', 'description', 'email', 'whatsapp', 'facebook', 'instagram']);

        if ($request->hasFile('image')) {
            if ($apropos->image && Storage::disk('public')->exists($apropos->image)) {
                Storage::disk('public')->delete($apropos->image);
            }
            $data['image'] = $request->file('image')->store('apropos', 'public');
        }

        $apropos->update($data);

        return redirect()->route('admin.apropos.index')
                         ->with('success', 'Section À propos mise à jour avec succès !');
    }
}