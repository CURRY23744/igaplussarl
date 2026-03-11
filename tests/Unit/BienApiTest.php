<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Bien;
use App\Models\ImageBien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BienApiTest extends TestCase
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

    public function test_create_bien()
    {
        $headers = $this->authenticate();

        $response = $this->postJson('/api/biens', [
            'titre' => 'Maison Test',
            'type' => 'Maison',
            'statut' => 'À vendre',
            'prix' => 500000,
            'ville' => 'Lomé',
            'quartier' => 'Tokoin',
            'description' => 'Belle maison test',
            'contact_whatsapp' => '22890000000',
            'disponibilite' => true
        ], $headers);

        $response->assertStatus(201)
                 ->assertJsonFragment(['titre' => 'Maison Test']);
    }

    public function test_get_biens()
    {
        $headers = $this->authenticate();

        Bien::create([
            'titre' => 'Maison 1',
            'type' => 'Maison',
            'statut' => 'À vendre',
            'prix' => 400000,
            'ville' => 'Lomé',
            'quartier' => 'Tokoin',
            'description' => 'Maison test',
            'contact_whatsapp' => '22890000000',
            'disponibilite' => true
        ]);

        $response = $this->getJson('/api/biens', $headers);
        $response->assertStatus(200)
                 ->assertJsonCount(1);
    }

    public function test_update_bien()
    {
        $headers = $this->authenticate();
        $bien = Bien::create([
            'titre' => 'Maison 1',
            'type' => 'Maison',
            'statut' => 'À vendre',
            'prix' => 400000,
            'ville' => 'Lomé',
            'quartier' => 'Tokoin',
            'description' => 'Maison test',
            'contact_whatsapp' => '22890000000',
            'disponibilite' => true
        ]);

        $response = $this->putJson("/api/biens/{$bien->id}", [
            'titre' => 'Maison Modifiée',
            'type' => $bien->type,
            'statut' => $bien->statut,
            'prix' => $bien->prix,
            'ville' => $bien->ville,
            'quartier' => $bien->quartier,
            'description' => $bien->description,
            'contact_whatsapp' => $bien->contact_whatsapp,
            'disponibilite' => $bien->disponibilite
        ], $headers);

        $response->assertStatus(200)
                 ->assertJsonFragment(['titre' => 'Maison Modifiée']);
    }

    public function test_delete_bien()
    {
        $headers = $this->authenticate();
        $bien = Bien::create([
            'titre' => 'Maison 1',
            'type' => 'Maison',
            'statut' => 'À vendre',
            'prix' => 400000,
            'ville' => 'Lomé',
            'quartier' => 'Tokoin',
            'description' => 'Maison test',
            'contact_whatsapp' => '22890000000',
            'disponibilite' => true
        ]);

        $response = $this->deleteJson("/api/biens/{$bien->id}", [], $headers);
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Bien supprimé avec succès']);
    }

    public function test_add_delete_media()
    {
        $headers = $this->authenticate();
        Storage::fake('public');

        $bien = Bien::create([
            'titre' => 'Maison 1',
            'type' => 'Maison',
            'statut' => 'À vendre',
            'prix' => 400000,
            'ville' => 'Lomé',
            'quartier' => 'Tokoin',
            'description' => 'Maison test',
            'contact_whatsapp' => '22890000000',
            'disponibilite' => true
        ]);

        $file = UploadedFile::fake()->image('photo.jpg');
        $response = $this->postJson("/api/biens/{$bien->id}/medias", ['media' => $file], $headers);
        $response->assertStatus(201)
                 ->assertJsonStructure(['id','bien_id','media_type','media_path','is_main','created_at','updated_at']);

        $mediaId = $response->json('id');
        $responseDel = $this->deleteJson("/api/biens/medias/{$mediaId}", [], $headers);
        $responseDel->assertStatus(200)
                    ->assertJson(['message' => 'Média supprimé avec succès']);
    }
}
