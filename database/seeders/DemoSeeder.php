<?php

namespace Database\Seeders;

use App\Models\Dispatch;
use App\Models\DispatchItem;
use App\Models\EstablishmentItem;
use App\Models\EstablishmentRequest;
use App\Models\Level;
use App\Models\Position;
use App\Models\Provider;
use App\Models\Reception;
use App\Models\ReceptionItem;
use App\Models\Shelf;
use App\Models\User;
use App\Services\EstablishmentStockService;
use App\Services\InventoryService;
use App\Services\SolicitudService;
use App\Support\Rut;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    // datos ficticios de demostracion: ubicaciones, recepciones, stock, pedidos y despachos usando los servicios de la app
    public function run(): void
    {
        if (Reception::exists()) {
            $this->command?->warn('ya existen recepciones, se omite el seeder de demo');

            return;
        }

        $admin = User::where('email', 'admin@medivortex.cl')->first();
        $operador = User::where('email', 'operador@medivortex.cl')->first();
        auth()->login($admin);

        DB::transaction(function () use ($admin, $operador) {
            $this->crearUbicaciones();
            $this->crearRecepciones();
            $this->crearPedidosYDespachos($admin, $operador);
        });

        auth()->logout();
    }

    // cada estanteria recibe 3 niveles y 4 posiciones por nivel
    private function crearUbicaciones(): void
    {
        foreach (Shelf::all() as $shelf) {
            for ($n = 1; $n <= 3; $n++) {
                $level = Level::firstOrCreate(['shelf_id' => $shelf->id, 'number' => $n], ['description' => "Nivel {$n}"]);
                foreach (['P1', 'P2', 'P3', 'P4'] as $pos) {
                    Position::firstOrCreate(['level_id' => $level->id, 'name' => $pos]);
                }
            }
        }
    }

    // catalogo: nombre => [categoria, valor neto unitario, meses de vida util o null si no vence]
    private function catalogo(): array
    {
        return [
            'Café en Grano 1kg' => ['Alimentos y bebidas', 8900, 10],
            'Aceite de Oliva Extra Virgen 1L' => ['Alimentos y bebidas', 6490, 18],
            'Arroz Grado 1 5kg' => ['Alimentos y bebidas', 5290, 14],
            'Té Verde 100 Bolsitas' => ['Alimentos y bebidas', 3190, 24],
            'Galletas de Avena 400g' => ['Alimentos y bebidas', 1890, 1],
            'Agua Mineral 1.5L Pack 6' => ['Alimentos y bebidas', 3590, 12],
            'Detergente Líquido 3L' => ['Limpieza y cuidado personal', 7990, 30],
            'Papel Higiénico 32 Rollos' => ['Limpieza y cuidado personal', 12990, null],
            'Lavaloza Concentrado 1L' => ['Limpieza y cuidado personal', 2390, 30],
            'Jabón Líquido 500ml' => ['Limpieza y cuidado personal', 1990, 24],
            'Juego de Toallas 4 Piezas' => ['Hogar y decoración', 15990, null],
            'Set de Ollas Acero 5 Piezas' => ['Hogar y decoración', 39990, null],
            'Lámpara LED de Escritorio' => ['Hogar y decoración', 12490, null],
            'Taladro Percutor 750W' => ['Ferretería', 34990, null],
            'Set de Destornilladores 12 Piezas' => ['Ferretería', 8990, null],
            'Cinta Métrica 5m' => ['Ferretería', 2990, null],
            'Caja de Cartón 40x30x30' => ['Insumos y embalaje', 690, null],
            'Film Stretch 50cm' => ['Insumos y embalaje', 5490, null],
            'Cinta Adhesiva Embalaje 48mm' => ['Insumos y embalaje', 990, null],
            'Etiqueta Térmica 100x150 Rollo' => ['Insumos y embalaje', 4290, null],
            'Notebook 14" Ryzen 7 16GB' => ['Alto Valor', 549990, null],
            'Smartphone 6.5" 128GB' => ['Alto Valor', 229990, null],
            'Tablet 10" 64GB' => ['Alto Valor', 159990, null],
            'Audífonos Inalámbricos ANC' => ['Alto Valor', 89990, null],
            'Smartwatch Deportivo GPS' => ['Alto Valor', 129990, null],
        ];
    }

    // recepciones de los ultimos 60 dias: proveedor, dias atras, documento, items [producto, cantidad, estante, nivel, posicion, estado]
    private function crearRecepciones(): void
    {
        $recepciones = [
            ['76100004', 58, 'Factura', '10421', [['Café en Grano 1kg', 240, 'P1-A', 1, 'P1'], ['Aceite de Oliva Extra Virgen 1L', 180, 'P1-A', 2, 'P2'], ['Arroz Grado 1 5kg', 300, 'P1-B', 1, 'P1'], ['Galletas de Avena 400g', 150, 'P1-B', 2, 'P3']]],
            ['76100005', 47, 'Factura', '88310', [['Detergente Líquido 3L', 200, 'P2-A', 1, 'P1'], ['Papel Higiénico 32 Rollos', 120, 'P2-A', 2, 'P1'], ['Lavaloza Concentrado 1L', 260, 'P2-B', 1, 'P2'], ['Jabón Líquido 500ml', 320, 'P2-B', 2, 'P4']]],
            ['76100001', 40, 'Factura', '5532', [['Notebook 14" Ryzen 7 16GB', 25, 'P4-D', 3, 'P1'], ['Smartphone 6.5" 128GB', 60, 'P4-D', 3, 'P2'], ['Tablet 10" 64GB', 40, 'P4-D', 2, 'P1']]],
            ['76100006', 33, 'Guía de Despacho', '771', [['Caja de Cartón 40x30x30', 2000, 'P3-A', 1, 'P1'], ['Film Stretch 50cm', 150, 'P3-A', 2, 'P2'], ['Cinta Adhesiva Embalaje 48mm', 800, 'P3-B', 1, 'P1'], ['Etiqueta Térmica 100x150 Rollo', 90, 'P3-B', 2, 'P2']]],
            ['76100003', 21, 'Factura', '3108', [['Juego de Toallas 4 Piezas', 80, 'P2-C', 1, 'P1'], ['Set de Ollas Acero 5 Piezas', 45, 'P2-C', 2, 'P1'], ['Lámpara LED de Escritorio', 110, 'P2-D', 1, 'P3']]],
            ['76100007', 14, 'Factura', '20017', [['Taladro Percutor 750W', 35, 'P3-C', 1, 'P1'], ['Set de Destornilladores 12 Piezas', 90, 'P3-C', 2, 'P2'], ['Cinta Métrica 5m', 200, 'P3-D', 1, 'P1']]],
            ['76100008', 9, 'Factura', '6644', [['Audífonos Inalámbricos ANC', 70, 'P4-C', 3, 'P1'], ['Smartwatch Deportivo GPS', 45, 'P4-C', 3, 'P2']]],
            ['76100002', 4, 'Factura', '41290', [['Té Verde 100 Bolsitas', 220, 'P1-C', 1, 'P1'], ['Agua Mineral 1.5L Pack 6', 400, 'P1-C', 2, 'P1'], ['Galletas de Avena 400g', 60, 'P1-D', 1, 'P2', 'Cuarentena']]],
        ];

        $catalogo = $this->catalogo();
        $iva = 1 + (float) config('drogueria.iva', 0.19);

        foreach ($recepciones as $i => [$rut, $diasAtras, $tipoDoc, $numDoc, $items]) {
            $provider = Provider::where('rut', Rut::formatear($rut . Rut::digitoVerificador($rut)))->firstOrFail();
            $fecha = Carbon::today()->subDays($diasAtras);
            $correlativo = $i + 1;

            $reception = Reception::create([
                'correlativo' => $correlativo,
                'fecha_recepcion' => $fecha->toDateString(),
                'tipo_documento' => $tipoDoc,
                'numero_documento' => $numDoc,
                'orden_compra' => 'OC-' . $fecha->format('Y') . '-' . str_pad((string) (100 + $correlativo), 4, '0', STR_PAD_LEFT),
                'origen' => $i === 2 ? 'IMPORTACION' : 'COMPRA NACIONAL',
                'provider_id' => $provider->id,
                'valor_total_recepcion' => 0,
            ]);

            $total = 0;
            foreach ($items as $item) {
                [$producto, $cantidad, $estante, $nivel, $posicion] = $item;
                $estado = $item[5] ?? 'Disponible';
                [$categoria, $valor, $mesesVida] = $catalogo[$producto];

                // las galletas del primer ingreso vencen pronto para mostrar la alerta fefo
                $vence = $mesesVida === null ? null : ($producto === 'Galletas de Avena 400g' && $i === 0
                    ? Carbon::today()->addDays(18)->toDateString()
                    : $fecha->copy()->addMonths($mesesVida)->toDateString());
                $lote = $mesesVida === null ? null : strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $producto), 0, 3)) . '-' . $fecha->format('ymd');

                $subtotal = $valor * $cantidad;
                $total += $subtotal;

                ReceptionItem::create([
                    'reception_id' => $reception->id,
                    'product_id' => InventoryService::productoId($producto),
                    'tipo_producto' => $categoria,
                    'lote' => $lote,
                    'fecha_vencimiento' => $vence,
                    'cantidad' => $cantidad,
                    'valor_unitario' => $valor,
                    'valor_total_item' => round($subtotal * $iva),
                ]);

                $shelf = Shelf::with('aisle')->where('name', $estante)->first();
                $batch = InventoryService::ingresar([
                    'user_id' => auth()->id(),
                    'provider_id' => $provider->id,
                    'reception_id' => $reception->id,
                    'correlativo_interno' => $correlativo,
                    'fecha_recepcion' => $fecha->toDateString(),
                    'tipo_documento' => $tipoDoc,
                    'numero_documento' => $numDoc,
                    'orden_compra' => $reception->orden_compra,
                    'origen_mercaderia' => $reception->origen,
                    'rut_proveedor' => $provider->rut,
                    'razon_social' => $provider->name,
                    'producto' => $producto,
                    'categoria' => $categoria,
                    'estado' => $estado,
                    'motivo' => $estado === 'Cuarentena' ? 'Embalaje dañado: revisión de calidad pendiente' : null,
                    'lote' => $lote,
                    'fecha_vencimiento' => $vence,
                    'cantidad' => $cantidad,
                    'minimo' => (int) max(5, round($cantidad * 0.15)),
                    'valor_neto_unitario' => $valor,
                    'programa' => 'Abastecimiento General',
                    'pasillo' => $shelf?->aisle?->name ?? 'P.A',
                    'estante' => $estante,
                    'nivel' => (string) $nivel,
                    'posicion' => $posicion,
                ]);

                InventoryService::registrarMovimiento($batch, [
                    'user_id' => auth()->id(),
                    'tipo_movimiento' => 'Recepción',
                    'cantidad' => $cantidad,
                    'fecha_hora' => $fecha->copy()->setTime(9 + $i % 6, 15),
                    'origen_destino' => 'Desde: ' . $provider->name,
                    'documento_respaldo' => $tipoDoc . ' ' . $numDoc,
                    'estado_lote' => $estado,
                ]);
            }

            $reception->update(['valor_total_recepcion' => round($total * $iva)]);
            $reception->forceFill(['created_at' => $fecha->copy()->setTime(10, 0), 'updated_at' => $fecha->copy()->setTime(10, 0)])->save();
        }
    }

    // pedidos de sucursales y clientes, algunos despachados total o parcialmente y otros pendientes
    private function crearPedidosYDespachos(User $admin, ?User $operador): void
    {
        $pedidos = [
            // destino, dias atras, responsable, cargo, items [producto => cantidad], despachar: 'total' | 'parcial' | null
            ['Sucursal Centro', 30, 'Ana Pérez', 'Jefa de Sucursal', ['Café en Grano 1kg' => 40, 'Detergente Líquido 3L' => 30, 'Papel Higiénico 32 Rollos' => 20], 'total'],
            ['Sucursal Norte', 26, 'Luis Rojas', 'Encargado de Bodega', ['Arroz Grado 1 5kg' => 60, 'Aceite de Oliva Extra Virgen 1L' => 24, 'Jabón Líquido 500ml' => 48], 'total'],
            ['Comercial Andina Demo', 19, 'Marta Soto', 'Compradora', ['Juego de Toallas 4 Piezas' => 12, 'Set de Ollas Acero 5 Piezas' => 8, 'Lámpara LED de Escritorio' => 15], 'total'],
            ['Supermercados Del Valle Demo', 12, 'Jorge Díaz', 'Jefe de Compras', ['Café en Grano 1kg' => 50, 'Lavaloza Concentrado 1L' => 80, 'Agua Mineral 1.5L Pack 6' => 120], 'parcial'],
            ['Sucursal Oriente', 7, 'Paula Vega', 'Jefa de Sucursal', ['Taladro Percutor 750W' => 6, 'Cinta Métrica 5m' => 25, 'Caja de Cartón 40x30x30' => 300], 'total'],
            ['Tienda Online (e-commerce)', 3, 'Diego Muñoz', 'Coordinador de Pedidos', ['Té Verde 100 Bolsitas' => 30, 'Galletas de Avena 400g' => 40, 'Detergente Líquido 3L' => 20], null],
            ['Sucursal Poniente', 2, 'Camila Torres', 'Encargada de Bodega', ['Arroz Grado 1 5kg' => 40, 'Film Stretch 50cm' => 10, 'Cinta Adhesiva Embalaje 48mm' => 60], null],
            ['Ferretería El Roble Demo', 1, 'Raúl Fuentes', 'Dueño', ['Set de Destornilladores 12 Piezas' => 20, 'Cinta Métrica 5m' => 30], null],
        ];

        $numeroGuia = 0;
        foreach ($pedidos as $idx => [$destino, $diasAtras, $responsable, $cargo, $items, $despachar]) {
            $fecha = Carbon::today()->subDays($diasAtras);

            $solicitud = EstablishmentRequest::create([
                'establecimiento' => $destino,
                'fecha_solicitud' => $fecha->toDateString(),
                'numero_solicitud' => '#00000',
                'responsable' => $responsable,
                'cargo' => $cargo,
                'observaciones' => null,
                'estado' => 'Pendiente',
            ]);
            $solicitud->update(['numero_solicitud' => '#' . str_pad((string) $solicitud->id, 5, '0', STR_PAD_LEFT)]);

            foreach ($items as $producto => $cantidad) {
                EstablishmentItem::create([
                    'establishment_request_id' => $solicitud->id,
                    'product_id' => InventoryService::productoId($producto),
                    'programa' => 'Abastecimiento General',
                    'cantidad_solicitada' => $cantidad,
                    'cantidad_despachada' => 0,
                ]);
            }

            // un pedido pendiente queda asignado al operador para que vea su bandeja
            if ($despachar === null && $idx === 5 && $operador) {
                $solicitud->update(['estado' => 'Asignada', 'assigned_user_id' => $operador->id, 'assigned_at' => now()]);
            }

            $solicitud->forceFill(['created_at' => $fecha->copy()->setTime(11, 0), 'updated_at' => $fecha->copy()->setTime(11, 0)])->save();

            if ($despachar === null) {
                continue;
            }

            $numeroGuia++;
            $fechaDespacho = $fecha->copy()->addDay();
            $est = InventoryService::establecimientoRegistrado($destino);
            $productos = array_keys($items);
            $cantidades = array_map(fn ($c) => $despachar === 'parcial' ? (int) ceil($c / 2) : $c, array_values($items));

            $dispatch = Dispatch::create([
                'establishment_request_id' => $solicitud->id,
                'user_id' => $admin->id,
                'correlativo' => 'GD-' . $fechaDespacho->format('Y') . '-' . str_pad((string) $numeroGuia, 4, '0', STR_PAD_LEFT),
                'fecha_despacho' => $fechaDespacho->toDateString(),
                'clasificacion' => 'Externo',
                'estado_liberacion' => 'Liberada',
                'establecimiento_destino' => $destino,
                'direccion_destino' => $est['direccion'] ?? null,
                'condiciones_transporte' => 'Temperatura ambiente',
                'estado_recepcion' => 'Recibido',
                'fecha_recepcion' => $fechaDespacho->copy()->setTime(16, 30),
            ]);

            foreach ($productos as $k => $producto) {
                foreach (InventoryService::consumir($producto, $cantidades[$k]) as $asignacion) {
                    $batch = $asignacion['inventory'];

                    DispatchItem::create([
                        'dispatch_id' => $dispatch->id,
                        'inventory_id' => $batch->id,
                        'product_id' => $batch->product_id,
                        'producto' => $producto,
                        'lote' => $batch->lote ?? 'S/L',
                        'fecha_vencimiento' => $batch->fecha_vencimiento,
                        'programa' => 'Abastecimiento General',
                        'cantidad' => $asignacion['cantidad'],
                    ]);

                    InventoryService::registrarMovimiento($batch, [
                        'user_id' => $admin->id,
                        'tipo_movimiento' => 'Despacho',
                        'cantidad' => -$asignacion['cantidad'],
                        'fecha_hora' => $fechaDespacho->copy()->setTime(14, 0),
                        'origen_destino' => 'Hacia: ' . $destino,
                        'documento_respaldo' => 'Guía N° ' . $dispatch->correlativo,
                    ]);

                    if ($est) {
                        EstablishmentStockService::ingresar(
                            $est['nombre'], $batch->product_id, $producto, (int) $asignacion['cantidad'],
                            "Guía N° {$dispatch->correlativo} desde el centro de distribución", $dispatch->id
                        );
                    }
                }
            }

            SolicitudService::registrarDespacho($solicitud->id, $productos, $cantidades);
            $dispatch->forceFill(['created_at' => $fechaDespacho->copy()->setTime(14, 0), 'updated_at' => $fechaDespacho->copy()->setTime(14, 0)])->save();
        }
    }
}
