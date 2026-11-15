<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía de Despacho {{ $despacho->correlativo }}</title>
    <style>
        @page { margin: 28px 36px 45px 36px; }
        body { font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; font-size: 10.5px; color: #1e293b; line-height: 1.4; }
        
        /* cabecera institucional */
        .top-accent { height: 5px; background-color: #120f24; width: 100%; margin-bottom: 12px; border-radius: 2px; }
        .header-table { width: 100%; border-bottom: 2px solid #7c3aed; padding-bottom: 12px; margin-bottom: 14px; border-collapse: collapse; }
        .logo-container { width: 55%; vertical-align: middle; }
        .logo-icon { width: 32px; height: 32px; vertical-align: middle; margin-right: 8px; }
        .logo-title { font-size: 17px; font-weight: 800; color: #120f24; margin: 0; display: inline-block; vertical-align: middle; letter-spacing: 0.4px; }
        .logo-subtitle { font-size: 9px; color: #7c3aed; margin: 2px 0 0 0; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }
        .logo-address { font-size: 8.5px; color: #64748b; margin: 1px 0 0 0; }
        
        .doc-meta { width: 45%; text-align: right; vertical-align: middle; }
        .doc-box { display: inline-block; border: 1.5px solid #7c3aed; background-color: #f5f3ff; border-radius: 6px; padding: 8px 14px; text-align: center; }
        .doc-type-label { font-size: 9px; font-weight: 800; color: #6d28d9; text-transform: uppercase; letter-spacing: 0.8px; margin: 0 0 3px 0; }
        .doc-correlativo { font-size: 14px; font-weight: 900; color: #4c1d95; margin: 0 0 3px 0; font-family: 'Courier New', monospace; }
        .doc-date { font-size: 8.5px; color: #475569; margin: 0; font-weight: 600; }

        /* secciones y tablas de informacion */
        .section-header { background-color: #f5f3ff; color: #6d28d9; font-size: 9.5px; font-weight: 800; text-transform: uppercase; padding: 5px 10px; margin: 12px 0 5px 0; border-left: 4px solid #7c3aed; border-top: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #ece9f6; letter-spacing: 0.5px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        .info-table th { background-color: #f8fafc; color: #475569; font-size: 8.5px; font-weight: 800; text-transform: uppercase; text-align: left; padding: 6px 8px; border: 1px solid #e4e0f2; width: 20%; letter-spacing: 0.3px; }
        .info-table td { font-size: 10px; color: #0f172a; font-weight: 600; padding: 6px 8px; border: 1px solid #e4e0f2; width: 30%; }

        /* kpi strip resumen */
        .kpi-table { width: 100%; border-collapse: collapse; margin: 10px 0 8px 0; }
        .kpi-card { background-color: #f5f3ff; border: 1px solid #ddd6fe; padding: 6px 10px; text-align: center; width: 33.33%; }
        .kpi-label { font-size: 8px; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 2px; }
        .kpi-value { font-size: 12px; font-weight: 900; color: #6d28d9; }

        /* tabla de articulos */
        .items-table { width: 100%; border-collapse: collapse; margin-top: 4px; }
        .items-table th { background-color: #120f24; color: #ffffff; font-size: 8.5px; font-weight: 800; text-transform: uppercase; text-align: center; padding: 7px 6px; border: 1px solid #120f24; letter-spacing: 0.3px; }
        .items-table td { font-size: 9.5px; color: #1e293b; padding: 6px 6px; border: 1px solid #e4e0f2; text-align: center; vertical-align: middle; }
        .items-table td.text-left { text-align: left; }
        .items-table tr:nth-child(even) td { background-color: #faf9fe; }

        .badge { display: inline-block; padding: 2px 5px; font-size: 8px; font-weight: 700; border-radius: 3px; background-color: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }

        .total-row td { background-color: #ede9fe !important; border-top: 2px solid #7c3aed; padding: 7px 8px; }
        .total-label { font-size: 10px; font-weight: 900; color: #4c1d95; text-transform: uppercase; text-align: right; }
        .total-amount { font-size: 11.5px; font-weight: 900; color: #6d28d9; text-align: center; }

        /* observaciones */
        .obs-box { margin-top: 10px; border: 1px dashed #94a3b8; background-color: #f8fafc; padding: 6px 10px; font-size: 9px; color: #475569; border-radius: 4px; }

        /* firmas */
        .signatures-wrapper { margin-top: 34px; width: 100%; page-break-inside: avoid; }
        .signatures-table { width: 100%; border-collapse: collapse; }
        .signature-box { width: 48%; text-align: center; vertical-align: bottom; padding: 6px; }
        .signature-image-container { height: 60px; margin-bottom: 3px; }
        .signature-img { max-width: 155px; height: 55px; object-fit: contain; }
        .signature-line { width: 85%; border-top: 1.5px solid #334155; margin: 0 auto 4px auto; }
        .signature-title { font-size: 9.5px; font-weight: 800; color: #0f172a; margin: 0; text-transform: uppercase; }
        .signature-subtitle { font-size: 8.5px; color: #64748b; margin: 2px 0 0 0; }

        /* pie de pagina */
        .footer { position: fixed; bottom: -25px; left: 0; right: 0; height: 22px; text-align: left; font-size: 8px; color: #64748b; border-top: 1px solid #cbd5e1; padding-top: 4px; }
    </style>
</head>
<body>

    <div class="top-accent"></div>

    @php
        $totalItems = $despacho->items->count();
        $totalCantidad = $despacho->items->sum('cantidad');
    @endphp

    <table class="header-table">
        <tr>
            <td class="logo-container">
                <div>
                    @php
                        $logoPath = public_path('images/logo.png');
                        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
                    @endphp
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="logo-icon" alt="Logo">
                    @endif
                    <div style="display: inline-block; vertical-align: middle;">
                        <h2 class="logo-title">MEDIVORTEX · LOGÍSTICA &amp; DISTRIBUCIÓN</h2>
                        <p class="logo-subtitle">Red de Distribución · Dirección de Logística y Distribución</p>
                        <p class="logo-address">Av. Los Industriales 2500, Parque Logístico · Distribución y Logística</p>
                    </div>
                </div>
            </td>
            <td class="doc-meta">
                <div class="doc-box">
                    <p class="doc-type-label">Guía de Despacho {{ strtoupper($despacho->clasificacion ?? 'EXTERNA') }}</p>
                    <p class="doc-correlativo">N° {{ $despacho->correlativo }}</p>
                    <p class="doc-date">Fecha Despacho: {{ \Carbon\Carbon::parse($despacho->fecha_despacho)->format('d/m/Y') }}</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-header">1. Información de Destino y Logística de Transporte</div>
    <table class="info-table">
        <tbody>
            <tr>
                <th>Cliente Destino</th>
                <td style="font-weight: 800; color: #6d28d9;">{{ $despacho->establecimiento_destino }}</td>
                <th>Clasificación Guía</th>
                <td>{{ strtoupper($despacho->clasificacion ?? 'Despacho Externo') }}</td>
            </tr>
            <tr>
                <th>Dirección Entrega</th>
                <td>{{ $despacho->direccion_destino ?: 'Red de Distribución MediVortex' }}</td>
                <th>Condición Transporte</th>
                <td>{{ $despacho->condiciones_transporte ?: 'Transporte Temperatura Ambiente de Alto Valor' }}</td>
            </tr>
            @if (! empty($despacho->establecimiento_origen))
                <tr>
                    <th>Sale del stock de</th>
                    <td colspan="3" style="font-weight: 800;">{{ $despacho->establecimiento_origen }}</td>
                </tr>
            @endif
            @if (! empty($despacho->motivo_traspaso))
                <tr>
                    <th>Traspaso sin solicitud</th>
                    <td colspan="3">Sin solicitud previa. Motivo: {{ $despacho->motivo_traspaso }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <table class="kpi-table">
        <tr>
            <td class="kpi-card">
                <span class="kpi-label">Lotes / Líneas Despachadas</span>
                <span class="kpi-value">{{ number_format($totalItems, 0, ',', '.') }} ítems</span>
            </td>
            <td class="kpi-card">
                <span class="kpi-label">Total Unidades Extraídas</span>
                <span class="kpi-value">{{ number_format($totalCantidad, 0, ',', '.') }} uds.</span>
            </td>
            <td class="kpi-card">
                <span class="kpi-label">Estado de Guía</span>
                <span class="kpi-value">DESPACHADO (FEFO)</span>
            </td>
        </tr>
    </table>

    <div class="section-header">2. Detalle de Productos e Insumos Despachados</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 6%;">#</th>
                <th style="width: 38%; text-align: left;">Producto</th>
                <th style="width: 16%;">N° de Lote</th>
                <th style="width: 14%;">Vencimiento</th>
                <th style="width: 14%;">Programa</th>
                <th style="width: 12%;">Cant. Extraída</th>
            </tr>
        </thead>
        <tbody>
            @foreach($despacho->items as $idx => $item)
            <tr>
                <td style="color: #64748b; font-weight: bold;">{{ $idx + 1 }}</td>
                <td class="text-left"><strong style="font-size: 10px; color: #0f172a;">{{ $item->producto }}</strong></td>
                <td style="font-family: 'Courier New', monospace; font-weight: 700;">{{ $item->lote ?: 'S/L' }}</td>
                <td>{{ $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : 'N/A' }}</td>
                <td><span class="badge">{{ $item->programa ?: 'Programa General' }}</span></td>
                <td><strong style="font-size: 10.5px; color: #6d28d9;">{{ number_format($item->cantidad, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" class="total-label">TOTAL GENERAL DE UNIDADES DESPACHADAS:</td>
                <td class="total-amount">{{ number_format($totalCantidad, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="obs-box">
        <strong>Constancia de Recepción:</strong> El cliente receptor certifica haber verificado físicamente las cantidades, lotes, integridad de envases y fechas de vencimiento detalladas en la presente Guía de Despacho.
    </div>

    <div class="signatures-wrapper">
        <table class="signatures-table">
            <tr>
                <td class="signature-box" style="width: 50%;">
                    <div class="signature-image-container">
                        @if(isset($despacho->firma_despacha) && $despacho->firma_despacha)
                            <img src="{{ $despacho->firma_despacha }}" class="signature-img" alt="Firma Despacha">
                        @endif
                    </div>
                    <div class="signature-line"></div>
                    <p class="signature-title">Firma de quien despacha</p>
                    <p class="signature-subtitle">Bodega Central MediVortex</p>
                </td>
                <td class="signature-box" style="width: 50%;">
                    <div class="signature-image-container">
                        @if(isset($despacho->firma_recibe) && $despacho->firma_recibe)
                            <img src="{{ $despacho->firma_recibe }}" class="signature-img" alt="Firma Recibe">
                        @elseif (($despacho->estado_recepcion ?? null) === 'Pendiente')
                            <p style="font-size: 10px; color: #b45309; font-weight: bold; padding-top: 20px;">RECEPCIÓN PENDIENTE</p>
                        @endif
                    </div>
                    <div class="signature-line"></div>
                    <p class="signature-title">Firma de quien recibe</p>
                    <p class="signature-subtitle">Cliente Destino</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Documento oficial generado por el Sistema de Inventario y Abastecimiento MediVortex · Impreso el {{ date('d/m/Y H:i') }}
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("Helvetica");
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $x = $pdf->get_width() - $width - 36;
            $y = $pdf->get_height() - 28;
            $pdf->page_text($x, $y, $text, $font, $size, array(0.39, 0.45, 0.54));
        }
    </script>
</body>
</html>
