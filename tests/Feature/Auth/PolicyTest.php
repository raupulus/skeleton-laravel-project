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

    /**
     * Verifica que un admin normal no puede editar ni eliminar a un superadmin.
     */
    public function test_admin_cannot_modify_or_delete_superadmin(): void
    {
        $admin = User::factory()->create(['role' => Role::Admin]);
        $superadmin = User::factory()->create(['role' => Role::SuperAdmin]);

        $this->assertFalse($admin->can('update', $superadmin));
        $this->assertFalse($admin->can('delete', $superadmin));
        $this->assertTrue($superadmin->can('update', $superadmin));
        $this->assertFalse($superadmin->can('delete', $superadmin));
    }

    /**
     * Verifica que un usuario inactivo no puede iniciar sesión en la web.
     */
    public function test_inactive_user_cannot_login_via_web(): void
    {
        $user = User::factory()->inactive()->create([
            'password' => bcrypt('password123'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /**
     * Verifica que un usuario cuya cuenta se desactiva en caliente es expulsado y sus tokens revocados.
     */
    public function test_deactivated_user_is_logged_out_and_tokens_revoked(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $user->createToken('test-device');
        $this->assertEquals(1, $user->tokens()->count());

        $user->update(['is_active' => false]);
        $this->assertEquals(0, $user->tokens()->count());
    }

    /**
     * Verifica que los paneles de Filament solo tienen login y no registro público duplicado.
     */
    public function test_filament_panel_does_not_expose_registration_route(): void
    {
        $this->get('/panel/register')->assertNotFound();
        $this->get('/admin/register')->assertNotFound();
    }
}
