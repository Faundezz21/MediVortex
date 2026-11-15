<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    // cuentas de prueba genericas (sin datos personales). despues del primer ingreso conviene cambiar las contrasenas
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@medivortex.cl'],
            [
                'name' => 'Administrador',
                'last_name' => 'Demo',
                'password' => Hash::make('password'),
                'status' => 'activo',
            ]
        );
        $admin->syncRoles(['Administrador']);

        $operador = User::updateOrCreate(
            ['email' => 'operador@medivortex.cl'],
            [
                'name' => 'Operador',
                'last_name' => 'Bodega',
                'password' => Hash::make('password'),
                'status' => 'activo',
            ]
        );
        $operador->syncRoles(['Usuario']);

        // el rol usuario recibe los modulos operativos de bodega; la gestion de usuarios queda solo para el administrador.
        // solo se asignan si el rol aun no tiene permisos, para no pisar lo configurado desde la pantalla de roles
        $rolUsuario = Role::findByName('Usuario');
        if ($rolUsuario->permissions()->doesntExist()) {
            $rolUsuario->syncPermissions([
                'ver.dashboard',
                'ver.recepcion',
                'ver.inventario',
                'ver.cuarentena',
                'ver.distribucion',
                'ver.despacho',
                'ver.trazabilidad',
            ]);
        }
    }
}
