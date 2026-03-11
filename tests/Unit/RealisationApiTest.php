<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Realisation;
use App\Models\ImageRealisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RealisationApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $admin = Admin::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('secret123')
        ]);

        $token = $admin->createToken('api_token')->plainTextToken;
        return ["Authorization" => "Bearer $token"];
    }

    public function test_create_realisation()
    {
        $headers = $this->authenticate();

        $response = $this->postJson('/api/realisations', [
            'titre' => 'Projet Test',
            'description' => 'Description du projet',
            'statut' => true
        ], $headers);

        $response->assertStatus(201)
                 ->assertJsonFragment(['titre' => 'Projet Test']);
    }

    public function test_add_delete_image()
    {
        $headers = $this->authenticate();
        Storage::fake('public');

        $real = Realisation::create([
            'titre' => 'Projet Test',
            'description' => 'Description du projet',
            'statut' => true
        ]);

        $file = UploadedFile::fake()->image('photo.jpg');
        $response = $this->postJson("/api/realisations/{$real->id}/images", ['image' => $file], $headers);
        $response->assertStatus(201)
                 ->assertJsonStructure(['id','realisation_id','image_path','created_at','updated_at']);

        $imageId = $response->json('id');
        $responseDel = $this->deleteJson("/api/realisations/images/{$imageId}", [], $headers);
        $responseDel->assertStatus(200)
                    ->assertJson(['message' => 'Image supprimée avec succès']);
    }
}
