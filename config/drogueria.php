<?php

// configuracion del negocio de la empresa ficticia
return [

    'iva' => 0.19,

    // meses de anticipacion para alertar lotes proximos a vencer (rotacion fefo)
    'meses_alerta_vencimiento' => 6,

    // productos de alto valor: se despachan por el modulo de despacho alto valor, con guia y firma de custodia
    'controlados' => [
        'Notebook 14" Ryzen 7 16GB',
        'Notebook 15.6" Core i5 8GB',
        'Smartphone 6.5" 128GB',
        'Smartphone 6.7" 256GB',
        'Tablet 10" 64GB',
        'Smartwatch Deportivo GPS',
        'Consola de Videojuegos 1TB',
        'Audífonos Inalámbricos ANC',
        'Cámara Mirrorless 24MP',
        'Monitor 27" 4K',
        'Sellos de Seguridad Numerados',
    ],

    // palabras clave que identifican un producto de alto valor aunque no este en la lista exacta
    'principios_controlados' => [
        'notebook',
        'smartphone',
        'tablet',
        'smartwatch',
        'consola',
        'mirrorless',
        'monitor',
    ],

    // frases que identifican un producto de alto valor aunque no sea una palabra clave
    'frases_controlados' => [
        'sello de seguridad',
        'sellos de seguridad',
    ],

    // red de destinos: tipo sucursal son tiendas propias y tipo cliente son mayoristas y canales externos
    'establecimientos' => [
        // sucursales propias
        ['nombre' => 'Sucursal Centro', 'tipo' => 'Sucursal', 'direccion' => 'Av. Principal 1200, Sector Centro'],
        ['nombre' => 'Sucursal Norte', 'tipo' => 'Sucursal', 'direccion' => 'Av. Los Aromos 3400, Sector Norte'],
        ['nombre' => 'Sucursal Oriente', 'tipo' => 'Sucursal', 'direccion' => 'Calle Las Acacias 850, Sector Oriente'],
        ['nombre' => 'Sucursal Poniente', 'tipo' => 'Sucursal', 'direccion' => 'Av. del Valle 2210, Sector Poniente'],

        // clientes mayoristas
        ['nombre' => 'Comercial Andina Demo', 'tipo' => 'Cliente', 'direccion' => 'Calle Comercio 455, Parque Industrial'],
        ['nombre' => 'Supermercados Del Valle Demo', 'tipo' => 'Cliente', 'direccion' => 'Av. Las Industrias 7700, Sector Sur'],
        ['nombre' => 'Tiendas Horizonte Demo', 'tipo' => 'Cliente', 'direccion' => 'Calle Mirador 1960, Sector Alto'],
        ['nombre' => 'Ferretería El Roble Demo', 'tipo' => 'Cliente', 'direccion' => 'Calle El Roble 1301, Sector Norte'],
        ['nombre' => 'Minimarket La Esquina Demo', 'tipo' => 'Cliente', 'direccion' => 'Pasaje Central 546, Villa Central'],

        // canales y operaciones
        ['nombre' => 'Tienda Online (e-commerce)', 'tipo' => 'Cliente', 'direccion' => 'Despacho a domicilio'],
        ['nombre' => 'Punto de Retiro Express', 'tipo' => 'Cliente', 'direccion' => 'Av. Principal 1250, Sector Centro'],
        ['nombre' => 'Centro de Devoluciones', 'tipo' => 'Cliente', 'direccion' => 'Calle Bodega 490, Parque Industrial'],
        ['nombre' => 'Showroom Corporativo', 'tipo' => 'Cliente', 'direccion' => 'Av. Libertador 1142, Sector Centro'],
        ['nombre' => 'Ruta Móvil I', 'tipo' => 'Cliente', 'direccion' => 'Reparto en ruta'],
        ['nombre' => 'Ruta Móvil II', 'tipo' => 'Cliente', 'direccion' => 'Reparto en ruta'],
    ],
];
