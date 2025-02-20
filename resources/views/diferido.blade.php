<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cronograma de Pagos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .logo {
            width: 120px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
<img src="{{ public_path('images/logo.png') }}" alt="Logo" class="logo">

<p><strong>Cliente:</strong> {{ $venta->contacto->nombre }}  {{ $venta->contacto->apellidos }}</p>
<p><strong>Lote/Manzana:</strong> {{ $venta->lote->manzana->nombre }} - {{ $venta->lote->lote }}</p>
<p><strong>Precio Total de la Venta:</strong> ${{ number_format($venta->precio_venta_final, 2) }}</p>
<p><strong>Enganche:</strong> ${{ number_format($venta->enganche, 2) }}</p>

<h3>Cronograma de Número de Pagos Diferidos:</h3>
<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Fecha de Pago</th>
            <th>Monto Diferido</th>
            <th>Monto Restante</th>
        </tr>
    </thead>
    <tbody>
    @php
    $fechaPago = \Carbon\Carbon::parse($venta->fecha_venta);
    // Usamos la cantidad de pagos y enganche
    $cantidadPagos = $venta->cantidad_pagos ?? 1; // Usamos 1 como valor predeterminado

    // Realizamos el cálculo solo con el enganche y la cantidad de pagos
    if ($cantidadPagos > 0) {
        $montoDiferido = $venta->enganche / $cantidadPagos; // Dividimos el enganche entre la cantidad de pagos
    } else {
        $montoDiferido = 0; // Evitamos la división por cero
    }

    $montoRestante = $venta->enganche; // Inicializamos el monto restante
    @endphp
       @for($i = 1; $i <= $cantidadPagos; $i++)
    <tr>
        <td>{{ $i }}</td>
        <td>{{ $fechaPago->format('d/m/Y') }}</td>
        <td>${{ number_format($montoDiferido, 2) }}</td> <!-- Pago diferido -->
        <td>${{ number_format($montoRestante - $montoDiferido, 2) }}</td> <!-- Monto restante -->
    </tr>
            @php
                 $fechaPago->addMonthsNoOverflow(1);// Sumar un mes para el siguiente pago
                 $montoRestante -= $montoDiferido; // Restamos el monto diferido para cada pago
            @endphp
        @endfor
    </tbody>
</table>
</body>
</html>
