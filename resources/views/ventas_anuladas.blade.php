<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas Completadas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 120px;
        }

        .header h1 {
            font-size: 16px;
            margin: 5px 0;
        }

        .header p {
            margin: 2px 0;
        }

        .report-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.30);
            text-transform: uppercase;
            z-index: -1; /*Detras den contenido */
            pointer-events: none;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .totals {
            margin-top: 10px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="watermark">Anulado</div>
    <div class="header">
        <!-- Mostrar el logotipo de la empresa -->
        <img src="{{ public_path('images/logo_fdr.png') }}" alt="Logo FDR">
        <h1>CONSTRUCTORA FDR</h1>
        <!-- Dirección y teléfono de la empresa -->
        <p>CALLEJÓN DE QUIJANO #236 - ZACATECAS</p>
        <p>Teléfono: 492-161-68-35</p>
    </div>

    <!-- Título del reporte, incluyendo el proyecto y la fecha de generación -->
    <div class="report-title">
        ARCES<br>
        REPORTE DE VENTAS A CRÉDITO COMPLETADAS - {{ $fecha_reporte }}
    </div>

    <!-- Tabla de ventas completadas -->
    <table class="table">
        <thead>
            <tr>
                <!-- Columnas de la tabla -->
                <th>N°</th>
                <th>CLIENTE</th>
                <th>LOTE - MANZANA</th>
                <th>FECHA V.</th>
                <th>P.VENTA</th>
            </tr>
        </thead>
        <tbody>
            <!-- Iterar a través de las ventas para mostrar los detalles -->
            @foreach ($ventas as $index => $venta)
            <tr>
                <!-- Número de fila -->
                <td>{{ $index + 1 }}</td>
                <!-- Información del cliente -->
                <td>{{ $venta['cliente'] }}</td>
                <!-- Detalle del lote y manzana -->
                <td>{{ $venta['lote_manzana'] }}</td>
                <!-- Fecha de la venta, formateada correctamente -->
                <td>{{ $venta['fecha_venta'] }}</td>
                <!-- Precio de venta, formateado como moneda -->
                <td>${{ number_format($venta['precio_venta'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Mostrar el total acumulado de las ventas -->
    <div class="totals">
        TOTAL VENTAS: ${{ number_format($totalVentas, 2) }}
    </div>
</body>

</html>