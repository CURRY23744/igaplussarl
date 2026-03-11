<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthAdminController;
use App\Http\Controllers\Api\BienController;
use App\Http\Controllers\Api\RealisationController;
use App\Http\Controllers\Api\AProposController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes API explicites pour le projet immobilier.
|
*/

// 🔹 Auth Admin (connexion)
Route::post('admin/login', [AuthAdminController::class, 'login']);
Route::post('/admin/forgot-password', [AuthAdminController::class, 'forgotPassword']);
Route::post('/admin/reset-password', [AuthAdminController::class, 'resetPassword']); 

// 🔹 Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // 🔹 Admin logout
    Route::post('admin/logout', [AuthAdminController::class, 'logout']);

    // 🔹 Biens CRUD
    Route::get('biens', [BienController::class, 'index']);           // Lister tous les biens
    Route::post('biens', [BienController::class, 'store']);          // Créer un bien
    Route::get('biens/{id}', [BienController::class, 'show']);       // Détail d’un bien
    Route::put('biens/{id}', [BienController::class, 'update']);     // Mettre à jour un bien
    Route::patch('biens/{id}', [BienController::class, 'update']);   // Mettre à jour partiellement
    Route::delete('biens/{id}', [BienController::class, 'destroy']); // Supprimer un bien
    Route::post('biens/{bien}/set-main-image', [BienController::class, 'setMainImage']);
    // Ajouter un média à un bien
    Route::post('biens/{bien}/medias', [BienController::class, 'addMedia']);

    // Supprimer un média d’un bien
    Route::delete('biens/medias/{media}', [BienController::class, 'deleteMedia']);


    // 🔹 Réalisations CRUD
    Route::get('realisations', [RealisationController::class, 'index']);         // Liste
    Route::post('realisations', [RealisationController::class, 'store']);        // Créer
    Route::get('realisations/{id}', [RealisationController::class, 'show']);    // Détail
    Route::put('realisations/{id}', [RealisationController::class, 'update']);  // Update
    Route::patch('realisations/{id}', [RealisationController::class, 'update']); // Update partiel
    Route::delete('realisations/{id}', [RealisationController::class, 'destroy']); // Supprimer
    // Ajouter une image à une réalisation
    Route::post('realisations/{realisation}/images', [RealisationController::class, 'addImage']);

    // Supprimer une image d'une réalisation
    Route::delete('realisations/images/{image}', [RealisationController::class, 'deleteImage']);


    // 🔹 Section À propos
    Route::get('a-propos', [AProposController::class, 'index']);       // Récupérer l’unique enregistrement
    Route::post('a-propos', [AProposController::class, 'store']);      // Créer / mettre à jour
    Route::get('a-propos/{id}', [AProposController::class, 'show']);   // Détail (optionnel)

     Route::delete('realisations/images/{image}', [RealisationController::class, 'deleteImage'])
         ->name('realisations.deleteImage');

    Route::delete('realisations/documents/{document}', [RealisationController::class, 'deleteDocument'])
         ->name('realisations.deleteDocument');

    Route::resource('realisations', RealisationController::class);

    
});
