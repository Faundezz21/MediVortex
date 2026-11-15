<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // roles y permisos, usuarios de prueba, planta base de la bodega y datos de demostracion
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProviderSeeder::class);
        $this->call(DistributionSeeder::class);
        $this->call(DemoSeeder::class);
    }
}
