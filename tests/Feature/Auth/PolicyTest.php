<?php

namespace Tests\Feature\Auth;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests de autorización para verificar que las policies funcionan correctamente.
 * Los usuarios normales no deben poder acceder a rutas de administración.
 */
class PolicyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que usuarios sin rol admin no pueden acceder al panel admin.
     */
    public function test_regular_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create(['role' => Role::User]);
        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    /**
     * Verifica que usuarios admin sí pueden acceder al panel admin.
     */
    public function test_admin_user_can_access_admin_panel(): void
    {
        $admin = User::factory()->create(['role' => Role::Admin]);
        $this->actingAs($admin)->get('/admin')->assertSuccessful();
    }

    /**
     * Verifica que superadmin puede acceder al panel admin.
     */
    public function test_superadmin_can_access_admin_panel(): void
    {
        $superadmin = User::factory()->create(['role' => Role::SuperAdmin]);
        $this->actingAs($superadmin)->get('/admin')->assertSuccessful();
    }

    /**
     * Verifica que usuarios inactivos no pueden acceder al panel admin aunque sean admin.
     */
    public function test_inactive_admin_cannot_access_admin_panel(): void
    {
        $admin = User::factory()->create(['role' => Role::Admin, 'is_active' => false]);
        $this->actingAs($admin)->get('/admin')->assertForbidden();
    }

    /**
     * Verifica que usuarios normales pueden acceder al panel de usuario.
     */
    public function test_regular_user_can_access_user_panel(): void
    {
        $user = User::factory()->create(['role' => Role::User]);
        $this->actingAs($user)->get('/panel')->assertSuccessful();
    }
}
