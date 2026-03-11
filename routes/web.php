<?php

use App\Models\Bien;
use App\Models\Realisation;
use App\Models\APropos;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthAdminController;
use App\Http\Controllers\Admin\BienController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RealisationController;
use App\Http\Controllers\Admin\AProposController;

/*
|--------------------------------------------------------------------------
| Routes visiteurs
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $biens = Bien::latest()->take(3)->get();
    $realisations = Realisation::latest()->take(3)->get();
    $apropos = APropos::first();

    return view('visitor.home', compact('biens', 'realisations', 'apropos'));
})->name('home');

Route::get('/biens', function (Request $request) {
    $query = Bien::query();

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('ville', 'like', '%' . $request->search . '%')
              ->orWhere('quartier', 'like', '%' . $request->search . '%')
              ->orWhere('titre', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('prix_max')) {
        $query->where('prix', '<=', $request->prix_max);
    }

    $biens = $query->with('medias')->latest()->get();

    return view('visitor.biens', compact('biens'));
})->name('biens');

Route::get('/biens/{bien}', function (Bien $bien) {
    $bien->load('medias');
    return view('visitor.bien-detail', compact('bien'));
})->name('biens.show');

Route::get('/realisations', function () {
    $realisations = Realisation::with('images')->get();
    return view('visitor.realisations', compact('realisations'));
})->name('realisations');
$realisations = Realisation::with(['images', 'documents'])->get();

Route::get('/a-propos', function () {
    $apropos = APropos::first();
    return view('visitor.apropos', compact('apropos'));
})->name('apropos');

/*
|--------------------------------------------------------------------------
| Routes Admin (authentification)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', [AuthAdminController::class, 'loginWeb'])
    ->name('admin.login.post');

Route::get('/admin/forgot-password', function () {
    return view('admin.forgot-password');
})->name('admin.forgot-password');

Route::post('/admin/forgot-password', [AuthAdminController::class, 'forgotPassword'])
    ->name('admin.forgot-password.post');

Route::get('/admin/reset-password/{token}', function ($token) {
    return view('admin.reset-password', compact('token'));
})->name('admin.reset-password');

Route::post('/admin/reset-password', [AuthAdminController::class, 'resetPassword'])
    ->name('admin.reset-password.post');

/*
|--------------------------------------------------------------------------
| Routes Admin protégées (dashboard + CRUDs)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth:admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Logout
    Route::post('/logout', function () {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('admin.logout');

    // ── Biens ──────────────────────────────────────────────────────────────
    Route::get('biens', [BienController::class, 'index'])->name('admin.biens.index');
    Route::get('biens/create', [BienController::class, 'create'])->name('admin.biens.create');
    Route::post('biens', [BienController::class, 'store'])->name('admin.biens.store');
    Route::get('biens/{bien}/edit', [BienController::class, 'edit'])->name('admin.biens.edit');
    Route::put('biens/{bien}', [BienController::class, 'update'])->name('admin.biens.update');
    Route::delete('biens/{bien}', [BienController::class, 'destroy'])->name('admin.biens.destroy');
    Route::delete('biens/medias/{media}', [BienController::class, 'deleteMedia'])
        ->name('admin.biens.deleteMedia');

    // ── Réalisations ───────────────────────────────────────────────────────
    // ⚠️ Les routes spécifiques (images, documents) AVANT la route {id}
    // pour éviter que Laravel interprète "images" ou "documents" comme un {id}
    Route::delete('realisations/images/{id}', [RealisationController::class, 'deleteImage'])
        ->name('admin.realisations.deleteImage');
    Route::delete('realisations/documents/{id}', [RealisationController::class, 'deleteDocument'])
        ->name('admin.realisations.deleteDocument');

    Route::get('realisations', [RealisationController::class, 'index'])->name('admin.realisations.index');
    Route::get('realisations/create', [RealisationController::class, 'create'])->name('admin.realisations.create');
    Route::post('realisations', [RealisationController::class, 'store'])->name('admin.realisations.store');
    Route::get('realisations/{id}/edit', [RealisationController::class, 'edit'])->name('admin.realisations.edit');
    Route::put('realisations/{id}', [RealisationController::class, 'update'])->name('admin.realisations.update');
    Route::delete('realisations/{id}', [RealisationController::class, 'destroy'])->name('admin.realisations.destroy');

    // ── À propos ───────────────────────────────────────────────────────────
    Route::get('apropos', [AProposController::class, 'index'])->name('admin.apropos.index');
    Route::get('apropos/create', [AProposController::class, 'create'])->name('admin.apropos.create');
    Route::post('apropos', [AProposController::class, 'store'])->name('admin.apropos.store');
    Route::get('apropos/{id}/edit', [AProposController::class, 'edit'])->name('admin.apropos.edit');
    Route::put('apropos/{id}', [AProposController::class, 'update'])->name('admin.apropos.update');
});