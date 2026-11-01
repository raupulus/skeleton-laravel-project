<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $response = $this->withHeader('Authorization', "Bearer {$token}")->postJson('/api/v1/user/tokens', ['name' => 'new-token']);
        $response->assertStatus(201)->assertJsonStructure(['token', 'name']);
    }

    public function test_user_can_list_own_tokens_without_exposing_secret_hash(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $response = $this->withHeader('Authorization', "Bearer {$token}")->getJson('/api/v1/user/tokens');
        $response->assertOk()->assertJsonMissingPath('0.token');
    }

    public function test_user_cannot_exceed_20_active_tokens(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;
        for ($i = 1; $i < 20; $i++) {
            $user->createToken("token-{$i}");
        }

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/user/tokens', ['name' => 'token-21'])
            ->assertStatus(422);
    }

    public function test_user_can_delete_own_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $tokenId = $user->tokens()->first()->id;
        $this->withHeader('Authorization', "Bearer {$token}")->deleteJson("/api/v1/user/tokens/{$tokenId}")->assertOk();
    }
}
