<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_via_api(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User', 'email' => 'test@example.com',
            'password' => 'password', 'password_confirmation' => 'password',
        ]);
        $response->assertStatus(201)->assertJsonStructure(['message', 'user', 'token']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login_via_api(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);
        $response = $this->postJson('/api/v1/auth/login', ['email' => $user->email, 'password' => 'password']);
        $response->assertOk()->assertJsonStructure(['message', 'user', 'token']);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/v1/auth/login', ['email' => $user->email, 'password' => 'wrong']);
        $response->assertStatus(422);
    }

    public function test_user_can_logout_via_api(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $response = $this->withHeader('Authorization', "Bearer {$token}")->postJson('/api/v1/auth/logout');
        $response->assertOk();
    }

    public function test_user_can_get_own_profile(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $response = $this->withHeader('Authorization', "Bearer {$token}")->getJson('/api/v1/auth/user');
        $response->assertOk()->assertJsonFragment(['email' => $user->email]);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $this->getJson('/api/v1/auth/user')->assertStatus(401);
    }
}
