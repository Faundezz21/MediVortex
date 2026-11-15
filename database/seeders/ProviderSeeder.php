<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Support\Rut;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    // proveedores ficticios de prueba: nombres inventados, rut con digito verificador valido
    // y correos en el dominio reservado .example (no pertenecen a ninguna empresa ni persona real)
    public function run(): void
    {
        $proveedores = [
            ['cuerpo' => '76100001', 'name' => 'AURORA TECH DEMO SPA', 'business_line' => 'Importación y venta al por mayor de electrónica', 'category' => 'Electrónica y tecnología', 'email' => 'contacto@auroratech.example', 'phone' => '+56 2 2000 0001', 'address' => 'Av. Principal 100, Santiago'],
            ['cuerpo' => '76100002', 'name' => 'DISTRIBUIDORA SUR DEMO LTDA', 'business_line' => 'Venta al por mayor de productos de consumo', 'category' => 'Mercadería general', 'email' => 'ventas@distrisur.example', 'phone' => '+56 2 2000 0002', 'address' => 'Calle Uno 200, Santiago'],
            ['cuerpo' => '76100003', 'name' => 'IMPORTADORA PACÍFICO DEMO SPA', 'business_line' => 'Importación y comercialización de artículos para el hogar', 'category' => 'Hogar y decoración', 'email' => 'contacto@pacifico.example', 'phone' => null, 'address' => 'Calle Dos 300, Santiago'],
            ['cuerpo' => '76100004', 'name' => 'ALIMENTOS VITALIS DEMO S.A.', 'business_line' => 'Elaboración y distribución de alimentos envasados', 'category' => 'Alimentos y bebidas', 'email' => 'contacto@vitalis.example', 'phone' => '+56 2 2000 0004', 'address' => 'Av. Central 400, Santiago'],
            ['cuerpo' => '76100005', 'name' => 'COMERCIAL NORTE DEMO LTDA', 'business_line' => 'Venta al por mayor de artículos de limpieza', 'category' => 'Limpieza y cuidado personal', 'email' => 'ventas@comercialnorte.example', 'phone' => null, 'address' => null],
            ['cuerpo' => '76100006', 'name' => 'EMBALAJES DEL VALLE DEMO SPA', 'business_line' => 'Fabricación de cajas, film y material de embalaje', 'category' => 'Insumos y embalaje', 'email' => 'contacto@embalajesvalle.example', 'phone' => '+56 2 2000 0006', 'address' => 'Calle Tres 600, Santiago'],
            ['cuerpo' => '76100007', 'name' => 'FERRETERÍA INDUSTRIAL DEMO S.A.', 'business_line' => 'Venta al por mayor de herramientas y ferretería', 'category' => 'Ferretería', 'email' => 'ventas@ferreind.example', 'phone' => '+56 2 2000 0007', 'address' => 'Av. Industrial 700, Santiago'],
            ['cuerpo' => '76100008', 'name' => 'GADGETS ANDES DEMO SPA', 'business_line' => 'Importación y distribución de accesorios tecnológicos', 'category' => 'Electrónica y tecnología', 'email' => 'contacto@gadgetsandes.example', 'phone' => null, 'address' => 'Calle Cuatro 800, Rancagua'],
        ];

        foreach ($proveedores as $proveedor) {
            $cuerpo = $proveedor['cuerpo'];
            unset($proveedor['cuerpo']);

            $rut = Rut::formatear($cuerpo . Rut::digitoVerificador($cuerpo));

            Provider::updateOrCreate(
                ['rut' => $rut],
                $proveedor + ['rut' => $rut, 'status' => 'activo']
            );
        }
    }
}
