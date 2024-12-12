<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista Total de Lotes de Terreno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1, .header h2 {
            margin: 0;
        }
        .header h1 {
            font-size: 16px;
        }
        .header h2 {
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CONSTRUCTORA FDR</h1>
        <h2>CALLEJÓN DE QUIJANO #236 - ZACATECAS</h2>
        <h3>Teléfono: 492-161-68-35</h3>
        <h2>{{ $proyecto }}</h2>
        <h3>LISTA TOTAL DE LOTES DE TERRENO</h3>
        <p>Fecha del Reporte: {{ $fecha_reporte }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>MANZANA - LOTE</th>
                <th>ÁREA</th>
                <th>COSTO</th>
                <th>P.VENTA</th>
                <th>UTILIDAD</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lotes as $index => $lote)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $lote['manzana_lote'] }}</td>
                    <td>{{ $lote['area'] }} M²</td>
                    <td>${{ number_format($lote['costo'], 2) }}</td>
                    <td>${{ number_format($lote['precio_venta'], 2) }}</td>
                    <td>${{ number_format($lote['utilidad'], 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">TOTALES</td>
                <td>${{ number_format($totalCosto, 2) }}</td>
                <td>${{ number_format($totalVenta, 2) }}</td>
                <td>${{ number_format($totalUtilidad, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
