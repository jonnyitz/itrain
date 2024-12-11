<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronograma de Pagos</title>
    <style>
        /* Estilo para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* Estilo para las celdas de la tabla */
        td {
            font-size: 14px;
        }

        /* Espaciado entre las filas */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .logo {
            width: 150px; /* Ajusta el tamaño de la imagen */
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" class="logo">

    <p><strong>Cliente:</strong> {{ $contacto->nombre }}</p>
    <p><strong>Lote/Manzana:</strong> {{ $venta->lote->lote }}</p>
    <p><strong>Precio Total de la Venta:</strong> ${{ number_format($venta->precio_venta_final, 2) }}</p>
    <p><strong>Enganche:</strong> ${{ number_format($venta->enganche, 2) }}</p>
    <p><strong>Monto Restante:</strong> ${{ number_format($montoRestante, 2) }}</p>
    
    <h3>Cronograma de Pagos:</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Fecha de Pago</th>
                <th>Monto Restante</th>
                <th>Primer Pago</th>
            </tr>
        </thead>
        <tbody>
            @php
                $fechaPago = $fechaVenta;
                $pagos = 36; // Suponiendo que hay 6 pagos
            @endphp
            @for($i = 1; $i <= $pagos; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $fechaPago->format('d/m/Y') }}</td>
                    <td>${{ number_format($montoRestante, 2) }}</td>
                    <td>${{ number_format($venta->enganche, 2) }}</td>
                </tr>
                @php
                    // Incrementamos la fecha de pago por un mes
                    $fechaPago->addMonth();
                    $montoRestante -= ($venta->enganche / $pagos); // Ejemplo de cómo distribuir el monto restante
                @endphp
            @endfor
        </tbody>
    </table>
</body>
</html>
