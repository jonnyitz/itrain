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

<p><strong>Cliente:</strong> {{ $contacto->nombre }} {{ $venta->contacto->apellidos }}</p>
<p><strong>Manzana/Lote:</strong>  {{ $venta->lote->manzana ? $venta->lote->manzana->nombre : 'No disponible' }} - 
{{ $venta->lote->lote }} </p>
<p><strong>Precio Total de la Venta:</strong> ${{ number_format($venta->precio_venta_final, 2) }}</p>
<p><strong>Enganche:</strong> ${{ number_format($venta->enganche, 2) }}</p>

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
            $fechaPago = \Carbon\Carbon::parse($venta->fecha_hora_pago); // Usamos la fecha de la venta como punto de inicio
            $mesesSeleccionados = $venta->meses ?? 1; // Número de meses seleccionados
            $montoRestante = $venta->precio_venta_final - $venta->enganche; // Calculamos el monto restante
            $primerPago = $montoRestante / $mesesSeleccionados; // Primer pago calculado
        @endphp

        @for($i = 1; $i <= $mesesSeleccionados; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $fechaPago->format('d/m/Y') }}</td>
                <td>${{ number_format($montoRestante, 2) }}</td>
                <td>${{ number_format($primerPago, 2) }}</td>
            </tr>
            @php
                // Incrementamos la fecha de pago por un mes
                $fechaPago->addMonth();
                // Restamos el monto del primer pago del monto restante
                $montoRestante -= $primerPago;
                // Nos aseguramos de no mostrar un monto restante negativo
                if ($montoRestante < 0) {
                    $montoRestante = 0;
                }
            @endphp
        @endfor
    </tbody>
</table>
</body>
</html>
