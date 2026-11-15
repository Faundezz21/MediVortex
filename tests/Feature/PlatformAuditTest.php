<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformAuditTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $admin = null;
    protected ?User $bodeguero = null;

    protected function setUp(): void
    {
        parent::setUp();
        // cada prueba parte de la base sembrada con usuarios, bodega y datos de demo
        $this->seed();
        $this->admin = User::where('email', 'admin@medivortex.cl')->first();
        $this->bodeguero = User::where('email', 'operador@medivortex.cl')->first();
    }

    public function test_admin_can_access_all_main_views(): void
    {
        $this->assertNotNull($this->admin, 'Usuario Administrador no existe');

        // se usan los nombres de ruta para no depender de las urls
        $routes = [
            'dashboard.index',
            'inventory.index',
            'reception.index',
            'dispatch.index',
            'controlled_dispatch.index',
            'requests.index',
            'requests.cesfam',
            'reports.index',
            'quarantine.index',
            'distribution.index',
            'providers.index',
            'traceability.index',
            'users.index',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($this->admin)->get(route($route));
            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 302]),
                "Fallo al acceder a la ruta: {$route} con status {$response->getStatusCode()}"
            );
        }
    }

    public function test_admin_can_access_pending_requests_pdf_endpoints(): void
    {
        $this->assertNotNull($this->admin);

        // pdf de pedidos pendientes de clientes
        $resEstab = $this->actingAs($this->admin)->get(route('requests.pending.establecimientos.pdf', ['download' => 0]));
        $this->assertEquals(200, $resEstab->getStatusCode(), 'Fallo en PDF de clientes');

        // pdf de pedidos pendientes de sucursales
        $resCesfam = $this->actingAs($this->admin)->get(route('requests.pending.cesfam.pdf', ['download' => 0]));
        $this->assertEquals(200, $resCesfam->getStatusCode(), 'Fallo en PDF de sucursales');
    }

    public function test_bodeguero_role_permissions_and_restrictions(): void
    {
        $this->assertNotNull($this->bodeguero, 'Usuario Bodeguero no existe');

        // el bodeguero puede ver inventario
        $resInv = $this->actingAs($this->bodeguero)->get('/inventory');
        $this->assertEquals(200, $resInv->getStatusCode(), 'Bodeguero debería poder ver /inventory');

        // el bodeguero no puede entrar a la gestion de usuarios
        $resUsers = $this->actingAs($this->bodeguero)->get('/users');
        $this->assertTrue(
            in_array($resUsers->getStatusCode(), [403, 302]),
            "Bodeguero no debería tener acceso a /users, obtuvo status: {$resUsers->getStatusCode()}"
        );
    }
}
