<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    // 🔹 Login
    public function login(AdminLoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
        'admin' => $admin,
        'token' => $token,
    ], 201);

    }

    // 🔹 Logout
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }

    public function forgotPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return response()->json(['message' => 'Email introuvable'], 404);
    }

    $token = Str::random(60);

    $admin->update([
        'password_reset_token' => $token,
        'password_reset_expires' => Carbon::now()->addMinutes(30),
    ]);

    // 🔥 Pour test API on retourne le token
    return response()->json([
        'message' => 'Token généré avec succès',
        'reset_token' => $token
    ], 200);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'password' => 'required|min:8|confirmed'
    ]);

    $admin = Admin::where('password_reset_token', $request->token)
        ->where('password_reset_expires', '>', Carbon::now())
        ->first();

    if (!$admin) {
        return response()->json(['message' => 'Token invalide ou expiré'], 400);
    }

    $admin->update([
        'password' => $request->password, // mutator va hasher
        'password_reset_token' => null,
        'password_reset_expires' => null,
    ]);

    return response()->json([
        'message' => 'Mot de passe réinitialisé avec succès'
    ], 200);
}
public function loginWeb(Request $request)
{
    $admin = \App\Models\Admin::where('email', $request->email)->first();

    if (!$admin || !\Hash::check($request->password, $admin->password)) {
        return back()->with('error', 'Email ou mot de passe incorrect');
    }

    auth()->guard('admin')->login($admin);

    return redirect()->route('admin.dashboard');
}

}
