<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\APropos;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AProposApiTest extends TestCase
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

    public function test_create_update_a_propos()
    {
        $headers = $this->authenticate();
        Storage::fake('public');

        $file = UploadedFile::fake()->image('apropos.jpg');

        $response = $this->postJson('/api/a-propos', [
            'titre' => 'À propos test',
            'description' => 'Description test',
            'image' => $file,
            'email' => 'contact@example.com'
        ], $headers);

        $response->assertStatus(201)
                 ->assertJsonFragment(['titre' => 'À propos test']);
    }

    public function test_get_a_propos()
    {
        $headers = $this->authenticate();

        $aPropos = APropos::create([
            'titre' => 'À propos test',
            'description' => 'Description test',
            'email' => 'contact@example.com'
        ]);

        $response = $this->getJson('/api/a-propos', $headers);

        $response->assertStatus(200)
                 ->assertJsonFragment(['titre' => $aPropos->titre]);
    }
}
