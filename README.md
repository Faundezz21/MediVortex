# MediVortex — Plataforma de Logística y Distribución

Aplicación web para la operación de un centro de distribución: recepción de mercadería, inventario por lote con ubicación física, pedidos de sucursales y clientes, despachos con criterio FEFO y trazabilidad completa de cada movimiento.

> Proyecto demostrativo de portafolio. La empresa, los proveedores, las sucursales, los clientes y todos los datos incluidos son ficticios.

## Características principales

- **Recepción documentada:** ingreso de mercadería por factura, guía de despacho u orden de compra, con desglose por lote, fecha de vencimiento, costo unitario y firma del receptor. Emite el acta de recepción en PDF.
- **Inventario por producto y lote:** stock valorizado, ubicación física en bodega, ajustes auditados con justificación obligatoria, etiquetas QR y carga masiva desde plantillas Excel.
- **Cuarentena y mermas:** retención preventiva de lotes para control de calidad, liberación y baja. Los lotes vencidos pasan automáticamente a merma y quedan registrados en la trazabilidad.
- **Pedidos de sucursales y clientes:** registro de pedidos de la red de sucursales propias y de clientes mayoristas, con stock local en línea, firma del solicitante y reportes consolidados en PDF.
- **Despacho normal y despacho de alto valor:** descuento automático de inventario con criterio **FEFO** (*First Expired, First Out*), cumplimiento parcial o total de pedidos y un flujo separado con guía y custodia para productos de alto valor (electrónica, sellos de seguridad).
- **Distribución física 2D / 3D:** mapa interactivo de la bodega por pasillos, estanterías, niveles y posiciones, con capacidad y porcentaje de ocupación en tiempo real.
- **Trazabilidad y reportes:** historial de movimientos por lote (recepciones, despachos, cambios de estado, reubicaciones y ajustes) y exportación de informes valorizados en Excel y PDF.
- **Control de acceso por roles:** usuarios, roles y permisos por módulo.
- **Interfaz:** modo claro y oscuro, diseño adaptable a móvil y buscador global con `Ctrl + K`.

## Stack tecnológico

- **Backend:** PHP 8.4+ · Laravel 13
- **Base de datos:** MySQL 8 / MariaDB
- **Frontend:** Blade · Tailwind CSS · Alpine.js · Vite
- **Librerías clave:**
  - `spatie/laravel-permission` (roles y permisos)
  - `maatwebsite/excel` (importación y exportación de planillas)
  - `barryvdh/laravel-dompdf` (actas y guías en PDF)
  - `simplesoftwareio/simple-qrcode` (etiquetas QR)
  - `Three.js`, `SignaturePad`, `SweetAlert2` y `html5-qrcode`

## Requisitos

- PHP >= 8.4 (con extensiones `gd`, `zip`, `mbstring`, `xml`, `pdo_mysql`)
- Composer 2
- Node.js >= 18 y npm
- MySQL 8 o MariaDB

## Instalación

```bash
git clone https://github.com/Faundezz21/MediVortex.git
cd MediVortex

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Configura la base de datos en `.env`:

```env
APP_NAME="MediVortex"
APP_LOCALE=es

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medivortex
DB_USERNAME=root
DB_PASSWORD=
```

Crea las tablas con los datos de demostración y compila los recursos:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

La plataforma queda disponible en `http://127.0.0.1:8000`.

## Datos de demostración

`php artisan migrate --seed` carga roles y permisos, la planta de la bodega (pasillos, estanterías, niveles y posiciones), proveedores ficticios y un set de operación de demo: recepciones, lotes ubicados, un lote en cuarentena, otro próximo a vencer, pedidos en distintos estados y guías de despacho.

| Usuario | Correo | Contraseña | Acceso |
|---|---|---|---|
| Administrador | `admin@medivortex.cl` | `password` | Todos los módulos |
| Operador | `operador@medivortex.cl` | `password` | Módulos de bodega |

Para volver al estado inicial de la demo:

```bash
php artisan migrate:fresh --seed
```

## Pruebas

Las migraciones usan sintaxis de MySQL, por lo que las pruebas necesitan una base MySQL dedicada (se vacía en cada ejecución):

```bash
DB_CONNECTION=mysql DB_DATABASE=medivortex_pruebas php artisan test
```

## Parámetros de configuración (`config/drogueria.php`)

- `iva`: impuesto aplicado en la valorización de recepciones.
- `meses_alerta_vencimiento`: meses de anticipación para alertar lotes próximos a vencer.
- `controlados`, `principios_controlados` y `frases_controlados`: catálogo y palabras clave de los productos de alto valor.
- `establecimientos`: red de destinos (sucursales propias y clientes) con su tipo y dirección.

## Automatización de vencimientos

El paso de lotes vencidos a **merma** funciona en dos niveles:

1. **En línea:** verificación ligera durante la navegación (como máximo una vez cada 5 minutos, mediante caché).
2. **Tarea programada:** comando `php artisan inventario:vencidos`, todos los días a las `00:05`.

Para activar el programador en producción, agrega esta entrada al `crontab`:

```cron
* * * * * cd /ruta/a/MediVortex && php artisan schedule:run >> /dev/null 2>&1
```

## Despliegue en producción

- Nginx o Apache con PHP-FPM y **HTTPS** (los navegadores lo exigen para usar la cámara en el lector QR).
- En `.env`:
  ```env
  APP_ENV=production
  APP_DEBUG=false
  ```
- En `php.ini`:
  - `max_input_vars = 10000` (recepciones y despachos con muchas líneas).
  - `memory_limit = 512M` (reportes PDF extensos).
- Optimización:
  ```bash
  composer install --no-dev --optimize-autoloader
  npm ci && npm run build
  php artisan migrate --force
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

## Estructura del proyecto

```text
app/
  Exports/                         exportación de reportes en Excel
  Http/Controllers/                controladores por módulo
  Http/Middleware/                 control de usuarios activos y vencimiento de lotes
  Imports/                         carga masiva desde Excel
  Models/                          modelos Eloquent y relaciones
  Services/
    InventoryService.php           lógica FEFO, ingresos, movimientos, ubicaciones y vencimientos
    SolicitudService.php           cruce de despachos contra pedidos
    EstablishmentStockService.php  stock local de cada sucursal o cliente
  Support/Rut.php                  formato y validación de RUT (módulo 11)
config/drogueria.php               parámetros del negocio, red de destinos y productos de alto valor
database/
  migrations/                      esquema relacional e índices
  seeders/                         roles, usuarios, bodega, proveedores y datos de demo
public/css/mv-theme.css            tema visual global
resources/views/                   vistas Blade, modales y plantillas PDF
routes/
  web.php                          rutas protegidas por permisos
  console.php                      comandos y tareas programadas
```

## Autor

Desarrollado por **[Faundezz21](https://github.com/Faundezz21)**.
