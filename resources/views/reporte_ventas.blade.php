<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Reporte de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Lote - Manzana</th>
                <th>Fecha de Venta</th>
                <th>Tipo de Venta</th>
                <th>Precio de Venta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <!-- Cliente -->
                    <td>{{ $venta->contacto ? $venta->contacto->nombre : 'No asignado' }}</td>
                    <!-- Lote - Manzana -->
                    <td>{{ $venta->manzana ? $venta->manzana->nombre : 'No asignado' }}</td>
                    <!-- Fecha de Venta -->
                    <td>{{ $venta->fecha_venta }}</td>
                    <!-- Tipo de Venta -->
                    <td>{{ $venta->tipo_venta }}</td>
                    <!-- Precio de Venta -->
                    <td>{{ number_format($venta->precio_venta_final, 2) }}</td>     
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
