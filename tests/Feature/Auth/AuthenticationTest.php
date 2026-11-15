<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // roles y permisos por vista que usa el login para decidir a donde redirigir
        $this->seed(RoleSeeder::class);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_active_admin_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create(['status' => 'activo']);
        $user->assignRole('Administrador');

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard.index'));
    }

    public function test_user_is_redirected_to_first_allowed_module(): void
    {
        $user = User::factory()->create(['status' => 'activo']);
        $user->givePermissionTo('ver.inventario');

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('inventory.index'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create(['status' => 'activo']);

        $this->post('/login', ['email' => $user->email, 'password' => 'clave-incorrecta']);

        $this->assertGuest();
    }

    public function test_inactive_user_can_not_log_in(): void
    {
        $user = User::factory()->create(['status' => 'inactivo']);
        $user->assignRole('Administrador');

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_user_without_views_is_logged_out(): void
    {
        $user = User::factory()->create(['status' => 'activo']);

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create(['status' => 'activo']);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
