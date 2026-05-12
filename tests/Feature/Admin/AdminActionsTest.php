<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Enums\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Tests para las páginas de acciones del panel admin (Sitemap, Caché, Logs).
 */
class AdminActionsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'role' => Role::SuperAdmin,
            'is_active' => true,
        ]);
    }

    /**
     * Verifica que un admin puede acceder a la página de regenerar sitemap.
     */
    public function test_admin_can_access_regenerate_sitemap_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('filament.admin.pages.regenerate-sitemap'));
        $response->assertSuccessful();
    }

    /**
     * Verifica que un admin puede acceder a la página de limpiar caché.
     */
    public function test_admin_can_access_clear_cache_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('filament.admin.pages.clear-cache'));
        $response->assertSuccessful();
    }

    /**
     * Verifica que un admin puede acceder a la página de ver logs.
     */
    public function test_admin_can_access_view_logs_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('filament.admin.pages.view-logs'));
        $response->assertSuccessful();
    }

    /**
     * Verifica que un usuario normal no puede acceder a las acciones admin.
     */
    public function test_regular_user_cannot_access_admin_actions(): void
    {
        $user = User::factory()->create([
            'role' => Role::User,
            'is_active' => true,
        ]);
        $response = $this->actingAs($user)
            ->get(route('filament.admin.pages.regenerate-sitemap'));
        $response->assertForbidden();
    }

    /**
     * Verifica que la ruta de descarga de logs está protegida.
     */
    public function test_log_download_route_requires_admin(): void
    {
        $user = User::factory()->create([
            'role' => Role::User,
            'is_active' => true,
        ]);
        $response = $this->actingAs($user)
            ->get(route('admin.logs.download', 'laravel.log'));
        $response->assertForbidden();
    }
}
