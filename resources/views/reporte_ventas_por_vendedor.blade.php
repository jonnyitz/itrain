<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas por Vendedor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h4>REPORTE DE VENTAS - DESDE {{ $fechaInicio }} HASTA {{ $fechaFin }} - {{ strtoupper($vendedorSeleccionado) }}</h4>
    </div>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>AGENTE DE VENTAS</th>
                <th>CLIENTE</th>
                <th>LOTE - MANZANA</th>
                <th>FECHA</th>
                <th>TIPO</th>
                <th>PRECIO VENTA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $index => $venta)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $venta->vendedor }}</td>
                    <td>{{ $venta->contacto->nombre ?? 'N/A' }}</td>
                    <td>Lote {{ $venta->lote->nombre ?? 'N/A' }} - Manzana {{ $venta->manzana->nombre ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha_hora_pago)->format('d/m/Y') }}</td>
                    <td>{{ $venta->tipo_venta }}</td>
                    <td>${{ number_format($venta->precio_venta_final, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="6" style="text-align: right;">TOTAL</td>
                <td>${{ number_format($totalVentas, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
