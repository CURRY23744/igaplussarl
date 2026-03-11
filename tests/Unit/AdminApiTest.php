<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login()
    {
        $admin = Admin::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => 'secret123',
        ]);

        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'admin' => ['id','name','email','created_at','updated_at'],
                     'token'
                 ]);
    }

    public function test_admin_logout()
    {
        $admin = Admin::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => 'secret123',
        ]);

        $token = $admin->createToken('api_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/admin/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Déconnexion réussie']);
    }

        public function test_admin_can_request_password_reset()
    {
        $admin = Admin::create([
            'name' => 'Test',
            'email' => 'admin@test.com',
            'password' => 'secret123', // mutator va hasher
        ]);

        $response = $this->postJson('/api/admin/forgot-password', [
            'email' => 'admin@test.com'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message',
                    'reset_token'
                ]);

        $this->assertDatabaseHas('admins', [
            'email' => 'admin@test.com',
        ]);
    }
    public function test_admin_can_reset_password()
    {
        $admin = Admin::create([
            'name' => 'Test',
            'email' => 'admin@test.com',
            'password' => 'secret123',
        ]);

        // 🔹 On génère le token
        $response = $this->postJson('/api/admin/forgot-password', [
            'email' => 'admin@test.com'
        ]);

        $token = $response->json('reset_token');

        // 🔹 On reset le password
        $resetResponse = $this->postJson('/api/admin/reset-password', [
            'token' => $token,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ]);

        $resetResponse->assertStatus(200)
                    ->assertJson([
                        'message' => 'Mot de passe réinitialisé avec succès'
                    ]);

        // 🔹 Vérifier que l'ancien password ne marche plus
        $loginFail = $this->postJson('/api/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'secret123'
        ]);

        $loginFail->assertStatus(401);

        // 🔹 Vérifier que le nouveau marche
        $loginSuccess = $this->postJson('/api/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'newpassword'
        ]);

        $loginSuccess->assertStatus(201);
    }

}
