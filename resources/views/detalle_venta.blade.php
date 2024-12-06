<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Venta</title>
    <style>
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
            background-color: #f2f2f2;
        }
        .highlight {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Reporte Detalle de Venta</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Lote - Manzana</th>
                <th>Teléfono</th>
                <th>Fecha Pago</th>
                <th>T. Cuota</th>
                <th>Cant.</th>
                <th>Monto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $key => $venta)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $venta->contacto->nombre ?? 'No asignado' }}</td>
                    <td>
                        Lote: {{ $venta->manzana->nombre ?? 'No asignado' }}
                    </td>
                    <td>{{ $venta->contacto->telefono ?? 'No asignado' }}</td>
                    <td class="highlight">
                        {{ $venta->ultima_fecha ? \Carbon\Carbon::parse($venta->ultima_fecha)->format('d/m/Y') : 'No asignado' }}
                    </td>
                    <td>{{ $venta->modalidad_enganche ?? 'Mensual' }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>${{ number_format($venta->total / $venta->cantidad, 2) }}</td>
                    <td>${{ number_format($venta->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
