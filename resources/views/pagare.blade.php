<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Pagaré</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Eliminar márgenes globales */
            padding: 0; /* Eliminar rellenos globales */
        }
        table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            margin-bottom: 20px;
            padding: 10px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #000;
        }
        .pagaré {
            margin-bottom: 40px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        .logo {
            width: 150px; /* Ajusta el tamaño de la imagen */
            display: block;
            margin: 0 auto;
        }
        @page {
            size: A4;
            margin: 0; /* Sin márgenes adicionales */
        }
        .new-page {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Generar Pagarés Basados en los Meses Seleccionados -->
    @php
        $mesesSeleccionados = $venta->meses ?? 1; // Asegúrate de que meses contenga el número de meses seleccionados.
    @endphp

    <!-- Pagaré con salto de página después de cada uno -->
    @for ($i = 1; $i <= $mesesSeleccionados; $i++)
        @php
            $fechaVencimiento = \Carbon\Carbon::parse($venta->fecha_hora_pago)->addMonths($i);
        @endphp

        <!-- Salto de página solo después del primer pagaré -->
        @if ($i > 1)
            <div class="new-page">
        @endif

        <div class="pagaré">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" class="logo">
            <table>
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">Pagaré {{ $i }} de {{ $mesesSeleccionados }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Cliente:</strong></td>
                        <td>{{ $contacto->nombre }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de Venta:</strong></td>
                        <td>{{ $venta->fecha_hora_pago }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de Vencimiento:</strong></td>
                        <td>{{ $fechaVencimiento->format('d/m/Y') }}</td>
                    </tr>
                                        <tr>
                        <td><strong>Monto:</strong></td>
                        <td>${{ number_format(($venta->precio_venta_final - $venta->enganche) / ($venta->meses ?? 1), 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Contrato N°:</strong></td>
                        <td>{{ $venta->numero_contrato }}</td>
                    </tr>
                    <tr>
                        <td><strong>Asesor:</strong></td>
                        <td>{{ $venta->asesor }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="height: 50px;">Firma del Cliente: _________________________________</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($i > 1)
            </div> <!-- Cerrar div de new-page -->
        @endif

    @endfor

    <!-- Footer -->
    <div class="footer">
        <p>Fecha de Emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
</body>
</html>
